<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php echo template_place_holder('head_start'); ?>
		<!-- Icons -->
		<link rel="shortcut icon" href="<?php echo $template_path; ?>/images/favicon.gif" />
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/default.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/bootstrap.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!--script type="text/javascript" src="<?php echo $template_path; ?>/js/misc.js"></script-->
		<?php echo template_place_holder('head_end'); ?>
	</head>
	<body>
		<div id="container">
			<div class="header"></div>
			<nav class="navbar navbar-inverse" role="navigation">
				<div class="container-fluid">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i>Community<b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo $template['link_characters']; ?>">Characters</a></li>
										<li><a href="<?php echo $template['link_online']; ?>">Online</a></li>
										<li><a href="<?php echo $template['link_highscores']; ?>">Highscores</a></li>
										<li><a href="<?php echo $template['link_lastkills']; ?>">Last kills</a></li>
										<li><a href="<?php echo $template['link_houses']; ?>">Houses</a></li>
										<li><a href="<?php echo $template['link_guilds']; ?>">Guilds</a></li>
										<?php if(isset($config['wars'])): ?>
										<li><a href="<?php echo $template['link_wars']; ?>">Guild Wars</a></li>
										<?php endif; ?>
									</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book"></i> Library <b class="caret"></b></a>
										<ul class="dropdown-menu">
											<li><a href="<?php echo $template['link_creatures']; ?>">Monsters</a></li>
											<li><a href="<?php echo $template['link_spells']; ?>">Spells</a></li>
											<li><a href="<?php echo $template['link_commands']; ?>">Commands</a></li>
											<li><a href="<?php echo $template['link_experienceStages']; ?>">Experience stages</a></li>
											<li><a href="<?php echo $template['link_serverInfo']; ?>">Server Information</a></li>
											<li><a href="<?php echo $template['link_screenshots']; ?>">Screenshots</a></li>
											<li><a href="<?php echo $template['link_movies']; ?>">Movies</a></li>
										</ul>
							</li>
							<?php if($config['gifts_system']): ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i> Shop <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $template['link_points']; ?>">Buy points</a></li>
									<li><a href="<?php echo $template['link_gifts']; ?>">Gifts</a></li>
								</ul>
							</li>
							<?php endif; ?>
							<li><?php echo $template['link_forum']; ?><i class="fa fa-comment"></i> Forum</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-question-circle"></i> Help <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $template['link_team']; ?>">Support</a></li>
									<li><a href="<?php echo $template['link_faq']; ?>">FAQ</a></li>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-left">
							<form class="navbar-form navbar-left" role="search" type="submit" method="get">
								<div class="form-group">
									<input type="hidden" name="subtopic" value="characters"/>
									<input type="text" maxlength="45" name="name" class="form-control" style="max-width: 130px;" placeholder="Search character..." required />
								</div>
							</form>
						</ul>

						<ul class="nav navbar-nav navbar-right">
              				<?php if (!$logged) { ?>
              				<li> <a href="<?php echo $template['link_account_create']; ?>"><i class="fa fa-share"></i> Sign Up</a></li>
                  			<li class="dropdown">
                  				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign in <b class="caret"></b></a>
								<ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
								<li>
									<div class="row">
										<div class="col-md-12">
											<form action="<?php echo $template['link_account_manage']; ?>" method="post">
												<div class="form-group">
													<input type="password" name="account_login" class="form-control" placeholder="Account Name" required />
												</div>
												<div class="form-group">
													<input type="password" name="password_login" class="form-control" placeholder="Password" required />
												</div>
												<div class="form-group">
													<button type="submit" class="btn btn-primary btn-block">Sign in</button>
												</div>
											</form>
										</div>
									</div>
								</li>
								<li class="divider"></li>
								<li><p><a href="<?php echo $template['link_account_lost']; ?>" class="btn btn-danger form-control">Account Lost?</a></p></li>
							</li>
							<?PHP } else { ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong><?php echo $account_logged->getName(); ?></strong> <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo $template['link_account_manage']; ?>">Account Management</a></li>
										<li><a href="<?php echo BASE_URL; ?>?subtopic=accountmanagement&action=createcharacter">Create Character</a></li>
										<li><a href="<?php echo BASE_URL; ?>?subtopic=accountmanagement&action=changepassword">Change Password</a></li>
										<li class="nav-divider"></li>
										<li><a href="<?php echo BASE_URL; ?>?subtopic=accountmanagement&action=logout">Sign out</a></li>
									</ul>
								</li>
							<?PHP } ?>
						</ul>
					</div>
				</div>
			</nav>
			<div class="sidebar">
				<?php if ($logged && admin()): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Administration Panel</h3>
					</div>
					<div class="panel-body">
						<ul>
							<li>
								<?php echo generateLink(ADMIN_URL, 'Admin Panel', true); ?>
							</li>
						</ul>
					</div>
				</div>
				<?php endif; ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Top 5 Level</h3>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-content table-striped">
							<tbody>
								<?php
									$fetch_from_db = true;
									if($cache->enabled())
									{
										$tmp = '';
										if($cache->fetch('top_5_level', $tmp))
										{
											$players = unserialize($tmp);
											$fetch_from_db = false;
										}
									}

									if($fetch_from_db)
									{
										$players_db = $db->query('SELECT `name`, `level`, `experience` FROM `players` WHERE `group_id` < ' . $config['highscores_groups_hidden'] . ' AND `id` > 6 ORDER BY `experience` DESC LIMIT 5;');

										$players = array();
										foreach($players_db as $player)
											$players[] = array('name' => $player['name'], 'level' => $player['level']);
		
										if($cache->enabled())
											$cache->set('top_5_level', serialize($players), 120);
									}
									
									if ($players) {
										$count = 1;
										foreach($players as $player) {
											echo "<tr><td class='labelbox' width='50%'>$count - <a href='?subtopic=characters&name=". $player['name']. "'>". $player['name']. "</a> <span class='label label-primary' style='float:right;width: 55px;'>Level: ". $player['level'] ."</span></td></<tr>";
											$count++;
										}
									}
									?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Information</h3>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-content table-striped">
							<tbody>
								<tr>
									<td><b>IP:</b></td> <td><?php echo $_SERVER['SERVER_NAME']; ?></td>
								</tr>
								<tr>
									<td><b>Client:</b></td> <td><?php echo ($config['client'] / 100); ?></td>
								</tr>
								<tr>
									<td><b>Type:</b></td> <td>PvP</td>
								</tr>
							</tbody>
						</table>
						<p><a href="http://static.otland.net/ipchanger.exe" class="btn btn-success form-control">Download IP Changer</a></p>
						<a href="<?php echo $template['link_downloads']; ?>" class="btn btn-danger form-control">Download Client</a>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Server Status</h3>
					</div>
					<div class="panel-body">
						<table class="table table-condensed table-content table-striped">
							<tbody>
								<tr>
									<?php
										if(!$status['online']) {
											echo '<td colspan=2>Status: <span class="label label-danger pull-right">Offline!</span></td>';
										}
										else {
											echo '<td colspan=2>Status: <span class="label label-success pull-right">Online!</span></td>';
										}
									?>
								</tr>
								<?php if ($status['online']) { ?>
								<tr>
									<td><a href="<?php echo $template['link_online']; ?>"><?php echo $status['players']; ?> players online</a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php if($config['template_allow_change']): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Change style</h3>
					</div>
					<div class="panel-body">
						<ul>
							<li>
								<?php echo template_form(); ?>
							</li>
						</ul>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="content">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php echo template_place_holder('center_top') . $content; ?>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" style="text-align: center;">
				<?php echo template_footer(); ?><br/>
				<b>Template by:</b> <a href="https://otland.net/members/webo.192791/" target="_blank">Webo</a>.
			</div>
		</div>
		<script src="<?php echo $template_path; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo $template_path; ?>/js/jquery.countdown.min.js"></script>
		<?php echo template_place_holder('body_end'); ?>
	</body>
</html>