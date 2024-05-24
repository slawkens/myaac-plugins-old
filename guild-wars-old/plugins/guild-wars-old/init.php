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

if (!function_exists('getGuildNameById')) {
	function getGuildNameById($id)
	{
		global $db;

		$guild = $db->query('SELECT `name` FROM `guilds` WHERE `id` = ' . (int)$id);

		if ($guild->rowCount() > 0) {
			return $guild->fetchColumn();
		}

		return false;
	}
}

if (!function_exists('getGuildLogoById')) {
	function getGuildLogoById($id)
	{
		global $db;

		$logo = 'default.gif';

		$query = $db->query('SELECT `logo_name` FROM `guilds` WHERE `id` = ' . (int)$id);
		if ($query->rowCount() == 1) {

			$query = $query->fetch(PDO::FETCH_ASSOC);
			$guildLogo = $query['logo_name'];

			if (!empty($guildLogo) && file_exists('images/guilds/' . $guildLogo)) {
				$logo = $guildLogo;
			}
		}

		return BASE_URL . 'images/guilds/' . $logo;
	}
}
