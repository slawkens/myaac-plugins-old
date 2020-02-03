<?php
defined('MYAAC') or die('Direct access not allowed!');

$template_name = 'loleslav';

if(!tableExist(TABLE_PREFIX . 'menu')) { // if it doesn't exist, we won't support dynamic menus
	return;
}

$query = $db->query('SELECT `id` FROM `' . TABLE_PREFIX . 'menu` WHERE `template` = ' . $db->quote($template_name) . ' LIMIT 1;');
if($query->rowCount() > 0) {
	return;
}
$menus = array(
	0 => array( // Top Menu
		array('News', 'news'),
		array('Create Account', 'account/create'),
		array('Downloads', 'downloads'),
		array('Forum', 'forum'),
	),
	1 => array( // Home
		array('Latest News', 'news'),
		array('News Archive', 'news/archive'),
		array('Downloads', 'downloads'),
		array('Rules', 'rules'),
		array('Support', 'team'),
		array('FAQ', 'faq'),
	),
	2 => array( // Community
		array('Characters', 'characters'),
		array('Online', 'online'),
		array('Highscores', 'highscores'),
		array('Last Kills', 'lastkills'),
		array('Houses', 'houses'),
		array('Guilds', 'guilds'),
		array('Bans', 'bans'),
		array('Forum', 'forum'),
	),
	3 => array( // Library
		array('Creatures', 'creatures'),
		array('Spells', 'spells'),
		array('Commands', 'commands'),
		array('Server Info', 'serverInfo'),
		array('Gallery', 'gallery'),
		array('Experience Table', 'experienceTable'),
	),
	4 => array( // Highscores
		array('Level', 'highscores/experience'),
		array('Magic', 'highscores/magic'),
		array('Shielding', 'highscores/shielding'),
		array('Distance', 'highscores/distance'),
		array('Club', 'highscores/club'),
		array('Sword', 'highscores/sword'),
		array('Axe', 'highscores/axe'),
		array('Fist', 'highscores/fist'),
		array('Fishing', 'highscores/fishing'),
	),
	5 => array( // Shop
		array('Buy Points', 'points'),
		array('Gifts', 'gifts'),
		array('History', 'gifts/history'),
	),
);

$query = '';
foreach($menus as $category_id => $category) {
	$ordering = 0;
	foreach($category as $menu) {
		$query .= "INSERT INTO `myaac_menu` (`template`, `name`, `link`, `category`, `ordering`) VALUES (" . $db->quote($template_name) . ", " . $db->quote($menu[0]) . ", " . $db->quote($menu[1]) . ", " . $category_id . ", " . $ordering++ .");" . PHP_EOL;
	}
}

try {
	$db->query($query);
	success('Imported template menus into database.');
}
catch(PDOException $error) {
	error($error);
}