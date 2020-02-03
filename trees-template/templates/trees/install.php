<?php
defined('MYAAC') or die('Direct access not allowed!');

if(tableExist(TABLE_PREFIX . 'menu')) {
	$query = $db->query('SELECT `id` FROM `' . TABLE_PREFIX . 'menu` WHERE `template` = ' . $db->quote('trees') . ' LIMIT 1;');
	if($query->rowCount() > 0) {
		return;
	}
}
else {
	return;
}

$db->query("
/* home */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Home', 'news', 1, 0);
/* community */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Characters', 'characters', 2, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Online', 'online', 2, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Highscores', 'highscores', 2, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Last Kills', 'lastkills', 2, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Houses', 'houses', 2, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Guilds', 'guilds', 2, 5);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Bans', 'bans', 2, 6);
/* library */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Monsters', 'creatures', 3, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Spells', 'spells', 3, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Commands', 'commands', 3, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Server Info', 'serverInfo', 3, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Gallery', 'gallery', 3, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Experience Table', 'experienceTable', 3, 5);
/* forum */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Forum', 'forum', 4, 0);
/* help */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Support', 'team', 5, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'FAQ', 'faq', 5, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Downloads', 'downloads', 5, 2);
/* shop */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Buy Points', 'points', 6, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Shop Offer', 'gifts', 6, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Shop History', 'gifts/history', 6, 2);
/* account menu */
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'My Account', 'account/manage', 7, 0);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Register Account', 'account/register', 7, 1);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Create Character', 'account/character/create', 7, 2);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Delete Character', 'account/character/delete', 7, 3);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Change Info', 'account/info', 7, 4);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Change Password', 'account/password', 7, 5);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Change Email', 'account/email', 7, 6);
INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES ('trees', 'Logout', 'account/logout', 7, 7);
");