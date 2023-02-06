<?php
/**
 * This is shop system taken from Gesior, modified for MyAAC.
 *
 * @name      myaac-gesior-shop-system
 * @author    Slawkens <slawkens@gmail.com>
 * @website   github.com/slawkens/myaac-gesior-shop-system
 */
defined('MYAAC') or die('Direct access not allowed!');

require_once(PLUGINS . 'gesior-shop-system/config.php');

$twig->addGlobal('config', $config);

if(!isset($config['cryptobox']) || !$config['cryptobox']['enabled']) {
	echo "CryptoBox is disabled. If you're an admin please configure this script in plugins/gesior-shop-system/config.php.";
	return;
}

$is_localhost = strpos(BASE_URL, 'localhost') !== false || strpos(BASE_URL, '127.0.0.1') !== false;
if($is_localhost) {
	warning("CryptoBox is not supported on localhost (" . BASE_URL . "). Please change your domain to public one and visit this site again later.<br/>
	This site is visible, but you can't donate.");
}

if(empty($action)) {
	echo $twig->render('gesior-shop-system/cryptobox.html.twig', array('is_localhost' => $is_localhost));
}

