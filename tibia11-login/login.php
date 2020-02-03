<?php
/**
 * Created by Notepad++.
 * User: Malucooo - Erick Nunes
 * Remaked of login.php by JLCVP and parts of login.php by Monteiro. Thanks for both!
 * Modified for MyAAC by slawkens
 * Date: 18/09/17
 * Time: 03:01
 */

require_once('common.php');
require 'config.php';
require 'config.local.php';
// comment to show E_NOTICE [undefinied variable etc.], comment if you want make script and see all errors
error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE);

require_once(SYSTEM . 'functions.php');
require_once(SYSTEM . 'init.php');

/*error example:
{
    "errorCode":3,
    "errorMessage":"Account name or password is not correct."
}*/

# Declare variables with array structure
$characters = array();
$playerData = array();
$data = array();
$isCasting = false;

# error function
function sendError($msg){
    $ret = array();
    $ret["errorCode"] = 3;
    $ret["errorMessage"] = $msg;
    
    die(json_encode($ret));
}

# getting infos
$request = file_get_contents('php://input');
$result = json_decode($request, true);

# account infos
$accountName = $result["accountname"];
$password = $result["password"];

# game port
$port = $config['lua']['gameProtocolPort'];

# check if player wanna see cast list
if (strtolower($accountName) == "cast")
	$isCasting = true;

if ($isCasting) {
	$casts = $db->query("SELECT `player_id` FROM `live_casts`")->fetchAll();
	if (count($casts[0]) == 0)
		sendError("There is no live casts right now!");
	foreach($casts as $cast) {
		$character = new OTS_Player();
		$character->load($cast['player_id']);
		
		if ($character->isLoaded()) {
			$char = array("worldid" => 0, "name" => $character->getName(), "ismale" => (($character->getSex() == 1) ? true : false), "tutorial" => true);
			$characters[] = $char;
		}
	}
	
	$port = 7173;
	$lastLogin = 0;

	$premiumAccount = true;
	$timePremium = 30 * 86400;
}
else {
	$account = new OTS_Account();
	$account->find($accountName);
	
	if (!$account->isLoaded())
		sendError("Failed to get account. Try again!");

	$config_salt_enabled = fieldExist('salt', 'accounts');
	$current_password = encrypt(($config_salt_enabled ? $account->getCustomField('salt') : '') . $password);
	if ($account->getPassword() != $current_password)
		sendError("The password for this account is wrong. Try again!");
	
	foreach($account->getPlayersList() as $character) {
		$char = array("worldid" => 0, "name" => $character->getName(), "ismale" => (($character->getSex() == 1) ? true : false), "tutorial" => true);
		$characters[] = $char;
	}
	
	$save = false;
	$timeNow = time();

	$query = $db->query('SELECT `premdays`, `lastday` FROM `accounts` WHERE `id` = ' . $account->getId());
	if($query->rowCount() > 0) {
		$query = $query->fetch();
		$premDays = (int)$query['premdays'];
		$lastDay = (int)$query['lastday'];
		$lastLogin = $lastDay;
	}
	else {
		sendError("Error while fetching your account data. Please contact admin.");
	}
	
	if($premDays != 0 && $premDays != PHP_INT_MAX ) {
		if($lastDay == 0) {
			$lastDay = $timeNow;
			$save = true;
		} else {
			$days = (int)(($timeNow - $lastDay) / 86400);
			if($days > 0) {
				if($days >= $premDays) {
					$premDays = 0;
					$lastDay = 0;
				} else {
					$premDays -= $days;
					$remainder = (int)(($timeNow - $lastDay) % 86400);
					$lastDay = $timeNow - remainder;
				}

				$save = true;
			}
		}
	} else if ($lastDay != 0) {
		$lastDay = 0;
		$save = true;
	}

	if($save) {
		$db->query('UPDATE `accounts` SET `premdays` = ' . $premDays . ', `lastday` = ' . $lastDay . ' WHERE `id` = ' . $account->getId());
	}

	$premiumAccount = $premDays > 0;
	$timePremium = time() + ($premDays * 86400);
}

$session = array(
/*	"fpstracking" => false,
	"isreturner" => true,
	"returnernotification" => false,
	"showrewardnews" => false,*/
	"sessionkey" => $accountName . "\n" . $password,
	"lastlogintime" => $lastLogin,
	"ispremium" => $premiumAccount,
	"premiumuntil" => $timePremium,
	"status" => "active"
);

$world = array(
	"id" => 0,
	"name" => $config['lua']['serverName'],
	"externaladdress" => $config['lua']['ip'],
	"externalport" => $port,
	"previewstate" => 0,
	"location" => "BRA",
	"anticheatprotection" => false,
	"externaladdressunprotected" => $config["lua"]["ip"],
	"externaladdressprotected" => $config["lua"]["ip"]
);

$worlds = array($world);

$data["session"] = $session;
$playerData["worlds"] = $worlds;
$playerData["characters"] = $characters;
$data["playdata"] = $playerData;

echo json_encode($data);
//echo '<pre>' . var_export($data, true) . '</pre>';