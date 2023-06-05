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
INSERT INTO `z_shop_categories` (`id`, `name`, `hidden`) VALUES
	(1, 'Items', 0),
	(2, 'Addons', 0),
	(3, 'Mounts', 0),
	(4, 'Premium Account', 0),
	(5, 'Containers', 0),
	(6, 'Other', 0);
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
INSERT INTO `z_shop_offer` (`id`, `points`, `itemid1`, `count1`, `itemid2`, `count2`, `category_id`, `offer_type`, `offer_description`, `offer_name`, `ordering`) VALUES
	(NULL, '10', 2160, 50, 0, 0, 1, 'item', '50 crystal coins. They weigh 5.00 oz.', '50 Crystal Coins', 1),
	(NULL, '10', 139, 3, 131, 3, 2, 'addon', 'This purchase will give you the full knight outfit.', 'Knight Outfit', 2),
	(NULL, '10', 22, 0, 0, 0, 3, 'mount', 'This purchase will give you the Rented Horse mount.', 'Rented Horse', 3),
	(NULL, '10', 0, 30, 0, 0, 4, 'pacc', '30 Days of Premium Account', 'PACC 30', 4);
		");
	success('Imported sample offers to database.');
}

if($db->select(TABLE_PREFIX . 'admin_menu', ['name' => 'Gifts']) === false) {
	$db->query("INSERT INTO `" . TABLE_PREFIX . "admin_menu` (`name`, `page` ,`ordering` ,`flags` ,`enabled`) VALUES ('Gifts', 'gifts', '0', '0', '1')");
}

if (!$db->hasColumn('z_shop_offer', 'category_id')) {
	$db->exec("ALTER TABLE z_shop_offer ADD `category_id` TINYINT(1) NOT NULL DEFAULT 0 AFTER `count2`;");

	$query = $db->query("SELECT id, name FROM z_shop_categories;");
	foreach ($query as $category) {
		$db->update('z_shop_offer', ['category_id' => $category['id']], ['offer_type' => $category['name']]);
	}

	$db->exec("UPDATE z_shop_categories SET `name` = `description`;");
	$db->exec("ALTER TABLE z_shop_categories DROP `description`;");

	$db->exec("ALTER TABLE z_shop_offer ADD `ordering` INT(11) NOT NULL DEFAULT 0;");
	$db->exec("UPDATE z_shop_offer SET `ordering` = `id`;");

	$db->exec("ALTER TABLE z_shop_categories DROP PRIMARY KEY, CHANGE id id INT(11) NOT NULL;");
	$db->exec("ALTER TABLE z_shop_categories ADD PRIMARY KEY(`id`);");

	success('Updated tables to latest version (category_id) - v4.0.');
}

if(!@copy('https://curl.se/ca/cacert.pem', PLUGINS . 'gesior-shop-system/libs/' . 'cert/cacert.pem')) {
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
