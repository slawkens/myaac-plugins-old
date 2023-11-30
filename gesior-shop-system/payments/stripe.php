<?php

require_once '../common.php';
require_once SYSTEM . 'functions.php';
require_once SYSTEM . 'init.php';
require_once PLUGINS . 'gesior-shop-system/libs/shop-system.php';
require_once PLUGINS . 'gesior-shop-system/config.php';
require_once PLUGINS . 'gesior-shop-system/vendor/autoload.php';

if(!isset($config['stripe']) || !count($config['stripe']) || !count($config['stripe']['payments'])) {
	die('Stripe disabled.');
}

\Stripe\Stripe::setApiKey($config['stripe']['secret_key']);

$payload = @file_get_contents('php://input');
$event = null;

if (empty($payload)) {
	http_response_code(200);
	exit();
}

try {
	$event = \Stripe\Webhook::constructEvent(
		$payload,
		$_SERVER['HTTP_STRIPE_SIGNATURE'],
		$config['stripe']['endpoint_secret']
	);
} catch (\UnexpectedValueException $e) {
	stripe_log_append_die('Invalid payload', $e->getMessage());
} catch (\Stripe\Exception\SignatureVerificationException $e) {
	stripe_log_append_die('Invalid signature', $e->getMessage());
	exit();
}

if ($event->type !== 'checkout.session.completed') {
	return; // other events don't interest us
	//stripe_log_append_die('Invalid event type', '');
}

$paymentIntent = $event->data->object;

$checkIfExists = $db->query('SELECT * FROM `stripe` WHERE `payment_id` = "' . $paymentIntent->id . '"')->fetch();

if ($checkIfExists) {
	stripe_log_append_die('Payment already exists', "PaymentId: {$paymentIntent->id}");
}

if ($paymentIntent->payment_status != 'paid') {
	stripe_log_append_die('Payment status is not paid', "Payment Status: {$paymentIntent->payment_status}");
}

$accountId = $paymentIntent->client_reference_id;
$account = new OTS_Account();
$account->load($accountId);
if (!$account->isLoaded()) {
	stripe_log_append_die('Account not found', "AccountId: $accountId");
}

$offer = getStripeOfferByPrice($paymentIntent->amount_total);
if (!$offer) {
	stripe_log_append_die('Invalid offer', "Amount: {$paymentIntent->amount_total}");
}

$payerMail = 'unknown@nomail.com';
if (isset($paymentIntent->customer_details->email)) {
	$payerMail = $paymentIntent->customer_details->email;
}

if (GesiorShop::changePoints($account, $offer['points'])) {
	$db->insert('stripe', [
		'payment_id' => $paymentIntent->id,
		'account_id' => $accountId,
		'email' => $payerMail,
		'points' => $offer['points'],
		'price' => $offer['price'],
		'currency' => $offer['currency'],
		'api_version' => $event->api_version,
		'created' => date('Y-m-d H:i:s'),
	]);
}

http_response_code(200);
exit;

function stripe_log_append_die($str, $logMessage = '')
{
	http_response_code(400);
	log_append('stripe-error.log', $str . ' - ' . $logMessage);

	echo json_encode([
		'error' => $str
	]);

	exit;
}

function getStripeOfferByPrice($price)
{
	$stripe = config('stripe');

	foreach ($stripe['payments'] as $offer) {
		if ($offer['price'] == round($price / 100, 2)) {
			return $offer;
		}
	}

	return null;
}
