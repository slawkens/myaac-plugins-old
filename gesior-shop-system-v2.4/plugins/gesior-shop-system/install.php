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

if(!tableExist('z_ots_comunication')
	|| !tableExist('z_shop_categories')
	|| !tableExist('z_shop_history')
	|| !tableExist('z_shop_offer')
	|| !tableExist('crypto_payments')
	|| !tableExist('pagseguro_transactions')
) {
	// import schema
	try {
		$db->query(file_get_contents(PLUGINS . 'gesior-shop-system/schema.sql'));
		success('Some tables were missing. Importing database schema.');
	}
	catch(PDOException $error_) {
		error($error_);
		return;
	}
}

$query = $db->query("SELECT `id` FROM `z_shop_categories` LIMIT 1;");
if($query->rowCount() === 0) {
	$db->query("
INSERT INTO `z_shop_categories` (`id`, `name`, `description`, `hidden`) VALUES
	(NULL, 'item', 'Items', 0),
	(NULL, 'addon', 'Addons', 0),
	(NULL, 'mount', 'Mounts', 0),
	(NULL, 'pacc', 'Premium Account', 0),
	(NULL, 'container', 'Containers', 0),
	(NULL, 'other', 'Other', 0);
		");
		success('Imported sample categories to database.');
}

if(!fieldExist('hidden', 'z_shop_offer')) {
	$db->query("ALTER TABLE `z_shop_offer` ADD `hidden` TINYINT(1) NOT NULL DEFAULT 0;");
	success('Added hidden field to z_shop_offer table to database.');
}

// insert some samples
// avoid duplicates
$query = $db->query("SELECT `id` FROM `z_shop_offer` LIMIT 1;");
if($query->rowCount() === 0) {
	$db->query("
INSERT INTO `z_shop_offer` (`id`, `points`, `itemid1`, `count1`, `itemid2`, `count2`, `offer_type`, `offer_description`, `offer_name`) VALUES
	(NULL, '10', 2160, 50, 0, 0, 'item', '50 crystal coins. They weigh 5.00 oz.', '50 Crystal Coins'),
	(NULL, '10', 139, 3, 131, 3, 'addon', 'This purchase will give you the full knight outfit.', 'Knight Outfit'),
	(NULL, '10', 22, 0, 0, 0, 'mount', 'This purchase will give you the Rented Horse mount.', 'Rented Horse'),
	(NULL, '10', 0, 30, 0, 0, 'pacc', '30 Days of Premium Account', 'PACC 30');
		");
	success('Imported sample offers to database.');
}

if($db->select(TABLE_PREFIX . 'admin_menu', ['name' => 'Gifts']) === false) {
	$db->query("INSERT INTO `" . TABLE_PREFIX . "admin_menu` (`name`, `page` ,`ordering` ,`flags` ,`enabled`) VALUES ('Gifts', 'gifts', '0', '0', '1')");
}

if(!@copy('https://curl.se/ca/cacert.pem', LIBS . 'cert/cacert.pem')) {
	$errors = error_get_last();
	error($errors['type'] . "<br />\n" . $errors['message']);
} else {
	success('Updated cacert.pem from remote host.');
}

if(!function_exists('curl_init')) {
	error(sprintf("Error. Please enable <a target='_blank' href='%s'>CURL extension</a> in PHP. <a target='_blank' href='%s'>Read here &#187;</a> Paypal, Cryptobox and PagSeguro will not work correctly without it.", "http://php.net/manual/en/book.curl.php", "http://stackoverflow.com/questions/1347146/how-to-enable-curl-in-php-xampp"));
	return;
}

if(!is_file(PLUGINS . 'gesior-shop-system/config.php')) {
	copy(
		PLUGINS . 'gesior-shop-system/config.php.dist',
		PLUGINS . 'gesior-shop-system/config.php'
	);
	success("Copied config.php.dist to config.php");
}

success("You can configure the script in following file: plugins/gesior-shop-system/config.php");
