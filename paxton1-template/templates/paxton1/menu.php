<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<div id="menu-top">News</div>
<div id="menu-cnt">
	<ul>
		<li>
			<ul>
				<li><a href="<?php echo $template['link_news']; ?>">Latest News</a></li>
				<li><a href="<?php echo $template['link_news_archive']; ?>">News Archive</a></li>
			</ul>
		</li>
	</ul>
</div>
<div id="menu-top">Account</div>
<div id="menu-cnt">
	<ul>
		<li>
			<ul>
				<?php if($logged): ?>
					<li><a href="<?php echo $template['link_account_manage']; ?>">My Account</a></li>
					<li><a href="<?php echo $template['link_account_logout']; ?>">Logout</a></li>
				<?php else: ?>
					<li><a href="<?php echo $template['link_account_manage']; ?>">Login</a></li>
					<li><a href="<?php echo $template['link_account_create']; ?>">Create Account</a></li>
					<li><a href="<?php echo $template['link_account_lost']; ?>">Lost Account</a></li>
				<?php endif; ?>
				<li><a href="<?php echo $template['link_rules']; ?>">Server Rules</a></li>
				<li><a href="<?php echo $template['link_bugtracker']; ?>">Report bug</a></li>
			</ul>
		</li>
	</ul>
</div>
<div id="menu-top">Community</div>
<div id="menu-cnt">
	<ul>
		<li>
			<ul>
				<li><a href="<?php echo $template['link_characters']; ?>">Characters</a></li>
				<li><a href="<?php echo $template['link_online']; ?>">Who is online?</a></li>
				<li><a href="<?php echo $template['link_highscores']; ?>">Highscores</a></li>
				<?php if(isset($config['powergamers'])): ?>
					<li><a href="<?php echo $template['link_powergamers']; ?>">Powergamers</a></li>
				<?php endif; ?>
				<li><a href="<?php echo $template['link_lastkills']; ?>">Last Kills</a></li>
				<li><a href="<?php echo $template['link_houses']; ?>">Houses</a></li>
				<li><a href="<?php echo $template['link_guilds']; ?>">Guilds</a></li>
				<?php if(isset($config['wars'])): ?>
					<li><a href="<?php echo $template['link_wars']; ?>">Guild wars</a></li>
				<?php endif;
				if($config['otserv_version'] == TFS_03): ?>
					<li><a href="<?php echo $template['link_bans']; ?>">Bans</a></li>
				<?php endif;
				if($config['forum'] != ''):
					if($config['forum'] == 'site'): ?>
						<li><a href="<?php echo internalLayoutLink('forum'); ?>">Forum</a></li>
					<?php else: ?>
						<li><a href="<?php echo $config['forum']; ?>" target="_blank">Forum</a></li>
					<?php endif; ?>
				<?php endif; ?>
				<li><a href="<?php echo $template['link_team']; ?>">Team</a></li>
			</ul>
		</li>
	</ul>
</div>
<div id="menu-top">Library</div>
<div id="menu-cnt">
	<ul>
		<li>
			<ul>
				<li><a href="<?php echo $template['link_creatures']; ?>">Creatures</a></li>
				<li><a href="<?php echo $template['link_spells']; ?>">Spells</a></li>
				<li><a href="<?php echo $template['link_commands']; ?>">Commands</a></li>
				<li><a href="<?php echo $template['link_serverInfo']; ?>">Server Info</a></li>
				<li><a href="<?php echo $template['link_downloads']; ?>">Downloads</a></li>
				<li><a href="<?php echo $template['link_screenshots']; ?>">Screenshots</a></li>
				<li><a href="<?php echo $template['link_movies']; ?>">Movies</a></li>
				<li><a href="<?php echo $template['link_experienceTable']; ?>">Experience table</a></li>
				<li><a href="<?php echo $template['link_experienceStages']; ?>">Experience stages</a></li>
				<li><a href="<?php echo $template['link_faq']; ?>">FAQ</a></li>
			</ul>
		</li>
	</ul>
</div>
<?php if($config['gifts_system']): ?>
	<div id="menu-top">Shop</div>
	<div id="menu-cnt">
		<ul>
			<li>
				<ul>
					<li><a href="<?php echo $template['link_points']; ?>">Points</a></li>
					<li><a href="<?php echo $template['link_gifts']; ?>">Gifts</a></li>
					<?php if($logged): ?>
						<li><a href="<?php echo $template['link_gifts_history']; ?>">Shop History</a></li>
					<?php endif; ?>
				
				</ul>
			</li>
		</ul>
	</div>
<?php endif; ?>