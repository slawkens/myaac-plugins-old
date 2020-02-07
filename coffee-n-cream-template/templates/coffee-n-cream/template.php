<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php echo template_place_holder('head_start'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/style.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/default.css" />
	<script type="text/javascript" src="tools/basic.js"></script>
	<?php echo template_place_holder('head_end'); ?>
</head>

<body>
<?php echo template_place_holder('body_start'); ?>
<div class="container">

	<div class="header">

		<div class="title">
			<h1><?php echo ucwords($config['lua']['serverName']); ?></h1>
		</div>

	</div>

	<div class="navigation">
		<a href="<?php echo $template['link_news']; ?>"><b>NEWS |</b></a>
		<a href="<?php echo $template['link_serverInfo']; ?>">| Server Info |</a>
		<a href="<?php echo $template['link_creatures']; ?>">| Monsters |</a>
		<a href="<?php echo $template['link_spells']; ?>">| Spells |</a>
		<a href="<?php echo $template['link_online']; ?>">| Players online: </a>
		
		<?php if($status['online'])
			echo '<FONT color="green"><b>' . $status['players'] . '/' . $status['playersMax'] . '</b></FONT>';
		else
			echo '<FONT color="red"><b>OFFLINE</b></FONT>';
		?>
			<div class="clearer"><span></span></div>
		</div>

	<div class="main">

		<div class="content">
			<?php echo template_place_holder('center_top') . $content; ?>
		</div>

		<div class="sidenav">

			<h1>Account</h1>
			<ul>
				<?php
				if($logged): ?>
					<li><a href="<?php echo $template['link_account_manage']; ?>">My Account</a></li>
					<li><a href="<?php echo $template['link_account_logout']; ?>">Logout</a></li>
				<?php else: ?>
					<li><a href="<?php echo $template['link_account_manage']; ?>">Login</a></li>
					<li><a href="<?php echo $template['link_account_create']; ?>">Create Account</a></li>
					<li><a href="<?php echo $template['link_account_lost']; ?>">Lost Account</a></li>
				<?php endif; ?>

				<li><a href="<?php echo $template['link_rules']; ?>">Server Rules</a></li>
				<li><a href="<?php echo $template['link_downloads']; ?>">Download</a></li>
				<?php if($config['bug_report']): ?>
					<li><a href="<?php echo $template['link_bugtracker']; ?>">Report Bug</a></li>
				<?php endif; ?>
			</ul>

			<h1>Community</h1>
			<ul>
				<li><a href="<?php echo $template['link_characters']; ?>">Characters</a></li>
				<li><a href="<?php echo $template['link_guilds']; ?>">Guilds</a></li>
				<li><a href="<?php echo $template['link_highscores']; ?>">Highscores</a></li>
				<li><a href="<?php echo $template['link_lastkills']; ?>">Last Deaths</a></li>
				<li><a href="<?php echo $template['link_houses']; ?>">Houses</a></li>
				<?php if($config['forum'] != ''):
					if($config['forum'] == 'site'): ?>
						<li><a href="<?php echo internalLayoutLink('forum'); ?>">Forum</a></li>
					<?php else: ?>
						<li><a href="<?php echo $config['forum']; ?>" target="_blank">Forum</a></li>
					<?php endif; ?>
				<?php endif;
				if($config['otserv_version'] == TFS_03): ?>
					<li><a href="<?php echo $template['link_bans']; ?>'">Bans</a></li>
				<?php endif; ?>
				<li><a href="<?php echo $template['link_team']; ?>">Team</a></li>
			</ul>

			<h1>Library</h1>
			<ul>
				<li><a href="<?php echo $template['link_creatures']; ?>">Creatures</a></li>
				<li><a href="<?php echo $template['link_spells']; ?>">Spells</a></li>
				<li><a href="<?php echo $template['link_commands']; ?>">Commands</a></li>
				<li><a href="<?php echo $template['link_experienceStages']; ?>">Exp stages</a></li>
				<li><a href="<?php echo $template['link_screenshots']; ?>">Screenshots</a></li>
				<li><a href="<?php echo $template['link_movies']; ?>">Movies</a></li>
				<li><a href="<?php echo $template['link_serverInfo']; ?>">Server info</a></li>
				<li><a href="<?php echo $template['link_experienceTable']; ?>">Experience table</a></li>
			</ul>
			
			<?php if($config['gifts_system']): ?>
				<h1>Shop</h1>
				<ul>
					<li><a href="<?php echo $template['link_points']; ?>">Buy Premium Points</a></li>
					<li><a href="<?php echo $template['link_gifts']; ?>">Shop Offer</a></li>
					<?php if($logged): ?>
						<li><a href="<?php echo $template['link_gifts_history']; ?>">Shop History</a></li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
			<?php if($config['template_allow_change'])
				echo '
			<h1>Change template</h1>
			<ul>
				<li><center>' . template_form() . '
				</center></li>
			</ul>';
			?>
		</div>

		<div class="clearer"><span></span></div>

	</div>

	<div class="footer">

		<span class="left"><?php echo template_footer(); ?></span>

		<span class="right"><a href="http://templates.arcsin.se/">Website template</a> by <a href="https://arcsin.se/">Arcsin</a></span>

		<div class="clearer"><span></span></div>

	</div>

</div>
	<?php echo template_place_holder('body_end'); ?>
</body>

</html>
