<?php
defined('MYAAC') or die('Direct access not allowed!');

$menus = get_template_menus();
foreach($menus as $cat => &$_menus) {
	foreach($_menus as &$menu) {
		$link_full = strpos(trim($menu['link']), 'http') === 0 ? $menu['link'] : getLink($menu['link']);
		$menu['link_full'] = $link_full;
	}
}
?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<?php echo template_place_holder('head_start'); ?>
		<link rel="shortcut icon" href="<?php echo $template_path; ?>/images/fav.ico">

		<!-- Responsive meta tag -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- Load styles -->
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/default.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/cms.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/custom.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/default.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/icheck.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/loginbox.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/main.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/news.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/shadowbox.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/theme.css">

		<!-- Load scripts -->
		<script type="text/javascript">
			var isIE = false;
		</script>
		<!--[if IE]><script type="text/javascript">isIE = true;</script><![endif]-->
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/ajax.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/flux.min.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/fusioneditor.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/html5shiv.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/jquery.placeholder.min.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/jquery.sort.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/jquery.transit.min.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/json2.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/ui.js"></script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/js/bootstrap.min.js"></script>

		<script type="text/javascript">

		if(!window.console) {
			var console = {
				log: function () {
				}
			};
		}

			var Config = {
				URL: "<?= BASE_URL ?>",
				image_path: "<?= $template_path ?>/images/",

				UseFusionTooltip: 1,

				Slider: {
					interval: 5000,
					effect: "",
					id: "slider_container"
				},

				voteReminder: 0,

				Theme: {
					next: "",
					previous: ""
				}
			};

			var scripts = [
				"<?= $template_path ?>/js/slide.js"
			];

		$(document).ready(function() {
			UI.initialize();
		});
		</script>

		<script>
				$(document).ready(function(){
					$(".dropdown-toggle").dropdown();
				});
			</script>

		<?php echo template_place_holder('head_end'); ?>
	</head>

	<body cz-shortcut-listen="true">
		<?php echo template_place_holder('body_start'); ?>
		<div id="tooltip"></div>
		<div id="popup_bg"></div>

		<!-- confirm box -->
		<div id="confirm" class="popup vertical_center">
			<h1 id="confirm_question" class="popup_question"></h1>

			<div class="popup_links self_clear">
				<a href="javascript:void(0)" id="confirm_button" class="nice_button green_btn"></a>
				<a href="javascript:void(0)" id="confirm_hide" class="nice_button" onclick="UI.hidePopup()">Cancel</a>
			</div>
		</div>

		<!-- alert box -->
		<div id="alert" class="popup vertical_center">
			<h1 id="alert_message" class="popup_message"></h1>

			<div class="popup_links self_clear">
				<a href="javascript:void(0)" id="alert_button" class="nice_button">Okay</a>
			</div>
		</div>

		<!-- Header -->
		<header id="header" class="header self_clear">
			<div class="holder">
				<!-- Navigation -->
				<ul class="navigation border_box">
					<li id="w-home">
						<a href="<?= getLink('news') ?>"></a>
					</li>
					<li id="w-guide">
						<div class="dropdown-holder" style="left: -62.5px;">
							<ul class="navi-dropdown">
								<?= aldora_get_links(MENU_CATEGORY_ACCOUNTS) ?>
							</ul>
						</div>
					</li>
					<li id="w-server">
						<a href="<?= getLink('highscores') ?>"></a>
					</li>
					<li id="w-features">
						<div class="dropdown-holder" style="left: -56.5px;">
							<ul class="navi-dropdown">
								<?= aldora_get_links(MENU_CATEGORY_COMMUNITY) ?>
							</ul>
						</div>
					</li>
					<li id="w-forums">
							 <div class="dropdown-holder" style="left: -56.5px;">
							<ul class="navi-dropdown">
								<?= aldora_get_links(MENU_CATEGORY_LIBRARY) ?>
							</ul>
						</div>
					</li>

					<li id="w-armory">
						<a href="<?= getLink('forum') ?>"></a>
					</li>

				</ul>
				<!-- Navigation.End -->

				<!-- Membership bar -->

				 <?php
				 /**
				  * @var boolean $logged
				  */
					if($logged) {
				?>


				<div class="membership-bar anti_blur">
					<div class="membership-holder logged_in border_box">
						<?php
						/**
						 * @var OTS_Account $account_logged
						 */
						?>
						<span>Welcome back,
							<i>
								<?php
								if (USE_ACCOUNT_NAME) {
									echo $account_logged->getName();
								} else {
									echo $account_logged->getId();
								}
								?>
							</i>!
						</span>
						<ul>
							<?= aldora_get_links(MENU_CATEGORY_ACCOUNT_LOGGED) ?>
						</ul>
					</div>
				</div>

				<?php
					}
					else
					{
				?>
						<div class="membership-bar anti_blur">
							<div class="membership-holder not_logged border_box">
									<a href="<?= getLink('account/manage') ?>" id="home_login">Sign in</a>
									<a href="<?= getLink('account/create') ?>" id="home_register">Register</a>
							</div>
						</div>

				<?php
	}
?>

				<!-- Membership bar.End -->
<script type="text/javascript">
	if(typeof Shadowbox !== 'undefined') {
		Shadowbox.init();
	}
