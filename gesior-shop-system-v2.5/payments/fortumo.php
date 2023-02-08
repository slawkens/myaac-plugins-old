<?php
/**
 * This is shop system taken from Gesior, modified for MyAAC.
 *
 * @name      myaac-gesior-shop-system
 * @author    Gesior <jerzyskalski@wp.pl>
 * @author    Slawkens <slawkens@gmail.com>
 * @website   github.com/slawkens/myaac-gesior-shop-system
 */

require_once '../common.php';
require_once SYSTEM . 'functions.php';
require_once SYSTEM . 'init.php';
require_once LIBS . 'shop-system.php';
require_once PLUGINS . 'gesior-shop-system/config.php';

if(!isset($config['fortumo']) || !count($config['fortumo']) || empty($config['fortumo']['service_id'])) {
	log_append('fortumo_debug.log', 'Fortumo is disabled. IP: ' . $_SERVER['REMOTE_ADDR']);
	header("HTTP/1.0 404 Not Found");
	die("Error: Fortumo is disabled");
}

 // check that the request comes from Fortumo server
if(!in_array($_SERVER['REMOTE_ADDR'], array('54.72.6.23', '54.72.6.126', '54.72.6.27', '54.72.6.17', '79.125.125.1', '79.125.5.95', '79.125.5.205'))) {
	log_append('fortumo_scammer.log', $_SERVER['REMOTE_ADDR']);
	header("HTTP/1.0 403 Forbidden");
	die("Error: Unknown IP");
}

// check the signature
$secret = $config['fortumo']['secret'];
if(empty($secret) || !check_signature($_GET, $secret)) {
	log_append('fortumo_debug.log', 'Invalid signature: ' . $secret);
	header("HTTP/1.0 404 Not Found");
	die("Error: Invalid signature");
}

if($_GET['status'] != 'completed')
{
	log_append('fortumo_debug.log', 'Transaction status: ' . $_GET['status']);
	return;
}

$account = new OTS_Account();
$account_id = (int)$_GET['cuid'];
$account->load($account_id);
if($account->isLoaded()) {
	$points = (int)$_GET['amount'];
	if(GesiorShop::changePoints($account, $points)) {
		$time = date('d.m.Y, g:i A');
		$account_id = $account->getId();
		$price = $_GET['price'];
		$currency = $_GET['currency'];
		$payment_id = $_GET['payment_id'];
		$service_id = $_GET['service_id'];
		$country = $_GET['country'];
		$operator = $_GET['operator'];
		$sender = $_GET['sender'];
		log_append('fortumo.log', "$time;$account_id;$points;$price:$currency;$payment_id;$service_id;$country;$operator;$sender");
	}
}
else
	log_append('fortumo_debug.log', 'Invalid account used: ' . $account_id . '. Payment id: ' . $_GET['payment_id']);

function check_signature($params_array, $secret)
{
	ksort($params_array);

	$str = '';
	foreach ($params_array as $k=>$v) {
		if($k != 'sig') {
			$str .= "$k=$v";
		}
	}

	$str .= $secret;
	$signature = md5($str);

	return ($params_array['sig'] == $signature);
}