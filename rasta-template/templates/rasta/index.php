<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php echo template_place_holder('head_start'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/default.css" media="screen"/>
	<script type="text/javascript" src="tools/basic.js"></script>
	<?php echo template_place_holder('head_end'); ?>
</head>

<body>
	<?php echo template_place_holder('body_start'); ?>
<div class="outer-container">

<div class="inner-container">

	<div class="header">

		<div class="title">

			<span class="sitename"><a href="index.php"><font color="green"><?php echo ucwords($config['lua']['serverName']); ?></font></a></span>
			<div class="slogan"><font color="black"><b>IP:</b> <?php echo $config['lua']['ip']; ?></font></div>

		</div>

	</div>
	<div class="path">
<a href="<?php echo $template['link_news']; ?>"><b><font color="red">NEWS |</font></b></a>
<?php if(!$logged): ?>
	<a href="<?php echo $template['link_account_create']; ?>"><font color="yellow"><b>| Create Account |</b></font></a>
<?php endif; ?>

<a href="<?php echo $template['link_serverInfo']; ?>"><b><font color="green">| Server Info |</font></font></b></a>
<a href="<?php echo $template['link_creatures']; ?>"><b><font color="red">| Monsters |</font></b></a>
<a href="<?php echo $template['link_spells']; ?>"><b><font color="yellow">| Spells |</font></b></a>
<a href="<?php echo $template['link_online']; ?>"><b><font color="green">| Players online: </font></b></a>

<?php if($status['online'])
	echo '<FONT color="green"><b>' . $status['players'] . '/' . $status['playersMax'] . '</b></FONT>';
else
	echo '<FONT color="red"><b>OFFLINE</b></FONT>';
?>
	</div>

	<div class="main">
		<div class="content">
			<?php echo template_place_holder('center_top') . $content; ?>
		</div>

		<div class="navigation">

			<h1><font color="green">Account</font></h1>
			<ul>
				<?php
				if($logged): ?>
					<li><a href="<?php echo $template['link_account_manage']; ?>"><b><font size="1">My Account</font></b></a></li>
					<li><a href="<?php echo $template['link_account_logout']; ?>"><b><font size="1">Logout</font></b></a></li>
				<?php else: ?>
					<li><a href="<?php echo $template['link_account_manage']; ?>"><b><font size="1">Login</font></b></a></li>
					<li><a href="<?php echo $template['link_account_create']; ?>"><b><font size="1" color="red">Create Account</font></b></a></li>
					<li><a href="<?php echo $template['link_account_lost']; ?>"><b><font size="1">Lost Account</font></b></a></li>
				<?php endif; ?>

				<li><a href="<?php echo $template['link_rules']; ?>"><b><font size="1">Server Rules</font></b></a></li>
				<li><a href="<?php echo $template['link_downloads']; ?>"><b><font size="1">Download</font></b></a></li>
				<?php if($config['bug_report']): ?>
					<li><a href="<?php echo $template['link_bugtracker']; ?>"><b><font size="1">Report Bug</font></b></a></li>
				<?php endif; ?>
			</ul>

			<h1><font color="green">Community</font></h1>
			<ul>
				<li><a href="<?php echo $template['link_characters']; ?>"><b><font size="1">Characters</font></b></a></li>
				<li><a href="<?php echo $template['link_guilds']; ?>"><b><font size="1">Guilds</font></b></a></li>
				<li><a href="<?php echo $template['link_highscores']; ?>"><b><font size="1">Highscores</font></b></a></li>
				<li><a href="<?php echo $template['link_lastkills']; ?>"><b><font size="1">Last Deaths</font></b></a></li>
				<li><a href="<?php echo $template['link_houses']; ?>"><b><font size="1">Houses</font></b></a></li>
				<?php if($config['forum'] != ''):
					if($config['forum'] == 'site'): ?>
						<li><a href="<?php echo internalLayoutLink('forum'); ?>"><b><font size="1">Forum</font></b></a></li>
					<?php else: ?>
						<li><a href="<?php echo $config['forum']; ?>" target="_blank"><b><font size="1">Forum</font></b></a></li>
					<?php endif; ?>
				<?php endif;
				if($config['otserv_version'] == TFS_03): ?>
				<li><a href="<?php echo $template['link_bans']; ?>'"><b><font size="1">Bans</font></b></a></li>
				<?php endif; ?>
				<li><a href="<?php echo $template['link_team']; ?>"><b><font size="1">Team</font></b></a></li>
			</ul>
			<h1><font color="green">Library</font></h1>
			<ul>
<li><a href="<?php echo $template['link_creatures']; ?>"><b><font size="1">Creatures</font></b></a></li>
<li><a href="<?php echo $template['link_spells']; ?>"><b><font size="1">Spells</font></b></a></li>
<li><a href="<?php echo $template['link_commands']; ?>"><b><font size="1">Commands</font></b></a></li>
<li><a href="<?php echo $template['link_experienceStages']; ?>"><b><font size="1">Exp stages</font></b></a></li>
<li><a href="<?php echo $template['link_screenshots']; ?>"><b><font size="1">Screenshots</font></b></a></li>
<li><a href="<?php echo $template['link_movies']; ?>"><b><font size="1">Movies</font></b></a></li>
<li><a href="<?php echo $template['link_serverInfo']; ?>"><b><font size="1">Server info</font></b></a></li>
<li><a href="<?php echo $template['link_experienceTable']; ?>"><b><font size="1">Experience table</font></b></a></li>
			</ul>

<?php if($config['gifts_system']): ?>
			<h1><font color="green">Shop</font></h1>
			<ul>
				<li><a href="<?php echo $template['link_points']; ?>"><b><font size="1" color="red"><blink>Buy Premium Points</blink></font></b></a></li>
				<li><a href="<?php echo $template['link_gifts']; ?>"><b><font size="1">Shop Offer</font></b></a></li>
				<?php if($logged): ?>
					<li><a href="<?php echo $template['link_gifts_history']; ?>"><b><font size="1">Shop History</font></b></a></li>
				<?php endif; ?>
			</ul>
<?php endif; ?>
<?php if($config['template_allow_change'])
echo '
			<h1><font color="green">Change template</font></h1>
			<ul>
				<li><center>' . template_form() . '
				</center></li>
			</ul>';
?>
		</div>

		<div class="clearer">&nbsp;</div>

	</div>

	<div class="footer">
		<span class="left"><?php echo template_footer(); ?></span>

		<span class="right">

			<a href="http://templates.arcsin.se">Website template</a> by <a href="http://arcsin.se">Arcsin</a>

		</span>

		<div class="clearer"></div>

	</div>

</div>

</div>
	<?php echo template_place_holder('body_end'); ?>
</body>
</html>
