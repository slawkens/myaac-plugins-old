<?php

return [
	MENU_CATEGORY_ACCOUNT_LOGGED => [
		['name' => 'My Account', 'link' => 'account/manage'],
		['name' => 'Create Character', 'link' => 'account/character/create'],
		['name' => 'Delete Character', 'link' => 'account/character/delete'],
		['name' => 'Change Info', 'link' => 'account/info'],
		['name' => 'Change Password', 'link' => 'account/password'],
		['name' => 'Change Email', 'link' => 'account/email'],
		['name' => 'Logout', 'link' => 'account/logout'],
	],
	MENU_CATEGORY_NEWS => [
		['name' => 'Latest News', 'link' => 'news'],
		['name' => 'News Archive', 'link' => 'news/archive'],
		['name' => 'Changelog', 'link' => 'changelog'],
	],
	MENU_CATEGORY_ACCOUNTS => [
		['name' => 'Account Management', 'link' => 'account/manage'],
		['name' => 'Create Account', 'link' => 'account/create'],
		['name' => 'Lost Account?', 'link' => 'account/lost'],
		['name' => 'Downloads', 'link' => 'downloads'],
		['name' => 'Server Rules', 'link' => 'rules'],
	],
	MENU_CATEGORY_COMMUNITY => [
		['name' => 'Characters', 'link' => 'characters'],
		['name' => 'Highscores', 'link' => 'highscores'],
		['name' => 'Who is Online?', 'link' => 'online'],
		['name' => 'Houses', 'link' => 'houses'],
		['name' => 'Guilds', 'link' => 'guilds'],
		['name' => 'Last Kills', 'link' => 'lastkills'],
		['name' => 'Team', 'link' => 'team'],
	],
	MENU_CATEGORY_LIBRARY => [
		['name' => 'Monsters', 'link' => 'creatures'],
		['name' => 'Spells', 'link' => 'spells'],
		['name' => 'Commands', 'link' => 'commands'],
		['name' => 'Server Info', 'link' => 'serverInfo'],
		['name' => 'Gallery', 'link' => 'gallery'],
		['name' => 'Experience Table', 'link' => 'experienceTable'],
		['name' => 'FAQ', 'link' => 'faq'],
	],
	MENU_CATEGORY_SHOP => [
		['name' => 'Buy Points', 'link' => 'points'],
		['name' => 'Gifts', 'link' => 'gifts'],
	],
];
