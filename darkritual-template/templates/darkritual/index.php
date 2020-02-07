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
<div class="container">
	<div class="header"><?php echo ucwords($config['lua']['serverName']); ?></div>

	<div class="main_right">
		<div class="padded">
			<h1>Server Info</h1>
			<?php
			if($status['online'])
				echo '<font color="green"><b>Server ONLINE</b></font><br />Players Online: '.$status['players'].' / '.$status['playersMax'].'<br />Monsters: '.$status['monsters'].'<br />Uptime: '.$status['uptimeReadable'].'<br />IP: '.$config['lua']['ip'];
			else
				echo '<font color="red"><b>Server OFFLINE</b></font>';
			?>
			<br /><br /><br /><br /><br /><br /><br />
		</div>
	</div>

	<div class="subnav">
		<h1>News</h1>
		<ul>
			<li><a href="<?php echo $template['link_news']; ?>">Latest News</a></li>
			<li><a href="<?php echo $template['link_news_archive']; ?>">News archive</a></li>
			<!--li><a href="<?php echo internalLayoutLink('changelog'); ?>">Changelog</a></li-->
		</ul>

		<h1>Account</h1>
		<ul>
				<?php
				if($logged)
				{
					echo '<li><a href="' . $template['link_account_manage'] . '"><b><font color="green">My Account</font></b></a></li>
					<li><a href="' . $template['link_account_logout'] . '"><b><font color="white">Logout</font></b></a></li>';
				}
				else
				{
					echo '<li><a href="' . $template['link_account_manage'] . '"><b><font color="white">Login</font></b></a></li>';
				}

				if(!$logged)
					echo '<li><a href="' . $template['link_account_create'] . '"><b><font color="white">Create Account</font></b></a></li>';

				echo '<li><a href="' . $template['link_account_lost'] . '">Lost Account Interface</a></li>
				<li><a href="' . $template['link_rules'] . '">Server Rules</a></li>
		</ul>

		<h1>Community</h1>
		<ul>
				<li><a href="' . $template['link_characters'] . '">Characters</a></li>
				<li><a href="' . $template['link_online'] . '">Who is online?</a></li>
				<li><a href="' . $template['link_guilds'] . '">Guilds</a></li>
				<li><a href="' . $template['link_highscores'] . '">Highscores</a></li>
				<li><a href="' . $template['link_lastkills'] . '">Last kills</a></li>
				<li><a href="' . $template['link_houses'] . '">Houses</a></li>';
				if(!empty($config['forum'])) {
					echo '<li>' . $template['link_forum'] . 'Forum</a></li>';
				}
				if(tableExist('bans'))
					echo '<li><a href="' . $template['link_bans'] . '">Bans</a></li>';
				echo '
				<li><a href="' . $template['link_team'] . '">Team</a></li>
		</ul>

		<h1>Library</h1>
		<ul>
				<li><a href="' . $template['link_creatures'] . '">Monsters</a></li>
				<li><a href="' . $template['link_spells'] . '">Spells</a></li>
				<li><a href="' . $template['link_commands'] . '">Commands</a></li>
				<li><a href="' . $template['link_experienceStages'] . '">Experience stages</a></li>
				<li><a href="' . $template['link_serverInfo'] . '">Server Info</a></li>
				<li><a href="' . $template['link_screenshots'] . '">Screenshots</a></li>
				<li><a href="' . $template['link_movies'] . '">Movies</a></li>
				<li><a href="' . $template['link_faq'] . '">FAQ</a></li>
		</ul>';

if($config['gifts_system'])
{
			echo '<h1>Shop</h1>
			<ul>
				<li><a href="' . $template['link_points'] . '"><b><font size="1" color="red"><blink>Buy Premium Points</blink></font></b></a></li>
				<li><a href="' . $template['link_gifts'] . '">Shop Offer</a></li>';
				if($logged)
					echo '<li><a href="?subtopic=gifts&action=show_history">Shop History</a></li>';
			echo '</ul>';
}

?>
	<h1>Change style:</h1>
			<ul>
				<li><center><?php
	if($config['template_allow_change'])
		 echo template_form();
				?></center></li>
			</ul>

	</div>

?>
	<div class="main">
		<div class="padded">
			<?php echo $content; ?>
		</div>
	</div>
	<div class="clearer"><span></span></div>
	<div class="footer">
		<span class="left"><?php echo template_footer(); ?></span>
		<span class="right">Design by <a href="http://arcsin.se/" target="_blank">Arcsin</a> <a href="http://templates.arcsin.se/"target="_blank">Web Templates</a></span>
		<div class="clearer"><span></span></div>
	</div>
</div>
	<?php echo template_place_holder('body_end'); ?>
</body>
</html>
