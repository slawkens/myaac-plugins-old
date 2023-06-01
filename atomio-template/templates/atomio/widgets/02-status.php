<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<div class="well widget loginContainer" id="loginContainer">
	<div class="header">
		<a href="<?= getLink('online') ?>">Server Status</a>
	</div>
	<div class="body">
		<div style="text-align: center">
			<?php if($status['online']) { ?>
					<p>Online</p>
					<p>Uptime: <strong><?= $status['uptimeReadable'] ?></strong></p>
					<a href="<?= getLink('online') ?>"><p style="color: #1ebc30">Players: <strong><?= $status['players'] . '/' . $status['playersMax']; ?></strong></p></a>
			<?php } else { ?>
					Offline
			<?php } ?>
		</div>
	</div>
</div>
