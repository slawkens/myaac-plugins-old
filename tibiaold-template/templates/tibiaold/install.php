<?php
defined('MYAAC') or die('Direct access not allowed!');

if(tableExist(TABLE_PREFIX . 'menu')) {
	$query = $db->query('SELECT `id` FROM `' . TABLE_PREFIX . 'menu` WHERE `template` = ' . $db->quote('tibiaold') . ' LIMIT 1;');
	if($query->rowCount() > 0) {
		return;
	}
}
else {
	return;
}

$db->query("
/* left menu */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Latest News', 'news', 1, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'News Archive', 'news/archive', 1, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Changelog', 'changelog', 1, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Account', 'account/manage', 1, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Register', 'account/create', 1, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Lost Account?', 'account/lost', 1, 5);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Server Rules', 'rules', 1, 6);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Downloads', 'downloads', 1, 7);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Report Bug', 'bugtracker', 1, 8);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Characters', 'characters', 1, 9);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Highscores', 'highscores', 1, 10);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Last Deaths', 'lastkills', 1, 11);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Houses', 'houses', 1, 12);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Bans', 'bans', 1, 13);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Forum', 'forum', 1, 14);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Monsters', 'creatures', 1, 15);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Spells', 'spells', 1, 16);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Commands', 'commands', 1, 17);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Gallery', 'gallery', 1, 18);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Experience Table', 'experienceTable', 1, 19);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'FAQ', 'faq', 1, 20);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Buy Points', 'points', 1, 21);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Shop Offer', 'gifts', 1, 22);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Shop History', 'gifts/history', 1, 23);

/* top menu */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Home', 'news', 2, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Guilds', 'guilds', 2, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Who is online', 'online', 2, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Support', 'team', 2, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('tibiaold', 'Server Information', 'serverInfo', 2, 4);
");