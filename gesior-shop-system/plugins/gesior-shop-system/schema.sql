CREATE TABLE IF NOT EXISTS `z_ots_comunication` (
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

CREATE TABLE IF NOT EXISTS `z_shop_categories` (
	`id` INT(11) NOT NULL,
	`name` VARCHAR(32) NOT NULL,
	`hidden` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

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

CREATE TABLE IF NOT EXISTS `z_shop_offer` (
	`id` INT(11) NOT NULL auto_increment,
	`points` INT(11) NOT NULL DEFAULT 0,
	`itemid1` INT(11) NOT NULL DEFAULT 0,
	`count1` INT(11) NOT NULL DEFAULT 0,
	`itemid2` INT(11) NOT NULL DEFAULT 0,
	`count2` INT(11) NOT NULL DEFAULT 0,
	`category_id` TINYINT(1) NOT NULL DEFAULT 0,
	`offer_type` VARCHAR(255) DEFAULT NULL,
	`offer_description` text NOT NULL,
	`offer_name` VARCHAR(255) NOT NULL DEFAULT '',
	`hidden` TINYINT(1) NOT NULL DEFAULT 0,
	`ordering` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `crypto_payments` (
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

CREATE TABLE IF NOT EXISTS  `stripe` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`account_id` int(11) NOT NULL,
	`email` varchar(255) NOT NULL,
	`points` int(11) NOT NULL,
	`price` int(11) NOT NULL,
	`currency` varchar(255) NOT NULL,
	`payment_id` varchar(255) NOT NULL,
	`api_version` varchar(255) NOT NULL,
	`created` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
