<?php
defined('MYAAC') or die('Direct access not allowed!');

$menus = get_template_menus();
if(count($menus) === 0) {
	$text = "Please install the $template_name template in Admin Panel, so the menus will be imported too.";
	throw new RuntimeException($text);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo template_place_holder('head_start'); ?>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Amarante|Mirza" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= $template_path; ?>/style.css">
	<link rel="stylesheet" type="text/css" href="<?= $template_path; ?>/tibia.css">
	<script src="<?= $template_path; ?>/cufon-yui.js"></script>
	<script src="<?= $template_path; ?>/jquery.slides.min.js"></script>
	<script src="<?= $template_path; ?>/Trajan_Pro_400.font.js"></script>
	<script type="text/javascript">
		Cufon.replace('.cufon', {
			color: '-linear-gradient(#ffa800, #6a3c00)',
			textShadow: '#14110c 1px 1px, #14110c -1px 1px'
		});
	</script>
	<style>
		.display-none {
			display: none !important;
		}

		.display-inline {
			display: inline !important;
		}
	</style>
	<script>
		$(function(){
			$('.changelog_trigger').click(function(e){
				e.preventDefault();
				$('.minus'+$(this).attr('targetid')).toggle();
				$('.plus'+$(this).attr('targetid')).toggle();

				$('.changelog_big'+$(this).attr('targetid')).toggleClass("display-inline");

				$('.changelog_small'+$(this).attr('targetid')).toggleClass("display-none");

			});
		});
	</script>
	<script>
		$(function() {
			$('#slides').slidesjs({
				width: 207,
				height: 100,
				navigation: true,
				play: {
					active: false,
					auto: true,
					interval: 3000,
					swap: true,
					pauseOnHover: false,
					restartDelay: 2500
				}
			});
		});
	</script>
	<?php echo template_place_holder('head_end'); ?>
</head>
<body>
<?php echo template_place_holder('body_start'); ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v2.8";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<div class="top-bar">
	<a href="<?= getLink('account/create'); ?>">

		<?php
		$date = config('start_date_countdown');
		$exp_date = strtotime($date);
		$now = time();

		if ($now < $exp_date) {
			?>
			<script>
				// Count down milliseconds = server_end - server_now = client_end - client_now
				var server_end = <?php echo $exp_date; ?> * 1000;
				var server_now = <?php echo time(); ?> * 1000;
				var client_now = new Date().getTime();
				var end = server_end - server_now + client_now; // this is the real end time

				var _second = 1000;
				var _minute = _second * 60;
				var _hour = _minute * 60;
				var _day = _hour *24
				var timer;

				function showRemaining()
				{
					var now = new Date();
					var distance = end - now;
					if (distance < 0 ) {
						clearInterval( timer );
						document.getElementById('countdown').innerHTML = 'EXPIRED!';

						return;
					}
					var days = Math.floor(distance / _day);
					var hours = Math.floor( (distance % _day ) / _hour );
					var minutes = Math.floor( (distance % _hour) / _minute );
					var seconds = Math.floor( (distance % _minute) / _second );

					var countdown = document.getElementById('countdown');
					countdown.innerHTML = '';
					if (days) {
						countdown.innerHTML += ' <span style="color:white;">' + days + '</span> DAYS ';
					}
					countdown.innerHTML += ' <span style="color:white;">' + hours+ '</span> HOURS';
					countdown.innerHTML += ' <span style="color:white;">' + minutes+ '</span> MINUTES';
					countdown.innerHTML += ' <span style="color:white;">' + seconds+ '</span> SECONDS';
				}

				timer = setInterval(showRemaining, 1000);
			</script>
			Arkonia Online 7.4 Will Start In: <span style="color: yellow;" id="countdown">loading...</span>
			<?php
		} else {
			echo 'Arkonia Online 7.4 Will Start In: <span style="color: yellow;">SERVER STARTED!</span>';
		}
		?>
	</a>
</div>
<div class="container_main">
	<div class="container_left">
		<?php
		oldschool_menu(MENU_CATEGORY_MAIN);
		oldschool_menu(MENU_CATEGORY_ACCOUNT);
		oldschool_menu(MENU_CATEGORY_COMMUNITY);
		oldschool_menu(MENU_CATEGORY_LIBRARY);
		oldschool_menu(MENU_CATEGORY_SHOP);
		?>
	</div>
	<div class="container_mid">
		<!-- FACEBOOK -->
		<div class="center_box">
			<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
			<div class="title"><span style="background-image: url(<?= $template_path; ?>/widget_texts/facebook.png);"></span></div>
			<div class="content_bg">
				<div class="content">
					<div class="rise-up-content" style="min-height: 150px;">
						<div class="fb-page" style="padding: 10px 47px;" data-href="https://www.facebook.com/OpenTibiaNews" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/OpenTibiaNews" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/OpenTibiaNews">OpenTibia</a></blockquote></div>
					</div>
				</div>
			</div>
			<div class="border_bottom"></div>
		</div>
		<?= tickers(); ?>
		<!-- MAIN CONTENT -->
		<div class="center_box">
			<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
			<div class="title"><span class="cufon" style="text-transform: uppercase;text-align: center;line-height:
			43px;font-size: 16px;"><?= PAGE; ?></span></div>
			<div class="content_bg">
				<div class="content">
					<div class="rise-up-content" style="min-height: 565px;">
						<?php echo template_place_holder('center_top') . $content; ?>
					</div>
				</div>
			</div>
			<div class="border_bottom"></div>
		</div>
	</div>
	<div class="container_right">
		<a class="download_client" href="<?= getLink('downloads'); ?>"></a>
		<div class="right_box">
			<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
			<div class="title"><img src="<?= $template_path; ?>/images/quick.gif"><span style="background-image: url(<?= $template_path; ?>/widget_texts/quicklogin.png);"></span></div>
			<div class="content">
				<div class="rise-up-content">
					<?php if ($logged === false) { ?>
						<div class="login"></div>
						<form action="<?= getLink('account/manage'); ?>" method="post" style="margin-bottom: 0;">
							<input type="text" name="account_login" value="Account number" class="inputtext" onfocus="this.value=''" onblur="if(this.value==='') { this.value='Account number'};">
							<input type="password" name="password_login" value="Password" class="inputtext" onfocus="this.value=''" onblur="if(this.value==='') { this.value='Password'};">
							<input type="submit" name="Submit" value="" class="loginbtn"> <a class="createbtn" href="<?= getLink('account/create');?>"></a>
							<center style="font-size: 12px;">
								<a href="<?= getLink('account/lost');?>">Lost Account?</a>
							</center>
						</form>
					<?php }else{ ?>
						<div class="acc_menu">
							<center>
								Welcome, <?php echo(USE_ACCOUNT_NAME ? $account_logged->getName() : $account_logged->getId()); ?>
								<a href="<?= getLink('account/manage'); ?>" class="inputbtn">Manage Account</a>
								<a style="color: orange;" href="<?= getLink('account/character/create'); ?>" class="inputbtn">Create Character</a>
								<a href="<?= getLink('account/logout'); ?>" class="inputbtn">Logout</a>

								<?php if ($account_logged->isAdmin()){ ?>
									<font color="red">ADMIN PANEL</font>
									<a href="<?= ADMIN_URL ?>">Admin Page</a>
								<?php } ?>
							</center>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="border_bottom"></div>
		</div>
		<div class="right_box">
			<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
			<div class="title"><img src="<?= $template_path; ?>/images/gallery.gif" alt="Gallery"><span
					style="background-image: url
					(<?= $template_path; ?>/widget_texts/gallery.png);"></span></div>
			<div class="content">
				<div class="rise-up-content">
					<div class="slider">
						<div class="sbox">
							<div id="slides">
								<img src="<?= $template_path; ?>/slides/1.png">
								<img src="<?= $template_path; ?>/slides/1.png">
								<img src="<?= $template_path; ?>/slides/1.png">
								<img src="<?= $template_path; ?>/slides/1.png">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="border_bottom"></div>
		</div>
		<div class="right_box">
			<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
			<div class="title"><img src="<?= $template_path; ?>/images/info.gif"><span style="background-image: url(<?= $template_path; ?>/widget_texts/serverinfo.png);"></span></div>
			<div class="content">
				<div class="rise-up-content">
					<table class="sinfotable" cellspacing="0">
						<?php
							use MyAAC\Plugin\OldWelcomeBox;
							require __DIR__ . '/OldWelcomeBox.php';
							$oldWelcomeBox = new OldWelcomeBox($db);
							$total = $oldWelcomeBox->getTotalCached();
						?>
						<tr>
							<td>
								<b>Status:</b></td><td> <img style="vertical-align:middle;" src="<?= $template_path; ?>/images/<?= ($status['online'] ? 'on' : 'off'); ?>.png" alt="<?= ($status['online'] ? 'Online' : 'Offline'); ?>">
							</td>
						</tr>
						<tr>
							<td>
								<b>Players: </b>
							</td>
							<td>
								<a href="<?= getLink('online'); ?>"><?= $total['online']; ?></a>
							</td>
						</tr>

						<tr><td><b>Accounts: </b></td><td><?= $total['accounts'];?></td></tr>
						<tr><td><b>Characters: </b></td><td><?= $total['players'];?></td></tr>
					</table>
					<center><a href="<?= getLink('serverInfo'); ?>">&raquo; Server information</a></center>
				</div>
			</div>
			<div class="border_bottom"></div>
		</div>
		<div class="right_box">
			<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
			<div class="title"><img src="<?= $template_path; ?>/images/exp.gif"><span style="background-image: url(<?= $template_path; ?>/widget_texts/powergamers.png);"></span></div>
			<div class="content">
				<div class="rise-up-content">
					<ul class="toplvl">
						<?php
						function coloured_value($valuein)
						{
							$value2 = $valuein;
							$value = '';
							while(strlen($value2) > 3)
							{
								$value .= '.'.substr($value2, -3, 3);
								$value2 = substr($value2, 0, strlen($value2)-3);
							}
							@$value = $value2.$value;
							if($valuein > 0)
								return '<b><font color="green">+'.$value.'</font></b>';
							elseif($valuein < 0)
								return '<font color="red">'.$value.'</font>';
							else
								return $value;
						}

						$powergamers = getPowergamers();
						if(count($powergamers) > 0) {
							foreach($powergamers as $player)
							{
								$nam = $player['name'];
								if (strlen($nam) > 15)
								{$nam = substr($nam, 0, 12) . '...';}
								echo '<li style="margin: 6px 0;"><div style="position:relative; left:-48px; top:-48px;"><div style="background-image: url(' . $config['outfit_images_url'] . '?id='.$player['looktype'].'&head='.$player['lookhead'].'&body='.$player['lookbody'].'&legs='.$player['looklegs'].'&feet='.$player['lookfeet'].');width:64px;height:64px;position:absolute;background-repeat:no-repeat;background-position:right bottom;"></div></div>
									<a style="margin-left: 19px;" href="' . getPlayerLink($player['name'], false). '">'
									.$nam. '</a>';

								echo '<span style="float: right;">'.coloured_value($player['experience']-$player['exphist_lastexp']).'</span></li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
			<div class="border_bottom"></div>
		</div>
		<div class="right_box">
			<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
			<div class="title"><img src="<?= $template_path; ?>/images/casts.gif" alt="Casts"><span
					style="background-image:
					url
					(<?= $template_path; ?>/widget_texts/casts.png);"></span></div>
			<div class="content">
				<div class="rise-up-content">
					<ul class="toplvl">
						<?php
						$casters = getCasters();
						if(count($casters) > 0){
							foreach($casters as $player)
							{
								$nam = $player['name'];
								if (strlen($nam) > 15)
								{$nam = substr($nam, 0, 12) . '...';}
								echo '<li style="margin: 6px 0;"><div style="position:relative; left:-48px; top:-48px;"><div style="background-image: url(' . $config['outfit_images_url'] . '?id='.$player['looktype'].'&head='.$player['lookhead'].'&body='.$player['lookbody'].'&legs='.$player['looklegs'].'&feet='.$player['lookfeet'].');width:64px;height:64px;position:absolute;background-repeat:no-repeat;background-position:right bottom;"></div></div>
									<a style="margin-left: 19px;" href="' . getPlayerLink($player['name'], false). '">'
									.$nam. '</a>';

								echo '<span style="float: right;">'.$player['viewers'].'</span></li>';
							}

						}
						else
						{
							echo '<center>No active casts.</center>';
						}
						?>
					</ul>
				</div>
			</div>
			<div class="border_bottom"></div>
		</div>
	</div>
	<div class="footer_cnt">
		<center>
			<?php if($config['template_allow_change'])
			echo '<span style="color: white">Template:</span><br/>' . template_form() . '</br></br>';
			?>
			<?php echo template_footer(); ?><br/>
			Copyright &copy; <?php echo date('Y', time()); ?> <strong>Arkonia.eu</strong>. All rights reserved.<br><a target="_blank" href="https://otland.net/members/hemrenus321.88336/" style="color: #3d4654;font-size: 11px;">by Hemrenus321</a>
		</center>
	</div>
</div>
<?php echo template_place_holder('body_end'); ?>
</body>
</html>
<?php

function getPowergamers() {
	if (!fieldExist('exphist_lastexp', 'players')) {
		return [];
	}

	$cache = Cache::getInstance();
	if ($cache->enabled()) {
		$tmp = '';
		if ($cache->fetch('powergamers', $tmp)) {
			return unserialize($tmp);
		}
	}

	global $db, $config;

	$deleted = 'deleted';
	if($db->hasColumn('players', 'deletion'))
		$deleted = 'deletion';

	$results = [];
	$query = $db->query('SELECT * FROM players WHERE players.id NOT IN (' . implode(', ', $config['highscores_ids_hidden']) . ') AND players.' . $deleted . ' = 0 AND players.group_id < '.$config['highscores_groups_hidden'].' ORDER BY  experience - exphist_lastexp DESC LIMIT 5;');
	if ($query->rowCount() > 0) {
		$results = $query->fetchAll(\PDO::FETCH_ASSOC);
	}

	if ($cache->enabled()) {
		$cache->set('powergamers', serialize($results), 180); // update every 3 minutes
	}

	return $results;
}

function getCasters() {
	if (!fieldExist('broadcasting', 'players') || !fieldExist('viewers', 'players')) {
		return [];
	}

	$cache = Cache::getInstance();
	if ($cache->enabled()) {
		$tmp = '';
		if ($cache->fetch('casters', $tmp)) {
			return unserialize($tmp);
		}
	}

	global $db, $config;

	$deleted = 'deleted';
	if($db->hasColumn('players', 'deletion'))
		$deleted = 'deletion';

	$results = [];
	$query = $db->query('SELECT * FROM players WHERE players.id NOT IN (' . implode(', ', $config['highscores_ids_hidden']) . ') AND players.' . $deleted . ' = 0 AND players.group_id < '.$config['highscores_groups_hidden'].' AND broadcasting = 1 ORDER BY  viewers DESC LIMIT 5;');
	if ($query->rowCount() > 0) {
		$results = $query->fetchAll(\PDO::FETCH_ASSOC);
	}

	if ($cache->enabled()) {
		$cache->set('casters', serialize($results), 180); // update every 3 minutes
	}

	return $results;
}

function oldschool_menu($category) {
	global $menus, $template_path;

	if(!isset($menus[$category]) || ($category == MENU_CATEGORY_SHOP && !config('gifts_system'))) { // ignore shop system if disabled
		return;
	}
	$configMenuCategories = config('menu_categories');
	?>
	<div class="left_box">
		<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
		<div class="title"><img src="<?= $template_path; ?>/images/<?= $configMenuCategories[$category]['image'];
			?>.gif" alt="News"><span style="background-image: url(<?= $template_path; ?>/widget_texts/<?= $configMenuCategories[$category]['image']; ?>.png);"></span></div>
		<div class="content">
			<div class="rise-up-content">
				<ul>
					<?php
					foreach($menus[$category] as $link) {
						echo '<li><a href="' . $link['link_full'] . '" ' .
							($link['blank']
								? '
			target="_blank"' :
								'') . (strlen($link['color']) == 0 ? '' : 'style="color: #' . $link['color']) . ';">' .
							$link['name'] . '</a></li>';
					}
					?>
				</ul>
			</div>
		</div>
		<div class="border_bottom"></div>
	</div>
	<?php
}
