<div id="news">
	<div class="button" onclick="menuAction('news');">
		<div id="news_Status" class="status" style="background-image: url(<?php echo $template_path; ?>/images/menu/open.png);"></div>
		<div id="news_Icon" class="icon" style="background-image: url(<?php echo $template_path; ?>/images/menu/news_icon.png);"></div>
		<div id="news_Name" class="name" style="background-image: url(<?php echo $template_path; ?>/images/menu/news.png);"></div>
	</div>
	<div id="news_Submenu">
		<div class="submenu">
			<ul>
				<li id="latestnews" class="menu-item"><a href="<?php echo $template['link_news']; ?>">Latest News</a></li>
				<li id="newsarchive" class="menu-item"><a href="<?php echo $template['link_news_archive']; ?>">News Archives</a></li>
			</ul>
		</div>
	</div>
</div>

<div id="account">
	<div class="button" onclick="menuAction('account');">
		<div id="account_Status" class="status" style="background-image: url(<?php echo $template_path; ?>/images/menu/open.png);"></div>
		<div id="account_Icon" class="icon" style="background-image: url(<?php echo $template_path; ?>/images/menu/account_icon.png);"></div>
		<div id="account_Name" class="name" style="background-image: url(<?php echo $template_path; ?>/images/menu/account.png);"></div>
	</div>
	<div id="account_Submenu">
		<div class="submenu">
			<ul>
				<?php if($logged): ?>
					<li id="accountmanage" class="menu-item"><a href="<?php echo $template['link_account_manage']; ?>">My Account</a></li>
					<li id="logout" class="menu-item"><a href="<?php echo $template['link_account_logout']; ?>">Logout</a></li>
				<?php else: ?>
					<li id="accountmanage" class="menu-item"><a href="<?php echo $template['link_account_manage']; ?>">Login</a></li>
					<li id="createaccount" class="menu-item"><a href="<?php echo $template['link_account_create']; ?>">Create Account</a></li>
					<li id="lostaccount" class="menu-item"><a href="<?php echo $template['link_account_lost']; ?>">Lost Account</a></li>
				<?php endif; ?>
				<li id="rules" class="menu-item-last"><a href="<?php echo $template['link_rules']; ?>">Server Rules</a></li>
				<li id="downloads" class="menu-item-last"><a href="<?php echo $template['link_downloads']; ?>">Downloads</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="community">
	<div class="button" onclick="menuAction('community');">
		<div id="community_Status" class="status" style="background-image: url(<?php echo $template_path; ?>/images/menu/open.png);"></div>
		<div id="community_Icon" class="icon" style="background-image: url(<?php echo $template_path; ?>/images/menu/community_icon.png);"></div>
		<div id="community_Name" class="name" style="background-image: url(<?php echo $template_path; ?>/images/menu/community.png);"></div>
	</div>
	<div id="community_Submenu">
		<div class="submenu">
			<ul>
				<li id="characters" class="menu-item"><a href="<?php echo $template['link_characters']; ?>">Characters</a></li>
				<li id="online" class="menu-item"><a href="<?php echo $template['link_online']; ?>">Who is Online</a></li>
				<li id="highscores" class="menu-item"><a href="<?php echo $template['link_highscores']; ?>">Highscores</a></li>
				<li id="lastkills" class="menu-item"><a href="<?php echo $template['link_lastkills']; ?>">Last Kills</a></li>
				<li id="houses" class="menu-item"><a href="<?php echo $template['link_houses']; ?>">Houses</a></li>
				<li id="guilds" class="menu-item"><a href="<?php echo $template['link_guilds']; ?>">Guilds</a></li>
				<?php if(isset($config['wars'])): ?>
					<li id="wars" class="menu-item"><a href="<?php echo $template['link_war']; ?>">Wars</a></li>
				<?php endif;
				if($config['otserv_version'] == TFS_03): ?>
					<li id="bans" class="menu-item"><a href="<?php echo $template['link_bans']; ?>">Bans</a></li>
				<?php endif; ?>
				<li id="team" class="menu-item"><a href="<?php echo $template['link_team']; ?>">Support List</a></li>
				<?php if($config['forum'] != ''): ?>
					<li id="forum" class="menu-item-last"><?php echo $template['link_forum']; ?>Forum</a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>

<div id="library">
	<div class="button" onclick="menuAction('library');">
		<div id="library_Status" class="status" style="background-image: url(<?php echo $template_path; ?>/images/menu/open.png);"></div>
		<div id="library_Icon" class="icon" style="background-image: url(<?php echo $template_path; ?>/images/menu/library_icon.png);"></div>
		<div id="library_Name" class="name" style="background-image: url(<?php echo $template_path; ?>/images/menu/library.png);"></div>
	</div>
	<div id="library_Submenu">
		<div class="submenu">
			<ul>
				<li id="creatures" class="menu-item"><a href="<?php echo $template['link_creatures']; ?>">Monsters</a></li>
				<li id="spells" class="menu-item"><a href="<?php echo $template['link_spells']; ?>">Spells</a></li>
				<li id="commands" class="menu-item"><a href="<?php echo $template['link_commands']; ?>">Commands</a></li>
				<li id="serverinfo" class="menu-item"><a href="<?php echo $template['link_serverInfo']; ?>">Server Info</a></li>
				<li id="movies" class="menu-item"><a href="<?php echo $template['link_movies']; ?>">Movies</a></li>
				<li id="screenshots" class="menu-item"><a href="<?php echo $template['link_screenshots']; ?>">Screenshots</a></li>
				<li id="experiencetable" class="menu-item"><a href="<?php echo $template['link_experienceTable']; ?>">Experience table</a></li>
				<li id="faq" class="menu-item"><a href="<?php echo $template['link_faq']; ?>">FAQ</a></li>
			</ul>
		</div>
	</div>
</div>
<?php
if($config['gifts_system'])
{
	?>
	<div id="shops">
		<div class="button" onclick="menuAction('shops');">
			<div id="shops_Status" class="status" style="background-image: url(<?php echo $template_path; ?>/images/menu/open.png);"></div>
			<div id="shops_Icon" class="icon" style="background-image: url(<?php echo $template_path; ?>/images/menu/shops_icon.png);"></div>
			<div id="shops_Name" class="name" style="background-image: url(<?php echo $template_path; ?>/images/menu/shops.png);"></div>
		</div>
		<div id="shops_Submenu">
			<div class="submenu">
				<ul>
					<li id="points" class="menu-item"><a href="<?php echo $template['link_points']; ?>">Buy Points</a></li>
					<li id="gifts" class="menu-item"><a href="<?php echo $template['link_gifts']; ?>">Shop Offer</a></li>
					<li class="menu-item-last"><a href="<?php echo $template['link_gifts_history']; ?>">Shop History</a></li>
				</ul>
			</div>
		</div>
	</div>
	<?php
}
?>
