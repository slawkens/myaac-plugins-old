<?php
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Gifts History';

require_once(PLUGINS . 'gesior-shop-system/libs/shop-system.php');

$errors = [];
if(!$logged || !$account_logged->isLoaded()) {
	$errors[] = 'Please login first';
	$twig->display('error_box.html.twig', ['errors' => $errors]);
	return;
}

GesiorShop::showHistoryAction($account_logged);
