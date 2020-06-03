<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo template_place_holder('head_start'); ?>
	<link rel="stylesheet" href="<?PHP echo $template_path; ?>/default.css" type="text/css" />
	<link rel="stylesheet" href="<?PHP echo $template_path; ?>/basic.css" type="text/css" />
	<link rel="shortcut icon" href="<?php echo $template_path; ?>/images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="<?php echo $template_path; ?>/images/favicon.ico" type="image/x-icon" />
	<?php echo template_place_holder('head_end'); ?>
</head>
<body>
<?php echo template_place_holder('body_start'); ?>
<div id="page">
	<div id="logo-art">
		<div id="logo-box">
			<!--<div id="logo"><img src="<?php echo $template_path; ?>/images/logo.png" width="439" height="137" /></div>-->
		</div>
		<div id="cnt-box">
			<div id="cnt-container">
				<div id="cnt-left">
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
						<?php if($config['template_allow_change']): ?>
							<div id="menu-top">Change template</div>
							<div id="menu-cnt">
									<ul>
										<li><center><?php echo template_form(); ?>
										</center></li>
									</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div id="cnt-right">
				<!-- TOP INFO -->
					<div id="content-cnt" style="margin-bottom: 8px;">
						<div id="content-bg">
						<div id="content-top">
							<div id="content-bot" style="font-size: 10px;">
							<style type="text/css">font#offline { font-size: 26px; } font#online { font-size: 26px; color: #008000; }</style>
									<table style="text-align: center;" width="100%">
										<tbody><tr>

											<td style="font-size: 15px;">
												<div style="font-size: 15px;">
																										  <?php
			if($status['online'])
				echo '<b><div id="players" style="display: inline;">' . $status['players'] . '/' . $status['playersMax'] . '</div> players online.</b>';
			else
				echo '<font color="red"><b>Server<br/>OFFLINE</b></font>';
			?></div>
						<?php echo template_place_holder('center_top'); ?>
											</td>
										</tr>
									</tbody></table>
							</div>
						</div>
						</div>
					</div>
				<div id="cnt-right">
					<div id="content-cnt">
						<div id="content-bg">
							<div id="content-top">
								<div id="content-bot">
								<?php echo $content; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div id="cnt-box2">
				<div id="cnt-container">
					<!-- <div id="cnt-left">
						<center><p style="color: #FFF;">Designed by Vean.</p></center>
					</div>
					<div id="cnt-right"> -->
					<center>
							<p style="color: #FFF; font-size: 11px;">
								<?php echo template_footer(); ?>
							</p>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template_place_holder('body_end'); ?>
</body>
</html>
