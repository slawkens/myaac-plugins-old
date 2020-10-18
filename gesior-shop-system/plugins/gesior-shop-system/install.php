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

if(!tableExist('z_ots_comunication'))
{
	$db->query("
CREATE TABLE `z_ots_comunication` (
	`id` INT(11) NOT NULL auto_increment,
	`name` VARCHAR(255) NOT NULL DEFAULT '',
	`type` VARCHAR(255) NOT NULL DEFAULT '',
	`action` VARCHAR(255) NOT NULL DEFAULT '',
	`param1` VARCHAR(255) NOT NULL DEFAULT '',
	`param2` VARCHAR(255) NOT NULL DEFAULT '',
	`param3` VARCHAR(255) NOT NULL DEFAULT '',
	`param4` VARCHAR(255) NOT NULL DEFAULT '',
	`param5` VARCHAR(255) NOT NULL DEFAULT '',
	`param6` VARCHAR(255) NOT NULL DEFAULT '',
	`param7` VARCHAR(255) NOT NULL DEFAULT '',
	`delete_it` INT(2) NOT NULL DEFAULT '1',
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
		");
		success('Imported z_ots_comunication table to database.');
}

if(!tableExist('z_shop_categories'))
{
	$db->query("
CREATE TABLE IF NOT EXISTS `z_shop_categories` (
	`id` INT(11) NOT NULL auto_increment,
	`name` VARCHAR(32) NOT NULL,
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	`hidden` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
		");

	$db->query("
INSERT INTO `z_shop_categories` (`id`, `name`, `description`, `hidden`) VALUES
	(NULL, 'item', 'Items', 0),
	(NULL, 'addon', 'Addons', 0),
	(NULL, 'mount', 'Mounts', 0),
	(NULL, 'pacc', 'Premium Account', 0),
	(NULL, 'container', 'Containers', 0),
	(NULL, 'other', 'Other', 0);
		");
		success('Imported z_shop_categories table to database.');
}

if(!tableExist('z_shop_history'))
{
	$db->query("
CREATE TABLE IF NOT EXISTS `z_shop_history` (
	`id` INT(11) NOT NULL auto_increment,
	`comunication_id` INT(11) NOT NULL DEFAULT 0,
	`to_name` VARCHAR(255) NOT NULL DEFAULT 0,
	`to_account` INT(11) NOT NULL DEFAULT 0,
	`from_nick` VARCHAR(255) NOT NULL DEFAULT '',
	`from_account` INT(11) NOT NULL DEFAULT 0,
	`price` INT(11) NOT NULL DEFAULT 0,
	`offer_id` INT(11) NOT NULL DEFAULT 0,
	`trans_state` VARCHAR(255) NOT NULL,
	`trans_start` INT(11) NOT NULL DEFAULT 0,
	`trans_real` INT(11) NOT NULL DEFAULT 0,
	`is_pacc` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
		");
		success('Imported z_shop_history table to database.');
}

if(!tableExist('z_shop_offer'))
{
	$db->query("
CREATE TABLE IF NOT EXISTS `z_shop_offer` (
	`id` INT(11) NOT NULL auto_increment,
	`points` INT(11) NOT NULL DEFAULT 0,
	`itemid1` INT(11) NOT NULL DEFAULT 0,
	`count1` INT(11) NOT NULL DEFAULT 0,
	`itemid2` INT(11) NOT NULL DEFAULT 0,
	`count2` INT(11) NOT NULL DEFAULT 0,
	`offer_type` VARCHAR(255) DEFAULT NULL,
	`offer_description` text NOT NULL,
	`offer_name` VARCHAR(255) NOT NULL DEFAULT '',
	`hidden` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
		");
		success('Imported z_shop_offer table to database.');
}
else {
	if(!fieldExist('hidden', 'z_shop_offer')) {
		$db->query("ALTER TABLE `z_shop_offer` ADD `hidden` TINYINT(1) NOT NULL DEFAULT 0;");
		success('Added hidden field to z_shop_offer table to database.');
	}
}

// insert some samples
// avoid duplicates
$query = $db->query("SELECT `id` FROM `z_shop_offer` LIMIT 1;");
if($query->rowCount() == 0) {
	$db->query("
INSERT INTO `z_shop_offer` (`id`, `points`, `itemid1`, `count1`, `itemid2`, `count2`, `offer_type`, `offer_description`, `offer_name`) VALUES
	(NULL, '10', 2160, 50, 0, 0, 'item', '50 crystal coins. They weigh 5.00 oz.', '50 Crystal Coins'),
	(NULL, '10', 139, 3, 131, 3, 'addon', 'This purchase will give you the full knight outfit.', 'Knight Outfit'),
	(NULL, '10', 22, 0, 0, 0, 'mount', 'This purchase will give you the Rented Horse mount.', 'Rented Horse'),
	(NULL, '10', 0, 30, 0, 0, 'pacc', '30 Days of Premium Account', 'PACC 30');
		");
	success('Imported sample items to database.');
}

if(!tableExist('crypto_payments'))
{
	$db->query("
CREATE TABLE `crypto_payments` (
  `paymentID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `boxID` int(11) unsigned NOT NULL DEFAULT '0',
  `boxType` enum('paymentbox','captchabox') NOT NULL,
  `orderID` varchar(50) NOT NULL DEFAULT '',
  `userID` varchar(50) NOT NULL DEFAULT '',
  `countryID` varchar(3) NOT NULL DEFAULT '',
  `coinLabel` varchar(6) NOT NULL DEFAULT '',
  `amount` double(20,8) NOT NULL DEFAULT '0.00000000',
  `amountUSD` double(20,8) NOT NULL DEFAULT '0.00000000',
  `unrecognised` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addr` varchar(34) NOT NULL DEFAULT '',
  `txID` char(64) NOT NULL DEFAULT '',
  `txDate` datetime DEFAULT NULL,
  `txConfirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `txCheckDate` datetime DEFAULT NULL,
  `processed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `processedDate` datetime DEFAULT NULL,
  `recordCreated` datetime DEFAULT NULL,
  PRIMARY KEY (`paymentID`),
  KEY `boxID` (`boxID`),
  KEY `boxType` (`boxType`),
  KEY `userID` (`userID`),
  KEY `countryID` (`countryID`),
  KEY `orderID` (`orderID`),
  KEY `amount` (`amount`),
  KEY `amountUSD` (`amountUSD`),
  KEY `coinLabel` (`coinLabel`),
  KEY `unrecognised` (`unrecognised`),
  KEY `addr` (`addr`),
  KEY `txID` (`txID`),
  KEY `txDate` (`txDate`),
  KEY `txConfirmed` (`txConfirmed`),
  KEY `txCheckDate` (`txCheckDate`),
  KEY `processed` (`processed`),
  KEY `processedDate` (`processedDate`),
  KEY `recordCreated` (`recordCreated`),
  KEY `key1` (`boxID`,`orderID`),
  KEY `key2` (`boxID`,`orderID`,`userID`),
  UNIQUE KEY `key3` (`boxID`, `orderID`, `userID`, `txID`, `amount`, `addr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
	");
	success('Imported crypto_payments table to database.');
}

if(!tableExist('pagseguro_transactions'))
{
	$db->query("
CREATE TABLE IF NOT EXISTS `pagseguro_transactions` (
	`transaction_code` VARCHAR(36) NOT NULL,
	`name` VARCHAR(200) DEFAULT NULL,
	`payment_method` VARCHAR(50) NOT NULL,
	`status` VARCHAR(50) NOT NULL,
	`item_count` INT(11) NOT NULL,
	`data` DATETIME NOT NULL,
	UNIQUE KEY `transaction_code` (`transaction_code`,`status`),
	KEY `name` (`name`),
	KEY `status` (`status`)
) ENGINE=MyISAM;
		");
	success('Imported pagseguro_transactions table to database.');
}

if($db->select(TABLE_PREFIX . 'admin_menu', array('name' => 'Gifts')) === false) {
	$db->query("INSERT INTO `" . TABLE_PREFIX . "admin_menu` (`name`, `page` ,`ordering` ,`flags` ,`enabled`) VALUES ('Gifts', 'gifts', '0', '0', '1')");
}

if(!function_exists('curl_init')) {
	error(sprintf("Error. Please enable <a target='_blank' href='%s'>CURL extension</a> in PHP. <a target='_blank' href='%s'>Read here &#187;</a> Paypal, Cryptobox and PagSeguro will not work correctly without it.", "http://php.net/manual/en/book.curl.php", "http://stackoverflow.com/questions/1347146/how-to-enable-curl-in-php-xampp"));
	return;
}