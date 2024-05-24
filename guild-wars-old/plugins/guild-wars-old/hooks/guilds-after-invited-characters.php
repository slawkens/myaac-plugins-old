<?php
defined('MYAAC') or die('Direct access not allowed!');

use Twig\Environment;

require PLUGINS . 'guild-wars-old/init.php';

global $logged;
/**
 * @var OTS_Guild $guild
 * @var bool $isLeader
 * @var OTS_DB_MySQL $db
 * @var Environment $twig
 **/

$guild_id = $guild->getId();

$warFrags = [];
foreach($db->query('SELECT * FROM `guildwar_kills` WHERE `killerguild` = ' . $guild_id . ' OR `targetguild` = ' . $guild_id . ' ORDER BY `time` DESC')->fetchAll() as $frag) {
	$warFrags[$frag['warid']][] = $frag;
}

$warsDb = $db->query('SELECT `guild_wars`.`id`, `guild_wars`.`guild1`, `guild_wars`.`guild2`, ' . $extraQuery . '`guild_wars`.`status`, (SELECT COUNT(1) FROM `guildwar_kills` WHERE `guildwar_kills`.`warid` = `guild_wars`.`id` AND `guildwar_kills`.`killerguild` = `guild_wars`.`guild1`) guild1_kills, (SELECT COUNT(1) FROM `guildwar_kills` WHERE `guildwar_kills`.`warid` = `guild_wars`.`id` AND `guildwar_kills`.`killerguild` = `guild_wars`.`guild2`) guild2_kills FROM `guild_wars` WHERE `guild1` = ' . $guild_id . ' OR `guild2` = ' . $guild_id . ' ORDER BY CASE `status` WHEN 0 THEN 2 WHEN 1 THEN 1 WHEN 4 THEN 3 WHEN 3 THEN 4 WHEN 2 THEN 5 END, `' . $orderBy . '` DESC')->fetchAll();

displayGuildWars($warsDb, $warFrags, $guild, $isLeader);
