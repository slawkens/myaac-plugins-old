<div class="column box">
	<div class="ui top attached message">
		<h4 class="ui header">
			<i class="book icon"></i>
			<div class="content">
				<a href="<?= getLink('highscores') ?>">Top 5</a>
			</div>
		</h4>
	</div>
	<div class="ui bottom attached segment">
		<div class="ui list">
			<?php
			foreach(getTopPlayers(5) as $player) {
				$outfit_url = '';
				if($config['online_outfit']) {
					$outfit_url = $config['outfit_images_url'] . '?id=' . $player['looktype']	. (!empty
						($player['lookaddons']) ? '&addons=' . $player['lookaddons'] : '') . '&head=' . $player['lookhead'] . '&body=' . $player['lookbody'] . '&legs=' . $player['looklegs'] . '&feet=' . $player['lookfeet'];
				}
				?>
				<a class="item">
					<a class="ui image label" href="<?= getPlayerLink($player['name'], false) ?>">
						<?= $config['online_outfit'] ? '<img src="' . $outfit_url . '">' : '' ?>
						<?= $player['rank'] . '. ' . $player['name'] ?> (<?= $player['level'] ?>)
					</a>
				</a>
			<?php } ?>
		</div>
	</div>
</div>
