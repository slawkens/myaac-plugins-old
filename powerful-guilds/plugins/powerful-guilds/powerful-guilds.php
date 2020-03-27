<?php
/**
 * Powerful guilds for MyAAC
 *
 * @name      powerful-guilds
 * @author    Slawkens <slawkens@gmail.com>
 * @version   1.1
 */

if(!isset($config['powerful_guilds']))
{
	$config['powerful_guilds'] = array(
		'refresh_interval' => 10 * 60, // cache query for 10 minutes (in seconds)
		'amount' => 5, // how many powerful guilds to show
		'page' => 'news' // on what pages most powerful guilds box should appear, for example 'news', or 'guilds' (blank makes it visible on every page)
	);
}

function mostPowerfulGuildsDatabase()
{
	global $db, $config;

	$ret = array();
	if(tableExist('killers')) { // TFS 0.3 + 0.4
		foreach ($db->query('SELECT `g`.`id` AS `id`, `g`.`name` AS `name`,
		`g`.`logo_name` AS `logo`, COUNT(`g`.`name`) as `frags`
		FROM `killers` k
			LEFT JOIN `player_killers` pk ON `k`.`id` = `pk`.`kill_id`
			LEFT JOIN `players` p ON `pk`.`player_id` = `p`.`id`
			LEFT JOIN `guild_ranks` gr ON `p`.`rank_id` = `gr`.`id`
			LEFT JOIN `guilds` g ON `gr`.`guild_id` = `g`.`id`
		WHERE `k`.`unjustified` = 1 AND `k`.`final_hit` = 1
			GROUP BY `name`
			ORDER BY `frags` DESC, `name` ASC
			LIMIT 0, ' . $config['powerful_guilds']['amount'] . ';') as $guild)
				$ret[] = array('name' => $guild['name'], 'logo' => $guild['logo'], 'frags' => $guild['frags']);
	}
	else { // TFS 1.0+
		foreach($db->query('SELECT `g`.`id` AS `id`, `g`.`name` AS `name`,
		`g`.`logo_name` AS `logo`, COUNT(`g`.`name`) as `frags`
		FROM `players` p
			LEFT JOIN `player_deaths` pd ON `pd`.`killed_by` = `p`.`name`
			LEFT JOIN `guild_membership` gm ON `p`.`id` = `gm`.`player_id`
			LEFT JOIN `guilds` g ON `gm`.`guild_id` = `g`.`id`
		WHERE `pd`.`unjustified` = 1
			GROUP BY `name`
			ORDER BY `frags` DESC, `name` ASC
			LIMIT 0, ' . $config['powerful_guilds']['amount'] . ';') as $guild) {
				$ret[] = array('name' => $guild['name'], 'logo' => $guild['logo'], 'frags' => $guild['frags']);
		}
	}

	return $ret;
}

function mostPowerfulGuildsList()
{
	global $cache, $config;

	if(!$cache->enabled())
		return mostPowerfulGuildsDatabase();

	$ret = array();
	$tmp = '';
	if($cache->fetch('powerful_guilds', $tmp))
		$ret = unserialize($tmp);

	if(!isset($ret[0]) || $ret['updated'] + $config['powerful_guilds']['refresh_interval'] < time())
	{
		$ret = mostPowerfulGuildsDatabase();
		$ret['updated'] = time();
		$cache->set('powerful_guilds', serialize($ret));
	}

	unset($ret['updated']);
	return $ret;
}

$_page = $config['powerful_guilds']['page'];
if(!isset($_page[0]) || $_page == PAGE)
{
	echo '<div class="NewsHeadline">
		<div class="NewsHeadlineBackground" style="background-image:url(' . $template_path . '/images/news/newsheadline_background.gif)">
			<table border="0">
				<tr>
					<td style="text-align: center; font-weight: bold;">
						<font color="white">Most powerful guilds</font>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<table border="0" cellspacing="3" cellpadding="4" width="100%">
		<tr>';

	$guilds = mostPowerfulGuildsList();
	if(count($guilds) > 0)
	{
		foreach($guilds as $guild)
			echo '<td style="width: ' . (100 / $config['powerful_guilds']['amount']) . '%; text-align: center;">
				<a href="' . getGuildLink($guild['name'], false) . '"><img src="images/guilds/' . ((!empty($guild['logo']) && file_exists('images/guilds/' . $guild['logo'])) ? $guild['logo'] : 'default.gif') . '" width="64" height="64" border="0"/><br />' . $guild['name'] . '</a><br />' . $guild['frags'] . ' kills
			</td>';
	}
	else
		echo '<td colspan="4" style="text-align: center;">There are no any guilds to show yet.</td>';

	echo '</tr>
		</table>';

	return true;
}
?>
