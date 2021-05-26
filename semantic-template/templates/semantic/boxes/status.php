<div class="column box">
	<div class="ui top attached message">
		<h4 class="ui header">
			<i class="star icon"></i>
			<div class="content">
				<a href="<?= getLink('online') ?>">Server Status</a>
			</div>
		</h4>
	</div>
	<div class="ui bottom attached segment">
		<?php if($status['online']) { ?>
			<div class="ui message green">
				<p>Online</p>
				<p>Uptime: <strong><?= $status['uptimeReadable'] ?></strong></p>
				<a href="<?= getLink('online') ?>"><p style="color: #1ebc30">Players: <strong><?= $status['players'] . '/' . $status['playersMax']; ?></strong></p></a>
			</div>
		<?php } else { ?>
			<div class="ui message red">
				Offline
			</div>
		<?php } ?>
	</div>
</div>
