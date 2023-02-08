<?php
/**
 * This is shop system taken from Gesior, modified for MyAAC.
 *
 * @name      myaac-gesior-shop-system
 * @author    Gesior <jerzyskalski@wp.pl>
 * @author    Slawkens <slawkens@gmail.com>
 * @website   github.com/slawkens/myaac-gesior-shop-system
 */
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Dotpay';

function check_code_dotpay($code, $posted_code, $user_id, $type)
{
	$handle = fopen("http://dotpay.pl/check_code_fullinfo.php?id=".$user_id."&code=".$code."&check=".$posted_code."&type=".$type."&del=0", 'r');
	//$tmp = explode(" ", fgets($handle, 256));

	$ret = array(
		trim(fgets($handle, 8)), // status
		trim(fgets($handle, 24)), // time to live
		trim(fgets($handle, 1024)), // usługe
		trim(fgets($handle, 64)) // koszt
	);
	fclose($handle);

	return $ret;
/*
	$status = fgets($handle, 8);
	$czas_zycia = fgets($handle, 24);
	fclose($handle);
	$czas_zycia = rtrim($czas_zycia);
	return array($status, $czas_zycia);*/
}

function delete_code_dotpay($code, $posted_code, $user_id, $type)
{
	$handle = fopen("http://dotpay.pl/check_code.php?id=".$user_id."&code=".$code."&check=".$posted_code."&type=".$type."&del=1", 'r');
    fclose($handle);
}

$posted_code = isset($_POST['code']) ? $_POST['code'] : '';
if(USE_ACCOUNT_NAME) {
	$to_user = $account_logged->getName();
}
else {
	$to_user = $account_logged->getId();
}

if(isset($_POST['sms_type'])) {
	$sms_type = (int) $_POST['sms_type'];

	if(empty($posted_code))
		$errors[] = 'Proszę wpisać kod z SMSa/przelewu.';

	if(!isset($config['dotpay']['options'][$sms_type]))
		$errors[] = 'Wybrany typ sms z rozwijanej listy nie istnieje.';

	if(preg_match("/[^a-zA-Z0-9]/", $posted_code))
		$errors[] = 'Podany kod SMS jest nie poprawny. Kod może zawierać tylko litery oraz cyfry, inne znaki są niedozwolone.';

	if(count($errors) == 0)
	{
		$code_info = check_code_dotpay($config['dotpay']['options'][$sms_type]['code'], $posted_code, $config['dotpay']['id'], $config['dotpay']['options'][$sms_type]['type']);
		//var_dump($code_info);
		//var_dump($config['dotpay']['options'][$sms_type]['type'] == 'sms');
		if($code_info[0] == 0) // ||
			//($config['dotpay']['options'][$sms_type]['type'] == 'sms' && (int)$code_info[3] != 0 && (int)$code_info[3] != $config['dotpay']['options'][$sms_type]['cost']))
			$errors[] = 'Podany kod z SMSa/przelewu jest niepoprawny lub wybrano złą opcję SMSa/przelewu.';
		else
		{
			//$points_to_add = $config['dotpay']['options'][$sms_type]['points'];
			$points_to_add = 0;
			foreach($config['dotpay']['options'] as $option)
			{
				if($option['type'] == 'sms')
				{
					if((int)$code_info[3] == (int)$option['cost'])
					{
						$points_to_add = $option['points'];
						break;
					}
				}
				else
				{
					if($code_info[2] == $option['code'])
					{
						$points_to_add = $option['points'];
						break;
					}
				}
			}

			if($code_info[3] == "0.00")
				$points_to_add = $config['dotpay']['options'][$sms_type]['points'];

			if($points_to_add > 0 && GesiorShop::changePoints($account_logged, $points_to_add))
			{
				$time = date('d.m.Y,g:i A');
				$account_id = $account_logged->getId();
				log_append('dotpay.log', "$time;$account_id;$posted_code");

				delete_code_dotpay($config['dotpay']['options'][$sms_type]['code'], $posted_code, $config['dotpay']['options']['id'], $config['dotpay']['options'][$sms_type]['type']);
				echo '<h1><font color="red">Dodano '.$points_to_add.' punktów premium do konta: '.$to_user.' !</font></h1>';
			}
			else
				$errors[] = 'Wystąpił błąd podczas dodawania punktów do konta, spróbuj ponownie.';
		}
	}
}

