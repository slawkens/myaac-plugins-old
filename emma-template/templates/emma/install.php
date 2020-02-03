<?php
defined('MYAAC') or die('Direct access not allowed!');

if(tableExist(TABLE_PREFIX . 'menu')) {
	$query = $db->query('SELECT `id` FROM `' . TABLE_PREFIX . 'menu` WHERE `template` = ' . $db->quote('emma') . ' LIMIT 1;');
	if($query->rowCount() > 0) {
		return;
	}
}
else {
	return;
}

$db->query("
/* news */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Latest News', 'news', 1, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'News Archive', 'news/archive', 1, 1);
/* account */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Account Management', 'account/manage', 2, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Create Account', 'account/create', 2, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Lost Account?', 'account/lost', 2, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Server Rules', 'rules', 2, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Downloads', 'downloads', 2, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Report Bug', 'bugtracker', 2, 5);
/* community */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Characters', 'characters', 3, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Who is online', 'online', 3, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Highscores', 'highscores', 3, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Last Kills', 'lastkills', 3, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Houses', 'houses', 3, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Guilds', 'guilds', 3, 5);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Bans', 'bans', 3, 6);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Support List', 'team', 3, 7);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Forum', 'forum', 3, 8);
/* library */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Monsters', 'creatures', 5, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Spells', 'spells', 5, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Commands', 'commands', 5, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Server Info', 'serverInfo', 5, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Gallery', 'gallery', 5, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Experience Table', 'experienceTable', 5, 5);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Experience Stages', 'experienceStages', 5, 6);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'FAQ', 'faq', 5, 7);
/* shop */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Buy Points', 'points', 6, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Shop Offer', 'gifts', 6, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('emma', 'Shop History', 'gifts/history', 6, 2);
");