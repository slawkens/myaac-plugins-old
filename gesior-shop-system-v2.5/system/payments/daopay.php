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

function check_code_daopay($appcode, $prodcode, $pin)
{
	$handle = fopen("http://DaoPay.com/svc/PINcheck?appcode=".$appcode."&subkey=".$prodcode."&pin=".$pin, 'r');
	if ($handle)
	{
	    $status = fgets($handle, 128);
		fclose($handle);
		if($status[0] == 'o' && $status[1] == 'k')
		{

			$return = 1;
		}
		else
			$return = 2;
	}
	else
		$return = 3;
	return $return;
}

	#################################################################################
	$offer_id = (int) $_POST['offer_id'];
	$posted_pincode = trim($_REQUEST['pin']);
	$prodcode = trim($_POST['prodcode']);

	$to_user = trim($_POST['to_user']);
	if(!isset($to_user[0]) && $logged)
		$to_user = $account_logged->getName();
	#################################################################################
	if(!empty($posted_pincode))
	{
		$account = new OTS_Account();
		$account->find($to_user);
		if(!$account->isLoaded())
		{
			$player = new OTS_Player();
			$player->find($to_user);
			if($player->isLoaded())
				$account = $player->getAccount();
		}

		if(empty($posted_pincode))
			$errors[] = 'Please enter your PIN code.';

		if(!$account->isLoaded())
			$errors[] = 'Account / player with this name doesn\'t exist.';

		if(count($errors) == 0)
		{
			$code_info = check_code_daopay($config['daopay']['options'][$offer_id]['appcode'], $config['daopay']['options'][$offer_id]['prodcode'], $posted_pincode);
			if($code_info == 3)
				$errors[] = 'Server has problem with connection to daopay.com, can\'t verify PIN code.';
			elseif($code_info == 2)
				$errors[] = 'Wrong PIN code, try to enter code again.';
			elseif($code_info == 1)
			{
				if(GesiorShop::changePoints($account, $config['daopay']['options'][$offer_id]['points']))
				{
					$time = date('d.m.Y, g:i A');
					$account_id = $account->getId();
					log_append('daopay.log', "$time;$account_id;$to_user;$posted_pincode;$offer_id");

					echo '<h2><font color="red">Good PIN code. Added '.$config['daopay']['options'][$offer_id]['points'].' Premium Points to account of: '.$to_user.' !</font></h2>';
				}
				else
					$errors[] = 'Cannot add points. Account does not exist?';
			}
		}
	}

	if(!empty($errors))
		echo $twig->render('error_box.html.twig', array('errors' => $errors));

	echo 'Buy Premium Points. For this points you can buy pacc/items in Shop. To buy points:<br />
	1. Visit one of our pages and donate us (send SMS/call special number).<br />
	2. After donate daopay.com will show you PIN code.<br />
	3. Save somewhere this PIN code and open this page again.<br />
	4. Enter your character name or account and your PIN code in form below.<br />
	5. Select donation cost from list and press "Check Code".<br />
	6. If account and PIN code is valid you get premium points.<br />
	7. Open "Shop Offer" and buy items/pacc :)<br />
	<font color="red"><b>Our pages:</b></font>';
	foreach($config['daopay']['options'] as $offer)
		echo '<br /><b>* Address <font color="red"><a href="http://daopay.com/payment/?appcode='.urlencode($offer['appcode']).'&prodcode='.urlencode($offer['prodcode']).'&subtopic=points&system=daopay">http://daopay.com/payment/?appcode='.urlencode($offer['appcode']).'&prodcode='.urlencode($offer['prodcode']).'</a></font> - <font color="red"><b>'.$offer['cost'].'</b></font> - <font color="red"><b>'.$offer['points'].'</b></font> premium points</b>';
	echo '<hr /><form action="?subtopic=points&system=daopay" method="POST"><table>';
	echo '
	<tr>
		<td><b>Account name: </b></td>
		<td><input type="text" size="20" value="'.$to_user.'" name="to_user" id="account-name-input" /></td>
	</tr>
	<tr>
		<td><b>PIN code: </b></td>
		<td><input type="text" size="20" value="'.$posted_pincode.'" name="pin" /></td>
	</tr>
		<tr>
			<td><b>Offer type: </b></td><td><select name="offer_id">';
	foreach($config['daopay']['options'] as $id => $offer)
		echo '<option value="'.$id.'" ' . ($id == $offer_id ? 'selected' : '') . '>'.$offer['prodcode'].' - cost '.$offer['cost'].' - points '.$offer['points'].'</option>';
?>
	</select></td></tr>
	<tr><td></td><td><input type="submit" value="Check Code" /></td></tr></table></form>