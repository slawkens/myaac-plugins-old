<?php

$config['discord_link'] = 'https://discord.gg/2J39Wus';
$config['darkborder'] = "#e2d0b2";
$config['lightborder'] = "#f2e8cb";
$config['vdarkborder'] = "#5a4829";

define('MENU_CATEGORY_ACCOUNT_LOGGED', 7);
define('MENU_CATEGORY_ACCOUNTS', 8);
define('MENU_CATEGORY_FOOTER', 9);

$config['menu_categories'] = array(
	MENU_CATEGORY_ACCOUNT_LOGGED => ['id' => 'accounts', 'name' => 'Account Logged Menu'],
	MENU_CATEGORY_ACCOUNTS => ['id' => 'accounts', 'name' => 'Accounts'],
	MENU_CATEGORY_COMMUNITY => ['id' => 'community', 'name' => 'Community'],
	MENU_CATEGORY_LIBRARY => ['id' => 'library', 'name' => 'Library'],
	MENU_CATEGORY_FOOTER => ['id' => 'footer', 'name' => 'Footer'],
);