</script>

				<!-- Logo -->
				<h1 class="logo_holder"><a href="<?= getLink('') ?>" class="logo" title="Welcome to <?= $config['lua']['serverName']?>"><img src="<?php echo $template_path; ?>/images/logo.png" width="667" height="183" alt="Aldora Logo"><span>Welcome to Aldora</span></a></h1>
				<!-- Logo.End -->
			</div>
		</header>
		<!-- Header.End -->

		<!-- Body -->
		<div class="main_b_holder">
			<div class="sec_b_holder">
				<div class="body_content self_clear">
					<!-- Body Content start here -->

					<!-- Main side -->
					<aside id="right">
						<?php if(PAGE === 'news') {?>
						<div id="slider_container" class="slider_container anti_blur" >
							<div id="slider">
								<a href="#"><img src="<?= $template_path ?>/images/1.jpg" width="718" height="255"
												 alt="" title="" /></a>
								<a href="#"><img src="<?= $template_path ?>/images/2.jpg" width="718" height="255" alt="" /></a>
								<a href="#"><img src="<?= $template_path ?>/images/3.jpg" width="718" height="255" alt="" /></a>
								<a href="#"><img src="<?= $template_path ?>/images/4.jpg" width="718" height="255" alt="" title="" /></a>
								<a href="#"><img src="<?= $template_path ?>/images/5.jpg" width="718" height="255" alt="" title="" /></a>
							</div>
						</div>
						<div id="content_ajax">
							<?= tickers() . template_place_holder('center_top') ?>
						</div>
							<?= $content ?>
						<?php
						} else { ?>
						<div id="content_ajax">
							<?= template_place_holder('center_top') . $content ?>
						</div>
						<?php } ?>

					</aside>
					<!-- Main side.End -->

					<!-- Sidebar -->
					<aside id="left">
						<!-- Banner -->
						<div class="sidebar_banner seperator">
							<a href="<?= getLink('downloads') ?>" class="banner"><span class="text">Download</span></a>
						</div>
						<!-- Banner.End -->

						<!-- Discord -->
						<div class="sidebar_banner seperator">
							<a href="<?= $config['discord_link'] ?>" id="discord_banner"></a>
						</div>
						<!-- Discord.End -->

						<!-- Social media -->
						<div class="sidebar_banner seperator">
							<a href="<?= getLink('points') ?>" class="banner"><span class="text">Donate</span></a>
						</div>
						<!-- Social media.End -->

						<section id="sidebox_status" class="sidebox  seperator">
								<h4 class="sidebox_title">Server status</h4>
								<div class="sidebox_body">

								<table class="nice_table">
							<tbody>
								<tr>
									<td>Status:</td><td colspan=1>
										<?php
										if($status['online'])
											echo '<span class="label label-success pull-right label-sm">Online</span>';
										else
											echo '<span class="label label-danger pull-right label-sm">Offline</span>';
										?>
									</td>
								</tr>
								<tr>
									<td>Server Save:</td>
									<td>06:00</td>
								</tr>
								<tr>
									<?php if($status['online']) : ?>
									<td><a href="<?= getLink('online') ?>"><?= $status['online']; ?> player<?= ($status['online'] > 1 ? 's' : ''); ?> online</a></td><td></td>
									<?php endif; ?>
								</tr>
							</tbody>
						</table>

							</div>
							</section>

			<section id="sidebox_visitors" class="sidebox  seperator">
								<h4 class="sidebox_title">Top 5 Level</h4>
								<div class="sidebox_body">

						<table class="nice_table">
							<tbody>
								<?php
								$i = 0;
								$topData = '';
								foreach(getTopPlayers(5) as $player) {
									$i++;
									$topData .= '<tr><td style="width: 80%"><strong>'.$i.'.</strong> ' . getPlayerLink($player['name']) . '</td><td><span 
	class="label label-primary">Lvl. '.$player['level'].'</span></td></tr>';
								}

								echo $topData; ?>
							</tbody>
						</table>

							</div>
							</section>
						<?php
						if($config['template_allow_change']) {?>
							<section id="sidebox_status" class="sidebox  seperator">
								<h4 class="sidebox_title">Change template</h4>
								<div class="sidebox_body">
									<?= template_form() ?>
								</div>
							</section>
						<?php } ?>
					</aside>
					<!-- Sidebar.End -->

					<!-- Body Content ends here -->
				</div>
			</div>
		</div>
		<!-- Body.End -->

		<!-- Footer -->
		<footer id="footer" class="footer self_clear">
			<div class="holder border_box">
				<div class="left_side">
					<p><?php echo template_footer(); ?></p>
				</div>

				<div class="right_side">
					<?php
					$i = 0;
					foreach($menus[MENU_CATEGORY_FOOTER] as $menu) {
						if($i++ % 4 == 0) {
							echo '<ul>';
						}
						echo '<li><a href="' . $menu['link_full'] . '" ' . ($menu['blank'] ? ' target="_blank"' :
								'') . (strlen($menu['color']) == 0 ? '' : 'style="color: #' . $menu['color']) . ';">' .
							$menu['name'] . '</a></li>';
						if($i % 4 == 0) {
							echo '</ul>';
						}
					}
					?>
				</div>
			</div>
		</footer>
		<!-- Footer.End -->
		<a href="#header" class="back-to-top border_box anti_blur"></a>
		<?php echo template_place_holder('body_end'); ?>
	</body>
</html>
<?php

function aldora_get_links($category)
{
	global $menus;

	$ret = '';
	foreach ($menus[$category] as $menu) {
		$ret .= '<li><a href="' . $menu['link_full'] . '" ' . ($menu['blank'] ? ' target="_blank"' :
				'') . (strlen($menu['color']) == 0 ? '' : 'style="color: #' . $menu['color']) . ';">' .
			$menu['name'] . '</a></li>';
	}

	return $ret;
}
