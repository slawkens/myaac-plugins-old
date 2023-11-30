<?php
defined('MYAAC') or die('Direct access not allowed!');

require_once PLUGINS . 'gesior-shop-system/vendor/autoload.php';
require_once PLUGINS . 'gesior-shop-system/config.php';

$twig->addGlobal('config', $config);

if(!isset($config['stripe']) || !count($config['stripe']) || !$config['stripe']['enabled'] ||!count($config['stripe']['payments'])) {
	echo "Stripe is disabled. If you're an admin please configure this script in plugins/gesior-shop-system/config.php.";
	return;
}

/** @var bool $logged */
if (!$logged) {
	echo 'You are not logged in. Login first to buy points.';
	return;
}

$twig->display('gesior-shop-system/templates/stripe.html.twig');