if(!empty($errors))
	echo $twig->render('error_box.html.twig', array('errors' => $errors));

$sms_enabled = false;
foreach($config['dotpay']['options'] as $option)
{
	if($option['type'] == 'sms')
		$sms_enabled = true;
}

if($sms_enabled)
{
	echo '<h2>Doładowanie Punktowe - SMS</h2>Kup punkty premium, możesz je wymienić w sklepie OTSa na przedmioty w grze, aby zakupić punkty premium wyślij SMSa:';
	foreach($config['dotpay']['options'] as $sms)
	{
		if($sms['type'] == 'sms')
			echo '<br /><b>* Na numer <font color="red">'.$sms['sms_number'].'</font> o treści <font color="red"><b>AP.'.$sms['code'].'</b></font> za <font color="red"><b>'.$sms['cost'].' zł z VAT (brutto)</b></font>, a za kod dostaniesz <font color="red"><b>'.$sms['points'].'</b></font> punktów premium.</b>';
	}

	echo '<br />W odpowiedzi otrzymasz SMS z specjalnym kod. Wpisz ten kod w formularzu wraz z <b>nazwą konta</b> osoby, która ma otrzymać punkty.<br />
	Usługa SMS dostępna jest w sieciach Era, Plus GSM, Orange i Play.<br />
	Usługi Premium SMS dostarcza i obsługuje <a href="http://www.dotpay.pl" target="_blank">Dotpay</a><br />
	Regulamin: <a href="http://www.dotpay.pl/regulaminsms" target="_blank">http://www.dotpay.pl/regulaminsms</a><br />
	Reklamacje: <a href="http://www.dotpay.pl/reklamacje" target="_blank">http://www.dotpay.pl/reklamacje</a><br />
	Kontakt z właścicielem serwisu: <a href="mailto:'.$config['dotpay']['contact_email'].'"/>'.$config['dotpay']['contact_email'].'</a><hr />';
}

$transfer_enabled = false;
foreach($config['dotpay']['options'] as $option)
{
	if($option['type'] == 'C1')
		$transfer_enabled = true;
}

if($transfer_enabled)
{
	echo '<h2>Przelew/karta kredytowa</h2>Kup punkty premium, możesz je wymienić w sklepie OTSa na PACC/przedmioty w grze, aby zakupić punkty premium wejdź na jeden z adresow i wypełnij formularz:';
	foreach($config['dotpay']['options'] as $przelew)
		if($przelew['type'] == 'C1')
			echo '<br /><b>* Adres - <a href="https://ssl.dotpay.pl/?id='.$config['dotpay']['id'].'&code='.$przelew['code'].'" target="_blank"><font color="red">https://ssl.dotpay.pl/?id='.$config['dotpay']['id'].'&code='.$przelew['code'].'</font></a> - koszt <font color="red"><b>'.$przelew['cost'].' zł z VAT (brutto)</b></font>, a za kod dostaniesz <font color="red"><b>'.$przelew['points'].'</b></font> punktów premium.</b>';
	echo 'Kiedy Twój przelew dojdzie (z kart kredytowych i banków internetowych z listy jest to kwestia paru sekund) na e-mail ktory podaleś w formularzu otrzymasz kod. Kod ten możesz wymienić na tej stronie na punkty premium w formularzu poniżej.<hr />';
}
echo '<form action="?subtopic=points&system=dotpay" method="POST"><table>
<tr>
	<td><b>Kod z SMSa: </b></td>
	<td><input type="text" size="20" value="'.$posted_code.'" name="code" /></td>
</tr>
<tr>
	<td><b>Typ wysłanego SMSa: </b></td><td><select name="sms_type">';
foreach($config['dotpay']['options'] as $id => $sms)
	if($sms['type'] == 'sms')
		echo '<option value="'.$id.'">numer ' . $sms['sms_number'] . ' - kod '.$sms['code'].' - SMS za '.$$sms['cost'].' zł z VAT (brutto)</option>';
	elseif($przelew['type'] == 'C1')
		echo '<option value="'.$id.'">przelew - kod '.$sms['code'].' - za '.$sms['cost'].' zł z VAT (brutto)</option>';
echo '</select></td></tr>';

echo '<tr><td></td><td><input type="submit" value="Sprawdź" /></td></tr></table></form>';