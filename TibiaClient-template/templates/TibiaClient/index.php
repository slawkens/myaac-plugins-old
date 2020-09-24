<?php defined('MYAAC') or die('Direct access not allowed!'); ?>
<!--
	Author: Blackwolf (Snavy on otland)
	Modified for MyAAC by slawkens
	Otland: https://otland.net/members/snavy.155163/
	Facebook: http://www.facebook.com/idont.reallywolf.1
	Twitter: @idontreallywolf
-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<?php echo template_place_holder('head_start'); ?>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?=$template_path?>/css/style.css">
	<?php echo template_place_holder('head_end'); ?>
</head>
<body>
	<?php echo template_place_holder('body_start'); ?>
	<div class="container">
		<div class="header"></div>
		<div class="outerBox main preventCollapse">
			<div class="leftPane pull-left">
				<?php require __DIR__ . '/menus.php'; ?>
			</div>
			<div class="rightPane pull-right">
				<?php require __DIR__ . '/top_guilds.php'; ?>
				<div class="window outerBox">
					<div class="windowHeader">
						<a href="<?php echo getLink('news'); ?>"><?php echo $config['lua']['serverName']; ?></a> &raquo; <?php echo $title; ?>
					</div>
					<?php echo tickers() . template_place_holder('center_top') . $content; ?>
				</div>
				<div id="footer" class="window outerBox">
				<p><?php echo template_footer(); ?></p>
				<?php
				if($config['template_allow_change'])
					echo '<span style="color: white">Template:</span><br/>' . template_form();
				?>
				</div>
			</div>
		</div>
	</div>
	<?php echo template_place_holder('body_end'); ?>
</body>
</html>
<!--
	Author: Blackwolf (Snavy on otland)
	Modified for MyAAC by slawkens
	Otland: https://otland.net/members/snavy.155163/
	Facebook: http://www.facebook.com/idont.reallywolf.1
	Twitter: @idontreallywolf
-->
