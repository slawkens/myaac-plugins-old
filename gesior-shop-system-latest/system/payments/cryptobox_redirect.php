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
$title = 'Cryptobox donation';

if(isset($_POST['price'])) {
	$price = $_SESSION['cryptobox_price'] = $_POST['price'];
}
else {
	if(isset($_SESSION['cryptobox_price'])) {
		$price = $_SESSION['cryptobox_price'];
	}
}

if(isset($_POST['order'])) {
	$order = $_SESSION['cryptobox_order'] = $_POST['order'];
}
else {
	if(isset($_SESSION['cryptobox_order'])) {
		$order = $_SESSION['cryptobox_order'];
	}
}

require_once(LIBS . "cryptobox.class.php" );
// List of coins that you accept for payments
// For example, for accept payments in bitcoins, dogecoins use - $available_payments = array('bitcoin', 'dogecoin'); 
$available_payments = $config['cryptobox']['available_payments'];

// Goto  https://gourl.io/info/memberarea/My_Account.html
// You need to create record for each your coin and get private/public keys
// Place Public/Private keys for all your available coins from $available_payments

$all_keys = $config['cryptobox']['all_keys'];

$def_payment = $config['cryptobox']['default_payment'];
/********************************/


// Re-test - that all keys for $available_payments added in $all_keys 
if (!in_array($def_payment, $available_payments)) $available_payments[] = $def_payment;  
foreach($available_payments as $v)
{
	if (!isset($all_keys[$v]["public_key"]) || !isset($all_keys[$v]["private_key"])) 
		die("Please add your public/private keys for '$v' in \$all_keys variable");
	elseif (!strpos($all_keys[$v]["public_key"], "PUB"))  die("Invalid public key for '$v' in \$all_keys variable");
	elseif (!strpos($all_keys[$v]["private_key"], "PRV")) die("Invalid private key for '$v' in \$all_keys variable");
	elseif (strpos(CRYPTOBOX_PRIVATE_KEYS, $all_keys[$v]["private_key"]) === false) 
		die("Please add your private key for '$v' in variable \$cryptobox_private_keys, file cryptobox.config.php.");
}

// Optional - Language selection list for payment box (html code)
$languages_list = display_language_box($config['cryptobox']['default_language']);

// Optional - Coin selection list (html code)
$coins_list = display_currency_box($available_payments, $def_payment, $config['cryptobox']['default_language']);
$coinName = cryptobox_selcoin(); // current selected coin by user

// Current Coin public/private keys
$public_key  = $all_keys[$coinName]["public_key"];
$private_key = $all_keys[$coinName]["private_key"];

/** PAYMENT BOX **/
$options = array(
		"public_key"  => $public_key, 	// your public key from gourl.io
		"private_key" => $private_key, 	// your private key from gourl.io
		"webdev_key"  => "DEV1090G439F286A30F436CG2093907291", 			// optional, gourl affiliate key
		"orderID"     => $order, 		// order id or product name
		"userID"      => $account_logged->getId(), 		// unique identifier for every user
		"userFormat"  => "COOKIE", 	// save userID in COOKIE, IPADDRESS or SESSION
		"amount"   	  => 0,				// product price in coins OR in USD below
		"amountUSD"   => $price,	// we use product price in USD
		"period"      => "NOEXPIRY", 		// payment valid period
		"language"	  => $config['cryptobox']['default_language']  // text on EN - english, FR - french, etc
);

// Initialise Payment Class
$box = new Cryptobox ($options);

// coin name
$coinName = $box->coin_name(); 

// Successful Cryptocoin Payment received
if ($box->is_paid()) 
{
	// Optional - use IPN (instant payment notification) function cryptobox_new_payment() for update db records, etc
	// IPN description: https://gourl.io/api-php.html#ipn 	

	if (!$box->is_confirmed()) {
		$message =  "Thank you for payment (payment #".$box->payment_id()."). Awaiting transaction/payment confirmation";
	}											
	else 
	{ // payment confirmed (6+ confirmations)

		// one time action
		if (!$box->is_processed())
		{
			// One time action after payment has been made/confirmed
			 
			$message = "Thank you for order (order #".$orderID.", payment #".$box->payment_id()."). We will send soon";
			
			// Set Payment Status to Processed
			$box->set_status_processed();  
		}
		else $message = "Thank you. Your order is in process"; // General message
	}
}
else $message = "This invoice has not been paid yet";
?>
<script src='tools/cryptobox.min.js' type='text/javascript'></script>
<!--body style='font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#666;margin:0'-->
<div align='center'>
	<div style='margin:30px 0 5px 300px'>Language: &#160; <?= $languages_list ?></div>
	<?= $box->display_cryptobox() ?>
	<br><br><br>
	<h3>Message :</h3>
	<h2 style='color:#999'><?= $message ?></h2>
</div>