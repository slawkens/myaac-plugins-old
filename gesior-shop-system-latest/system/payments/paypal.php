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

if(!$logged) {
	$was_before = $config['friendly_urls'];
	$config['friendly_urls'] = true;
	
	echo 'To buy points you need to be logged. ' . generateLink(getLink('?subtopic=accountmanagement') . '&redirect=' . urlencode(BASE_URL . '?subtopic=points&system=paypal'), 'Login') . ' first to make a donate.';
	
	$config['friendly_urls'] = $was_before;
	return;
}

if(!function_exists('curl_init')) {
	error(sprintf("Error. Please enable <a target='_blank' href='%s'>CURL extension</a> in PHP. <a target='_blank' href='%s'>Read here &#187;</a>", "http://php.net/manual/en/book.curl.php", "http://stackoverflow.com/questions/1347146/how-to-enable-curl-in-php-xampp"));
	return;
}

if(!in_array($config['paypal']['payment_type'], array('_xclick', '_donations'))) {
	error('Unsupported $config paypal payment_type: ' . $config['paypal']['payment_type'] . '. Please go to your config.php and fix it.');
	return;
}

$is_localhost = strpos(BASE_URL, 'localhost') !== false || strpos(BASE_URL, '127.0.0.1') !== false;
if($is_localhost) {
	warning("Paypal is not supported on localhost (" . BASE_URL . "). Please change your domain to public one and visit this site again later.<br/>
	This site is visible, but you can't donate.");
}

$was_before = $config['friendly_urls'];
$config['friendly_urls'] = false;
if(empty($config['paypal']['contact_email'])) {
	$config['paypal']['contact_email'] = $config['paypal']['email'];
	$twig->addGlobal('config', $config);
}

if($config['paypal']['terms'] && !isset($_REQUEST['agree'])) {
	$twig->display('gesior-shop-system/paypal-terms.html.twig');
}
else {
	$twig->display('gesior-shop-system/paypal.html.twig', array('is_localhost' => $is_localhost));
}

$config['friendly_urls'] = $was_before;