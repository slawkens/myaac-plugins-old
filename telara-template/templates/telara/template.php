<?php
defined('MYAAC') or die('Direct access not allowed!');

if (!function_exists('mostPowerfulGuildsList') && !function_exists('mostPowerfulGuildsDatabase')) {
	require_once __DIR__ . '/powerful_guilds.php';
}

$topData = '';
$i = 0;
foreach(getTopPlayers(5) as $player) {
	$i++;
	$topData .= '<tr><td style="width: 80%"><strong>'.$i.'.</strong> <a href="' . getPlayerLink($player['name'],
	false) . '">'
	.$player['name']
	.'</a></td><td><span class="label label-primary">Lvl. '.$player['level'].'</span></td></tr>';
}
?>

<!DOCTYPE html>
<html class="no-js" lang="">
<head>
	<?php echo template_place_holder('head_start'); ?>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/slick.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/slick-theme.css" />
	<link rel="stylesheet" href="<?php echo $template_path; ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $template_path; ?>/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="<?php echo $template_path; ?>/css/main.css">
	<!-- End CSS -->

	<!-- JS Scripts -->
	<script src="<?php echo $template_path; ?>/js/modernizr-2.8.3-respond-1.4.2.min.js"></script>
	<script src="<?php echo $template_path; ?>/js/bootstrap.min.js"></script>
	<!-- End JS -->

	<script>
		$(document).ready(function(){
			$(".dropdown-toggle").dropdown();
		});
	</script>
	<?php echo template_place_holder('head_end'); ?>
</head>
<body>
	<?php echo template_place_holder('body_start'); ?>
<div class="status-bar notranslate">
	<div class="container">
		<div class="item">
			<a href="<?= getLink('online') ?>"><?PHP echo $status['players']; ?>
				<?php
				if($status['online'])
					echo '<span class="label label-success label-sm">Online</span>';
				else
					echo '<span class="label label-danger label-sm">Offline</span>';
				?>
			</a>
		</div>
		<div class="item">
			ip:<span class="value"><?php echo $_SERVER['SERVER_NAME']; ?></span>
		</div>
		<div class="item">
			version:<span class="value"><?= ($config['client'] / 100); ?></span>
		</div>
		<div class="item">
			port:<span class="value">7171</span>
		</div>
		<div class="item">
			<a href="<?= getLink('downloads'); ?>" class="value">Download Client</a>
		</div>
		<div class="item pull-right" style="border-right:1px solid #4a8cb2;">
			<div id="google_translate_element"></div>
			<script type="text/javascript">
				function googleTranslateElementInit() {
					new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'es,pl,pt', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT, gaTrack: true, gaId: 'UA-67686388-1'}, 'google_translate_element');
				}
			</script>
			<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		</div>
	</div>
</div>
<div class="container">
	<a href="/" class="logo"></a>
</div>
<div class="menu container">
	<nav class="navbar navbar-default" style="margin-bottom: 0;">
		<div class="notranslate" id="">
			<ul class="nav navbar-nav">

				<li><a href="<?= getLink('news'); ?>">Home</a></li>
				<li><a href="<?= getLink('forum'); ?>">Forum</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= getLink('account/manage'); ?>">Manage account</a></li>
						<li><a href="<?= getLink('account/create'); ?>">Create account</a></li>
						<li><a href="<?= getLink('account/lost'); ?>">Account lost?</a></li>
						<li><a href="<?= getLink('downloads'); ?>">Download Client</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Community <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= getLink('characters'); ?>">Search character</a></li>
						<li><a href="<?= getLink('highscores'); ?>">Highscores</a></li>
						<li><a href="<?= getLink('online'); ?>">Who is online?</a></li>
						<li><a href="<?= getLink('lastkills'); ?>">Latest Kills</a></li>
						<li><a href="<?= getLink('houses'); ?>">Houses</a></li>
						<li><a href="<?= getLink('guilds'); ?>">Guilds</a></li>
						<li><a href="<?= getLink('team'); ?>">Team</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Library <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= getLink('creatures'); ?>">Monsters</a></li>
						<li><a href="<?= getLink('spells'); ?>">Spells</a></li>
						<li><a href="<?= getLink('commands'); ?>">Commands</a></li>
						<li><a href="<?= getLink('serverInfo'); ?>">Server info</a></li>
						<li><a href="<?= getLink('gallery'); ?>">Gallery</a></li>
						<li><a href="<?= getLink('experienceTable'); ?>">Experience Table</a></li>
					</ul>
				</li>
				<?php if($config['gifts_system']): ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?= getLink('points'); ?>">Points</a></li>
						<li><a href="<?= getLink('gifts'); ?>">Gifts</a></li>
					</ul>
				</li>
				<?php endif; ?>
			</ul>
			<form method="post" class="navbar-form navbar-right" style="margin-right:0;" action="<?= getLink('characters'); ?>">
				<div class="form-group">
					<input type="text" name="name" placeholder="Search Character" class="form-control" onfocus="this.value=''"">
				</div>
				<input type="submit" name="Submit" class="btn btn-primary btn-sm" value="Search">
			</form>
		</div>
	</nav>
