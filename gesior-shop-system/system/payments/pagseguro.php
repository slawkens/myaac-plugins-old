<?php
/**
 * Automatic PagSeguro payment system gateway.
 *
 * @name      myaac-pagseguro
 * @author    Ivens Pontes <ivenscardoso@hotmail.com>
 * @author    Slawkens <slawkens@gmail.com>
 * @website   github.com/slawkens/myaac-pagseguro
 * @website   github.com/ivenspontes/
 * @version   1.1.1
 */
defined('MYAAC') or die('Direct access not allowed!');

require_once(PLUGINS . 'gesior-shop-system/config.php');
$twig->addGlobal('config', $config);

if(!isset($config['pagseguro']) || !$config['pagseguro']['enabled']) {
	echo "PagSeguro is disabled. If you're an admin please configure this script in plugins/gesior-shop-system/config.php.";
	return;
}

$is_localhost = strpos(BASE_URL, 'localhost') !== false || strpos(BASE_URL, '127.0.0.1') !== false;
if($is_localhost) {
	warning("PagSeguro is not supported on localhost (" . BASE_URL . "). Please change your domain to public one and visit this site again later.<br/>
	This site is visible, but you can't donate.");
}

if(empty($action)) {
	if(!$logged) {
		$was_before = $config['friendly_urls'];
		$config['friendly_urls'] = true;

		echo 'To buy points you need to be logged. ' . generateLink(getLink('?subtopic=accountmanagement') . '&redirect=' . urlencode(BASE_URL . '?subtopic=points'), 'Login') . ' first to make a donate.';

		$config['friendly_urls'] = $was_before;
	}
	else {
		echo $twig->render('gesior-shop-system/pagseguro.html.twig', array('is_localhost' => $is_localhost));
	}
}
elseif($action == 'final') {
	echo $twig->render('gesior-shop-system/donate-final.html.twig');
}