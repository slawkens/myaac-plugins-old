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
$title = 'PagSeguro donation';

if(!isset($_POST['itemCount'])) {
	echo 'Please enter item count.';
	return;
}

if(!$logged) {
	echo "You need to be logged.";
	return;
}

require_once(PLUGINS . 'gesior-shop-system/config.php');
require_once(PLUGINS . 'gesior-shop-system/PagSeguroLibrary/PagSeguroLibrary.php');

$paymentRequest = new PagSeguroPaymentRequest();
$paymentRequest->addItem('1', $config['pagseguro']['productName'], $_POST['itemCount'], $config['pagseguro']['productValue']);
$paymentRequest->setCurrency("BRL");

$paymentRequest->setReference(USE_ACCOUNT_NAME ? $account_logged->getName() : $account_logged->getId());
$paymentRequest->setRedirectUrl(BASE_URL . $config['pagseguro']['urlRedirect']);
$paymentRequest->addParameter('notificationURL', BASE_URL . 'payments/pagseguro.php');

try {
	$credentials = PagSeguroConfig::getAccountCredentials();
	$checkoutUrl = $paymentRequest->register($credentials);
	header('Location:' . $checkoutUrl);

} catch (PagSeguroServiceException $e) {
	die($e->getMessage());
}
