<?php
/**
 *  ... Please MODIFY this file ... 
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */

 define("DB_HOST", 	$config['database_host']);				// hostname
 define("DB_USER", 	$config['database_user']);		// database username
 define("DB_PASSWORD", 	$config['database_password']);		// database password
 define("DB_NAME", 	$config['database_name']);	// database name




/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional), etc...");
 */
 
 $cryptobox_private_keys = array();
foreach($config['cryptobox']['all_keys'] as $name => $keys) {
	foreach($keys as $name => $value) {
		if($name == 'private_key') {
			$cryptobox_private_keys[] = $value;
		}
	}
}

 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys); 

?>