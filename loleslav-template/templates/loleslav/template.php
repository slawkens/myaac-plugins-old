<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!-- Powered by UNNAMED Acc. Maker &copy;2009 - 2010 by Gesior. -->
<!-- Rewrote and rebuild for Altara.pl purposes (c)2009 - 2010. -->
<!-- Designed by DeGhost -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo template_place_holder('head_start'); ?>
	<link rel="shortcut icon" href="<?PHP echo $template_path; ?>/images/others/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?PHP echo $template_path; ?>/images/others/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?PHP echo $template_path; ?>/default.css" media="screen"/>
	<!--link rel="stylesheet" type="text/css" href="<?PHP echo $template_path; ?>/basic.css" media="screen"/-->
	<title><?PHP echo $title; ?></title>
	<?PHP echo $layout_header; ?>
	<style type="text/css">
		@import "layout.css";
	</style>
	<?php echo template_place_holder('head_end'); ?>
</head>
<body class="home">
	<?php echo template_place_holder('body_start'); ?>
<div id="bg1">
	<div id="bg2">
		<div id="header" class="container">
			<div id="logo">
			</div>
			<div id="topmenu">
			</div>
		</div>
	</div>
	<?php
		$menu_table_exist = tableExist(TABLE_PREFIX . 'menu');
		if($menu_table_exist) {
			require_once($template_path . '/menu/top_dynamic.php');
		}
		else {
			require_once($template_path . '/menu/top.php');
		}
	?>
	<div id="bar">
		<div class="container">
			<div id="login">
				<?php
					if ($logged) {
						echo'<form method="post" action="' . getLink('account/logout') . '">
						<fieldset><p>Hello.&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . getLink('account/manage') . '">Account Management</a>&nbsp;</p>
						<input value="Logout" class="input-submit" type="submit" />
						</fieldset>
						</form>';
					}else{
						echo'<form method="post" action="' . getLink('account/manage') . '">
							<fieldset> <span class="input-text"> <input name="account_login" value="" placeholder="Account" type="text" /> </span><span class="input-text"> <input name="password_login" value="" placeholder="Password" type="password" /> </span> <input value="Login" class="input-submit" type="submit" />
							<p><a href="' . getLink('account/lost') . '">Lost Account?</a>&nbsp;</p>
							</fieldset>
						</form>';
					}
				?>
			</div>
			<div id="search">
				<form method="post" action="<?php echo getLink('characters'); ?>">
					<fieldset> <span class="input-text"> <input name="name" placeholder="Player name" type="text" /> </span><input value="Search" class="input-submit" type="submit" /></fieldset>
				</form>
			</div>
		</div>
	</div>
<div id="bg3">
<div id="bg4">
<div id="page" class="container">
<div id="content">
	<div id="sidebar2">
		<?php
			if (PAGE == "news" && $twig->getLoader()->exists('description.html.twig')) {
				echo '<div id="box2" class="box-style3">
					' . $twig->render('description.html.twig') . '
				</div>';
			}
		?>
		<div id="box3" class="box-style3">
		<h2 class="title"><?php echo $title; ?></h2>
			<div class="main_content">
				<?php echo tickers() . template_place_holder('center_top') . $content; ?>
			</div>
		</div>
	</div>

	<div id="sidebar3">
		<div id="box4" class="box-style4">
			<h2 class="title"><center>Status</center></h2>
			<div class="entry">
				<ul class="list1">
				</ul>
				<center>
				<?php
		if($status['online']){
		echo 'Players On-Line:<br>
		<a href="' . getLink('online') . '" title="Players Online"><b>'.$status['players'] . '/' . $status['playersMax'].'</b></a>
		<br>Uptime:<br>
		<b>'.$status['uptimeReadable'].'</b><br>';
		}else{
		echo '<font color="red">Server is Offline</font>';
		}
		?>
				</center>
			</div>
		</div>

		<div id="box5" class="box-style4">
			<div class="entry">
				<h2 class="title"><center>Best players</center></h2>
					<center>
		<?php
						foreach(getTopPlayers(5) as $player)
						{
						 echo '<li class="bg6"><a href="' . getPlayerLink($player['name'], false) . '"  class="link2">' . $player['name'] . '</a><br>';
						 echo '<em class="style2">Level: <b>' . $player['level'] . '</b></em></li>';
						}
		?>
					</center>
			</div>
		</div>
        <?php
        if($config['template_allow_change']):
        ?>
        <div id="box6" class="box-style2">
            <h2 class="title" style="text-align: center">Template</h2>
            <div style="text-align: center;">
			<?= template_form() ?>
            </div>
        </div>
        <?php
        endif;
        ?>
	</div>
</div>

<div id="sidebar">
	<?php
		if($menu_table_exist) {
			require_once($template_path . '/menu/main_dynamic.php');
		}
		else {
			require_once($template_path . '/menu/main.php');
		}
	?>
</div>
<div style="clear: both;">&nbsp;</div>
</div>
</div>
</div>

<div id="footer">
	<p class="container"><?php echo template_footer(); ?><br/>Designed by <a href="http://cerberia.com">DeGhost</a> and <a href="http://blog.loleslav.pl/">Loleslav</a>.</p>
</div>
</div>
</div>
	<?php echo template_place_holder('body_end'); ?>
</body>
</html>
