<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<div class="well">
	<div class="header">
		<a href="<?= getLink('highscores') ?>">Top Players</a>
	</div>
	<div class="body">
		<table class="table-100">
			<?php
			$i = 0;
			foreach (getTopPlayers(5) as $player) {
				?>
				<tr><td><?= ++$i; ?>.</td><td><?= getPlayerLink($player['name']); ?> (<?= $player['level']; ?>)</td></tr>
			<?php } ?>
		</table>
	</div>
</div>
