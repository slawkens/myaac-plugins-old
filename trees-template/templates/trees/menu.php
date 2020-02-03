<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<li><a href="<?php echo getLink('news'); ?>">Home</a></li>
<li><a href="#">Community</a>
	<ul>
		<li><a href="<?php echo getLink('characters'); ?>">Characters</a></li>
		<li><a href="<?php echo getLink('online'); ?>">Online</a></li>
		<li><a href="<?php echo getLink('highscores'); ?>">Highscores</a></li>
		<li><a href="<?php echo getLink('lastkills'); ?>">Last Kills</a></li>
		<li><a href="<?php echo getLink('houses'); ?>">Houses</a></li>
		<li><a href="<?php echo getLink('guilds'); ?>">Guilds</a></li>
		<?php if(isset($config['wars'])): ?>
			<li><a href="<?php echo getLink('wars'); ?>">Wars</a></li>
		<?php endif;
		if($config['otserv_version'] == TFS_03): ?>
			<li><a href="<?php echo getLink('bans'); ?>">Bans</a></li>
		<?php endif; ?>
	</ul>
</li>
<li><a href="#">Library</a>
	<ul>
		<li><a href="<?php echo getLink('creatures'); ?>">Monsters</a></li>
		<li><a href="<?php echo getLink('spells'); ?>">Spells</a></li>
		<li><a href="<?php echo getLink('commands'); ?>">Commands</a></li>
		<li><a href="<?php echo getLink('serverInfo'); ?>">Server Info</a></li>
		<li><a href="<?php echo getLink('movies'); ?>">Movies</a></li>
		<li><a href="<?php echo $template['link_screenshots']; ?>">Screenshots</a></li>
		<li><a href="<?php echo getLink('experienceTable'); ?>">Experience Table</a></li>
	</ul>
</li>
<li><?php echo $template['link_forum']; ?>Forum</a></li>
<li><a href="#">Help</a>
	<ul>
		<li><a href="<?php echo getLink('team'); ?>">Support</a></li>
		<li><a href="<?php echo getLink('faq'); ?>">FAQ</a></li>
	</ul>
</li>
<?php if($config['gifts_system']): ?>
<li><a href="#">Shop</a>
	<ul>
		<li><a href="<?php echo getLink('points'); ?>">Buy points</a></li>
		<li><a href="<?php echo getLink('gifts'); ?>">Gifts</a></li>
		<li><a href="<?php echo getLink('gifts/history'); ?>">History</a></li>
	</ul>
</li>
<?php endif; ?>