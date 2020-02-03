<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo template_place_holder('head_start'); ?>
		<link rel="stylesheet" href="<?php echo $template_path; ?>/style.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $template_path; ?>/default.css" type="text/css" />
	 <script type="text/javascript">
			var date = new Date();
			date.setTime(date.getTime() + 1000*60*60*24*30);

				function readCookie( cookie_name )
				{
					var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

					if ( results )
					{
						return ( unescape ( results[2] ) );
					}
					else
					{
						return null;
					}
				}
		</script>
		<script type="text/javascript" src="<?php echo $template_path; ?>/menu.js"></script>
		<script type="text/javascript" src="tools/basic.js"></script>
		<?php echo template_place_holder('head_end'); ?>
	</head>
	<body onload="menuInit(); makeItemActive('<?php echo PAGE; ?>');">
		<?php echo template_place_holder('body_start'); ?>
		<div id="page">
			<div id="header">
				<div class="lampa-left"></div>
				<div class="lampa-right"></div>
			</div>
			<div id="panel">
				<div id="panel-padding-left">
					<div class="search_character"></div>
					<form action="<?php echo $template['link_characters']; ?>" method="post">
						<input type="text" name="name" class="search_char_input" maxlength="29" />
						<input type="submit" class="search_char_button" value="" />
					</form>
				</div>
				<div id="panel-padding-right">
					<?php if($status['online'])
					{
						echo '
						<div class="uptime">'.$status['uptimeReadable'].'</div>
						<div class="status-online"></div>
						<div class="server_status"></div>';
					} else {
						echo '
						<div class="uptime">00h 00m</div>
						<div class="status-offline"></div>
						<div class="server_status"></div>';
					}
					?>
				</div>
			</div>
			<div id="container-main">
				<div id="menu">
					<?php
					$menu_table_exist = tableExist(TABLE_PREFIX . 'menu');
					if($menu_table_exist) {
						require_once($template_path . '/menu_dynamic.php');
					}
					else {
						require_once($template_path . '/menu.php');
					}
					?>
				</div>
				<div id="content">
					<div class="content-box-top">
<?php
	$title_imgos = $template_path . '/images/subtopics/' . PAGE . '.png';
	if(file_exists($title_imgos))
		echo '<img src="' . $template_path . '/images/subtopics/' . PAGE . '.png" alt="Subtopic" />';
	else
		echo $title;
?>
					</div>

					<div class="content-box-mid">
						<div class="padding">
							<?php echo template_place_holder('center_top') . $content; ?>
						</div>
					</div>
					<div class="content-box-bot"></div>
					<div class="content-box-footer">
						<?php echo template_footer(); ?>
						<br/>Layout by Sprite.
					</div>
				</div>
				<div id="panels">
					<div class="newcomer">
						<div style="padding-top: 112px;">
							<form action="<?php echo $template['link_account_create']; ?>" method="post">
							<center><div class="BigButton" style="background-image:url(<?php echo $template_path; ?>/images/buttons/sbutton.gif)">
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);">
									<div class="BigButtonOver" style="background-image:url(<?php echo $template_path; ?>/images/buttons/sbutton_over.gif);"></div>
									<input class="ButtonText" type="image" name="Submit" alt="Submit" src="<?php echo $template_path; ?>/images/buttons/_sbutton_jointibia.gif" />
								</div>
							</div></center>
							</form>
						</div>
					</div>
<?php
if($config['gifts_system'])
{
?>
					<div class="premium">
						<div style="padding-top: 112px;">
							<form action="<?php echo $template['link_gifts']; ?>" method="post">
							<center><div class="BigButton" style="background-image:url(<?php echo $template_path; ?>/images/buttons/sbutton.gif)">
								<div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);">
									<div class="BigButtonOver" style="background-image:url(<?php echo $template_path; ?>/images/buttons/sbutton_over.gif);"></div>
									<input class="ButtonText" type="image" name="Submit" alt="Submit" src="<?php echo $template_path; ?>/images/buttons/_sbutton_getpremium.gif" />
								</div>
							</div></center>
							</form>
						</div>
					</div>
<?php
}
	if($config['template_allow_change'])
		 echo '<div style="text-align: center;"><font color="white">Template:</font><br/>' . template_form() . '</div>';
?>


				</div>
			</div>
		</div>
		<?php echo template_place_holder('body_end'); ?>
	</body>
</html>
