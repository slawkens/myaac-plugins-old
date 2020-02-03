<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<!DOCTYPE HTML>
<html>
<head>
	<?php echo template_place_holder('head_start'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/css/default.css" />
	<!-- modernizr enables HTML5 elements and feature detects -->
	<script type="text/javascript" src="<?php echo $template_path; ?>/js/modernizr-1.5.min.js"></script>
	<?php echo template_place_holder('head_end'); ?>
</head>

<body>
	<?php echo template_place_holder('body_start'); ?>
	<div id="main">
	<header>
	  <div id="logo">
		<div id="logo_text">
		<h1><a href="<?php echo getLink('news'); ?>">My<span class="logo_colour">AAC</span></a></h1>
		<h2>The best AAC and CMS ever made!</h2>
		</div>
	</div>
	<nav>
		<div id="menu_container">
		  <ul class="sf-menu" id="nav">
			<?php
				$menu_table_exist = tableExist(TABLE_PREFIX . 'menu');
				if($menu_table_exist) {
					require_once($template_path . '/menu_dynamic.php');
				}
				else {
					require_once($template_path . '/menu.php');
				}
			?>
		  </ul>
		</div>
	</nav>
	</header>
	<div id="site_content">
		<div id="sidebar_container">
			<?php
			if($logged) {
				include($template_path . '/widgets/loggedin.php');
			} else {
				include($template_path . '/widgets/login.php');
			}
			if($logged && admin()) {
				include($template_path . '/widgets/admin.php');
			}
			
			foreach(glob( $template_path . '/widgets/*.php') as $file) {
				$filename = pathinfo($file, PATHINFO_FILENAME);
				if($filename != "login" && $filename != "loggedin" && $filename != "admin") {
					include($file);
				}
			}
			?>
		</div>
		<div class="content">
			<?php echo template_place_holder('center_top') . $content; ?>
		</div>
	</div>
	<div id="scroll">
		<a title="Scroll to the top" class="top" href="#"><img src="images/top.png" alt="top" /></a>
	</div>
	<footer>
		<p><?php echo template_footer(); ?><br/><a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>
	</footer>
	</div>
	<!-- javascript at the bottom for fast page loading -->
	<script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
	<script type="text/javascript" src="js/jquery.sooperfish.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
	 	$('ul.sf-menu').sooperfish();
		$('.top').click(function() {$('html, body').animate({scrollTop:0}, 'fast'); return false;});
	});
	</script>
	<?php echo template_place_holder('body_end'); ?>
</body>
</html>