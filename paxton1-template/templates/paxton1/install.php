<?php
defined('MYAAC') or die('Direct access not allowed!');

if(tableExist(TABLE_PREFIX . 'menu')) {
	$query = $db->query('SELECT `id` FROM `' . TABLE_PREFIX . 'menu` WHERE `template` = ' . $db->quote('paxton1') . ' LIMIT 1;');
	if($query->rowCount() > 0) {
		return;
	}
}
else {
	return;
}

$db->query("
/* news */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Latest News', 'news', 1, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'News Archive', 'news/archive', 1, 1);
/* account */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Account Management', 'account/manage', 2, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Create Account', 'account/create', 2, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Lost Account?', 'account/lost', 2, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Server Rules', 'rules', 2, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Report Bug', 'bugtracker', 2, 4);
/* community */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Characters', 'characters', 3, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Who is online?', 'online', 3, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Highscores', 'highscores', 3, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Last Kills', 'lastkills', 3, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Houses', 'houses', 3, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Guilds', 'guilds', 3, 5);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Bans', 'bans', 3, 6);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Forum', 'forum', 3, 7);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Team', 'team', 3, 8);
/* library */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Creatures', 'creatures', 4, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Spells', 'spells', 4, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Commands', 'commands', 4, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Server Info', 'serverInfo', 4, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Downloads', 'downloads', 4, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Gallery', 'gallery', 4, 5);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Experience Table', 'experienceTable', 4, 6);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Experience Stages', 'experienceStages', 4, 7);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'FAQ', 'faq', 4, 8);
/* shop */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Buy Points', 'points', 5, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Shop Offer', 'gifts', 5, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('paxton1', 'Shop History', 'gifts/history', 5, 2);
");