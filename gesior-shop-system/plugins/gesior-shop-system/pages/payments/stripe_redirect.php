<?php
defined('MYAAC') or die('Direct access not allowed!');

require_once PLUGINS . 'gesior-shop-system/config.php';
require_once PLUGINS . 'gesior-shop-system/vendor/autoload.php';

if(!isset($config['stripe']) || !count($config['stripe']) || !$config['stripe']['enabled'] ||!count($config['stripe']['payments'])) {
	die('Stripe disabled.');
}

/** @var bool $logged */
if (!$logged) {
	echo 'You need to be logged.';
	return;
}

if(!isset($_POST['id'])) {
	echo 'Please enter id.';
	return;
}

if(!isset($_POST['accountId'])) {
	echo 'Please enter account id.';
	return;
}

$accountId = (string) $_POST['accountId'];
$id = (int)$_POST['id'];

if (!isset($config['stripe']['payments'][$id])) {
	echo 'Invalid config!';
	return;
}

$offer = $config['stripe']['payments'][$id];
if (!$offer) {
	echo 'Invalid offer!';
	return;
}

\Stripe\Stripe::setApiKey($config['stripe']['secret_key']);

$checkoutSession = \Stripe\Checkout\Session::create([
	'client_reference_id' => $accountId,
	'line_items' => [[
		'price_data' => [
			'currency' => $offer['currency'],
			'product_data' => [
				'name' => $offer['name'],
			],

			'unit_amount' => round($offer['price'] * 100, 2),
		],
		'quantity' => 1,
	]],
	'mode' => 'payment',
	'success_url' => BASE_URL . '?subtopic=gifts&success',
	'cancel_url' => BASE_URL . '?subtopic=gifts&cancel',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkoutSession->url);

function sendError($message)
{
	http_response_code(400);

	echo json_encode([
		'error' => $message
	]);

	exit();
}
