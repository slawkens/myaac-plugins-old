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

require_once('../common.php');
require_once(SYSTEM . 'functions.php');
require_once(SYSTEM . 'init.php');
require_once(PLUGINS . 'pagseguro/config.php');
require_once(PLUGINS . 'pagseguro/PagSeguroLibrary/PagSeguroLibrary.php');

if(!isset($config['pagSeguro']) || !count($config['pagSeguro']) || !count($config['pagSeguro']['options'])) {
	echo "PagSeguro is disabled. If you're an admin please configure this script in config.local.php.";
	return;
}

header("access-control-allow-origin: https://pagseguro.uol.com.br");

$method = $_SERVER['REQUEST_METHOD'];
if('post' == strtolower($method)) {
	$type = $_POST['notificationType'];
	$notificationCode = $_POST['notificationCode'];

	if ($type === 'transaction'){
		try {
			$credentials = PagSeguroConfig::getAccountCredentials();
			$transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);

			$arrayPDO['transaction_code'] = $transaction->getCode();
			$arrayPDO['account'] = $transaction->getReference();
			$arrayPDO['payment_method'] = $transaction->getPaymentMethod()->getType()->getTypeFromValue();
			$arrayPDO['status'] = $transaction->getStatus()->getTypeFromValue();
			$item = $transaction->getItems();
			$price = (int)$item[0]->getQuantity();

			$options = config('pagSeguro')['options'];
			if(!isset($options[$price])) {
				log_append('pagseguro.log', "PagSeguro is not correctly configured. Please edit the configuration file. Info: option: '$price' does not exists.");
				http_response_code(500);
				die;
			}

			$arrayPDO['item_count'] = $options[$price];

			$date_now = date('Y-m-d H:i:s');
			$arrayPDO['data'] = $date_now;

			try {
				$conn = new PDO('mysql:host='.$config['database_host'].';dbname='.$config['database_name'].'', $config['database_user'], $config['database_password']);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$stmt = $conn->prepare('INSERT into pagseguro_transactions SET transaction_code = :transaction_code, name = :account, payment_method = :payment_method, status = :status, item_count = :item_count, data = :data');
				$stmt->execute($arrayPDO);

				if ($arrayPDO['status'] == 'PAID') {
					if ($config['pagSeguro']['doublePoints']) {
						$arrayPDO['item_count'] = $arrayPDO['item_count'] * 2;
					}

					$field = 'premium_points';
					if(strtolower($config['pagSeguro']['donationType']) == 'coins') {
						$field = 'coins';
					}

					$stmt = $conn->prepare('UPDATE accounts SET ' . $field . ' = ' . $field . ' + :item_count WHERE ' . (USE_ACCOUNT_NAME ? 'name' : 'id') . ' = :account');
					$stmt->execute(array('item_count' => $arrayPDO['item_count'], 'account' => $arrayPDO['account']));

					$stmt = $conn->prepare("UPDATE pagseguro_transactions SET status = 'DELIVERED' WHERE transaction_code = :transaction_code AND status = 'PAID'");
					$stmt->execute(array('transaction_code' => $arrayPDO['transaction_code']));
				}
			} catch(PDOException $e) {
				log_append('pagseguro.log', $e->getMessage());
				echo 'ERROR: ' . $e->getMessage();
			}
		} catch(PagSeguroServiceException $e) {
			log_append('pagseguro.log', $e->getMessage());
			die($e->getMessage());
		}
	}
}

?>