</div>
	<div class="content">
		<div class="container">
			<div class="content-wrapper">
				<div class="corner-top-left"></div>
				<div class="corner-top-right"></div>
				<div class="col-xs-8 main-content">
				<div class="news">
					<div class="clearfix"></div>

					<?php echo tickers() . template_place_holder('center_top') . $content; ?>

					<div class="clearfix"></div>
				</div>
			</div>

			<div class="col-xs-4 right-panel notranslate">
				<div class="box teamspeak">
					<div class="head">Account</div>
					<?php if($logged) {?>
					<div class="box informations">
							<div class="box-content">
								<div class="item">
									<div class="wrap">
										<div class="left"></div>
										<div class="centered">
										<h3>Welcome Back!</h3>
											<strong>
											<?php if (USE_ACCOUNT_NAME): ?>
												Account Name: <?PHP echo $account_logged->getName(); ?>
											<?php else: ?>
												Account Number: <?PHP echo $account_logged->getId(); ?>
											<?php endif; ?>
											</strong>
										<br/>
										<a href="<?= getLink('account/manage'); ?>">Manage account</a>
										<br/>
										<br/>
										<a class="btn btn-xs btn-danger" href="<?= getLink('account/logout'); ?>">Logout</a>
										</div>
										<br>
									</div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="tab-pane active" id="login">
							<form class="form" role="form" action="<?= getLink('account/manage') ?>" method="post">
								<div class="form-group">
									<input type="text" maxlength="35" name="account_login" class="form-control" placeholder="Account Name" required />
								</div>
								<div class="form-group">
									<input type="password" maxlength="30" name="password_login" class="form-control" placeholder="Password" required/>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">Sign in</button>
								</div>
							</form>
							<a href="<?= getLink('account/create'); ?>" class="btn btn-success btn-block">Register new Account</a>
						</div>
						<?php } ?>
					</div>

					<div class="box informations">
						<div class="head">Informations</div>
						<div class="box-content">
							<div class="item">
								<div class="wrap">
									<div class="left"></div>
									<div class="centered">
										<table class="table table-condensed table-content table-striped">
											<tbody>
												<tr>
													<td><b>IP:</b></td><td><?php echo $_SERVER['SERVER_NAME']; ?></td>
												</tr>
												<tr>
													<td><b>Experience:</b></td> <td><a href="<?= getLink('experienceStages') ?>>">Stages</a></td>
												</tr>
												<tr>
													<td><b>Client:</b></td><td><?= ($config['client'] / 100); ?></td>
												</tr>
												<tr style="border-bottom:1px solid #eeeeee;">
													<td><b>Type:</b></td> <td>Retro Open PvP</td>
												</tr>
											</tbody>
										</table>
										<a style="margin-top: 10px;" href="<?= getLink('downloads'); ?>" class="btn btn-info form-control">Download Client</a>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="box">
						<div class="head">Stats</div>
						<div class="box-content">
							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#toplevel">Top Level</a></li>
								<li><a data-toggle="tab" href="#topguilds">Top Guilds</a></li>
								<li><a data-toggle="tab" href="#topfrag">Top Frag</a></li>
							</ul>

							<div class="tab-content">
								<div id="toplevel" class="tab-pane fade in active">
									<table class="table table-condensed table-content table-striped">
										<tbody>
											<?php echo $topData; ?>
										</tbody>
									</table>
								</div>
								<div id="topguilds" class="tab-pane fade">
									<table class="table table-condensed table-content table-striped">
										<tbody>
											<?php
											$guildsPower = mostPowerfulGuildsList();
											$i = 0;
											foreach($guildsPower as $guild) {
												echo '
												<tr><td>' . ++$i . '.</td><td><a href="' . getGuildLink($guild['id'],
														false) .	'"><img 
												src="guild_image.php?id=' . $guild['id'] . '" width="16" height="16" border="0"/> ' . $guild['name'] . '</a>&nbsp;<td><span class="label label-danger pull-right">' . $guild['frags'] . ' kills</td></span></td></tr>';
											}
											?>
										</tbody>
									</table>

								</div>
								<?php if(tableExist('killers') && tableExist('player_killers')) { ?>
								<div id="topfrag" class="tab-pane fade">
<?php
		$frags_database = $db->query('SELECT `p`.`name` AS `name`, COUNT(`p`.`name`) as `frags` FROM `killers` k LEFT JOIN `player_killers` pk ON `k`.`id` = `pk`.`kill_id` LEFT JOIN `players` p ON `pk`.`player_id` = `p`.`id` WHERE `k`.`unjustified` = 1 AND `k`.`final_hit` = 1 GROUP BY `name` ORDER BY `frags` DESC, `name` ASC LIMIT 0,30;');
		$i = 0;
		foreach($frags_database as $frag)
		{
			$i++;
			echo '<div style="text-align: left;"> <a href="' . getPlayerLink(urlencode($frag['name']), false).'" class="topfont"> <b>
			<span style="color: black">&nbsp;&nbsp;&nbsp;&nbsp; '.$i.' - </span></b>' . $frag['name'] . ' <br/><small><b>
			<span style="color: white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Frags: '.$frag['frags'].' </span></b></small><br/></a></div>';
		}
		?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="box latest-posts">
						<div class="head">Latest posts</div>
						<div class="box-content">
							<div style="padding-left:20px; text-align: left;">
							<?php
							$lastPosts = '';
							$order = 0;
							$post = $db->query('SELECT id,post_topic,post_date,author_guid FROM myaac_forum ORDER BY last_post DESC LIMIT 10');
							foreach($post as $posts) {
								$player = new OTS_Player();
								$player->load($posts['author_guid']);
								$lastPosts .= '
									<tr style="text-align: center;">
										<td>
											'.$order.'.
										</td>
										<td style="text-align: left;">
											<B><a href="' . getForumThreadLink($posts['id']) . '">'.$posts['post_topic'].'</a>
										</td>
										<td>
											<span style="color: #333"><em>'.$player->getName().'</em></span>
										</td>
										<td>
											<span style="color: #333"></span><br>
										</td>
									</tr>';
									$order++;
							}
							echo $lastPosts;
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="centered small">
					<?php echo template_footer();
					if($config['template_allow_change'])
						echo template_form();
					?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</body>
</html>
