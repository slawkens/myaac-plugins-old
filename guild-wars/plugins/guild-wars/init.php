<?php
defined('MYAAC') or die('Direct access not allowed!');

require __DIR__ . '/libs/OTS_GuildWars_List.php';
require __DIR__ . '/libs/OTS_Guild_List.php';
require __DIR__ . '/libs/OTS_GuildWar.php';

$hasGuildWarsNameColumn = $db->hasColumn('guild_wars', 'name1') && $db->hasColumn('guild_wars', 'name2');
$hasGuildWarsStartedColumn = $db->hasColumn('guild_wars', 'started');
$hasGuildWarsEndedColumn = $db->hasColumn('guild_wars', 'ended');
$hasGuildWarsFragLimitColumn = $db->hasColumn('guild_wars', 'frag_limit');
$hasGuildWarsDeclarationDateColumn = $db->hasColumn('guild_wars', 'declaration_date');
$hasGuildWarsBountyColumn = $db->hasColumn('guild_wars', 'bounty');

$extraQuery = '';
if ($hasGuildWarsNameColumn) {
	$extraQuery = '`guild_wars`.`name1`, `guild_wars`.`name2`, ';
}

if ($hasGuildWarsStartedColumn && $hasGuildWarsEndedColumn) {
	$extraQuery .= '`guild_wars`.`started`, `guild_wars`.`ended`, ';
}
elseif ($hasGuildWarsFragLimitColumn && $hasGuildWarsDeclarationDateColumn && $hasGuildWarsBountyColumn) {
	$extraQuery .= '`guild_wars`.`frag_limit`, `guild_wars`.`declaration_date`, `guild_wars`.`bounty`, ';
}

$orderBy = 'started';
if (!$hasGuildWarsStartedColumn && $hasGuildWarsDeclarationDateColumn) {
	$orderBy = 'declaration_date';
}

function displayGuildWars($warsDb, $warFrags, $guild = null, $isLeader = false) {
	global $twig, $hasGuildWarsNameColumn, $logged;

	$wars = [];
	foreach ($warsDb as $war) {
		$war['guildLogoPath1'] = getGuildLogoById($war['guild1']);
		$war['guildLogoPath2'] = getGuildLogoById($war['guild2']);

		if (!$hasGuildWarsNameColumn) {
			$war['name1'] = getGuildNameById($war['guild1']);
			$war['name2'] = getGuildNameById($war['guild2']);
		}

		$wars[] = $war;
	}

	$twig->display('guild-wars/templates/guild_wars.html.twig', [
		'logged' => $logged,
		'isLeader' => $isLeader,
		'guild' => $guild,
		'wars' => $wars,
		'warFrags' => $warFrags,
	]);
}
