<div class="sidebar">
	<h2>Top 5 players</h2>
<?php
$fetch_from_db = true;
if($cache->enabled())
{
	$tmp = '';
	if($cache->fetch('top_5_level', $tmp))
	{
		$players = unserialize($tmp);
		$fetch_from_db = false;
	}
}

if($fetch_from_db)
{
	$players_db = $db->query('SELECT `name`, `level`, `experience` FROM `players` WHERE `group_id` < ' . $config['highscores_groups_hidden'] . ' AND `id` > 6 ORDER BY `experience` DESC LIMIT 5;');
	
	$players = array();
	foreach($players_db as $player)
		$players[] = array('name' => $player['name'], 'level' => $player['level']);
	
	if($cache->enabled())
		$cache->set('top_5_level', serialize($players), 120);
}

if ($players) {
	$count = 1;
	foreach($players as $player) {
		echo $count . '- ' . getPlayerLink($player['name']) . ' (' . $player['level'] . ').<br/>';
		$count++;
	}
}
?>
</div>