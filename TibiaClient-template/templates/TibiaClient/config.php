<?php

$config['darkborder'] = '#474747';
$config['lightborder'] = '#4F4F4F';
$config['vdarkborder'] = '#373737';

define('MENU_CATEGORY_ACCOUNT_LOGGED', 7);
define('MENU_CATEGORY_ACCOUNTS', 8);

$config['menu_categories'] = [
	MENU_CATEGORY_NEWS => ['id' => 'news', 'name' => 'News'],
	MENU_CATEGORY_ACCOUNT_LOGGED => ['id' => 'account-logged', 'name' => 'Your Account'],
	MENU_CATEGORY_ACCOUNTS => ['id' => 'accounts', 'name' => 'Account'],
	MENU_CATEGORY_COMMUNITY => ['id' => 'community', 'name' => 'Community'],
	MENU_CATEGORY_LIBRARY => ['id' => 'library', 'name' => 'Library'],
	MENU_CATEGORY_SHOP => ['id' => 'shop', 'name' => 'Shop'],
];
