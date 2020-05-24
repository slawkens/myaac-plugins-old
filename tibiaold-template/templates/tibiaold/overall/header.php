<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo template_place_holder('head_start'); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="<?php echo $template_path; ?>/images/favicon.png">

    <link href="<?php echo $template_path; ?>/css/app.css" rel="stylesheet" media="all">
    <link href="<?php echo $template_path; ?>/css/trumbowyg.min.css" rel="stylesheet" media="all">

    <?php echo template_place_holder('head_end'); ?>
</head>
	<body>
		<?php echo template_place_holder('body_start'); ?>
		<section id="pandaac">
			<header id="header">
				<a href="<?php getLink('news'); ?>"><img src="<?php echo $template_path; ?>/images/header-left.png" alt="Tibia"></a>
			</header>

			<aside id="topbar">
				<?php
					$menu_table_exist = tableExist(TABLE_PREFIX . 'menu');
					if($menu_table_exist) {
						require_once($template_path . '/menu_top_dynamic.php');
					}
					else {
						require_once($template_path . '/menu_top.php');
					}
				?>
			</aside>

			<div id="content-container">
				<aside id="sidebar">
					<section id="sidebar-links">
						<div class="line"></div>
						<div class="line wide"></div>

						<?php
							if($menu_table_exist) {
								require_once($template_path . '/menu_left_dynamic.php');
							}
							else {
								require_once($template_path . '/menu_left.php');
							}
						if ($logged) { ?>
							<div class="line wide"></div>
							<?php echo $twig->render('widgets/loggedin.html.twig');
							if (admin()) include $template_path . '/widgets/Wadmin.php';
						}
						?>
						<div class="line wide"></div>
						<div class="line"></div>
					</section>

					<section id="sidebar-misc">
						<?php include TEMPLATES . 'tibiaold/widgets/serverinfo.php'; ?>
					</section>
				</aside>

				<div id="main-container">
					<main id="main">
						<div id="content">