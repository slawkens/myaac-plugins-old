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
$title = 'Points';

require_once(LIBS . 'shop-system.php');
require_once(PLUGINS . 'gesior-shop-system/config.php');
$twig->addGlobal('config', $config);

if(!$config['gifts_system'])
{
	if(!admin())
	{
		echo 'The gifts system is disabled there, sorry.';
		return;
	}
	else
		warning("You're able to access this page but it is disabled for normal users.<br/>
		Its enabled for you so you can view/edit shop offers before displaying them to use.<br/>
		You can enable it by editing this line in myaac config.local.php file:<br/>
		<p style=\"margin-left: 3em;\"><b>\$config['gifts_system'] = true;</b></p>");
}

if(GesiorShop::getDonationType() == 'coins' && !fieldExist('coins', 'accounts')) {
	error("Your server doesn't support accounts.coins. Please change back config.donation_type to points.");
	return;
}

if(!$logged) {
	$was_before = $config['friendly_urls'];
	$config['friendly_urls'] = true;

	echo 'To buy points you need to be logged. ' . generateLink(getLink('?subtopic=accountmanagement') . '&redirect=' . urlencode(BASE_URL . '?subtopic=points'), 'Login first') . '.';

	$config['friendly_urls'] = $was_before;
	return;
}

$enabled = array(
	'paypal' => isset($config['paypal']) && $config['paypal']['enabled'],
	'fortumo' => isset($config['fortumo']) && $config['fortumo']['enabled'],
	'cryptobox' => isset($config['cryptobox']) && $config['cryptobox']['enabled'],
	'daopay' => isset($config['daopay']) && $config['daopay']['enabled'],
	'pagseguro' => isset($config['pagseguro']) && $config['pagseguro']['enabled'],
	'dotpay' => isset($config['dotpay']) && $config['dotpay']['enabled'],
);

if(isset($_GET['system'])) {
	$system = $_GET['system'];
	$to_load = $system;

	if(isset($_GET['redirect'])) {
		$to_load = $system . '_redirect';
	}

	if(!ctype_alnum(str_replace(array('-', '_'), '', $_GET['system']))) {
		error('Error: System contains illegal characters.');
	}
	else {
		$file = SYSTEM . 'payments/' . $to_load . '.php';
		if(file_exists($file) && $enabled[$system]) {
			require($file);
		}
	}
}
else {
	echo $twig->render('gesior-shop-system/points.html.twig', array('enabled' => $enabled));
}
?>
<script type="text/javascript">
$(function() {
	$('#account-name-input').focus();
});
</script>
