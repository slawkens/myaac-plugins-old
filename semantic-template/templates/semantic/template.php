<?php
defined('MYAAC') or die('Direct access not allowed!');

if(!version_compare(MYAAC_VERSION, '0.7', '>=')) {
	echo 'MyAAC 0.7.0 is required.';
	exit;
}

$menus = get_template_menus();
foreach($menus as $cat => &$_menus) {
	foreach($_menus as &$menu) {
		$link_full = strpos(trim($menu['link']), 'http') === 0 ? $menu['link'] : getLink($menu['link']);
		$menu['link_full'] = $link_full;
	}
}

if(count($menus) === 0) {
	$text = "Please install the $template_name template in Admin Panel, so the menus will be imported too.";
	if(version_compare(MYAAC_VERSION, '0.8.0', '>=')) {
		throw new RuntimeException($text);
	}
	else {
		echo $text;
		exit;
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<?= template_place_holder('head_start') ?>
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no"
	/>
	<link rel="stylesheet" href="<?= $template_path; ?>/css/semantic.min.css" type="text/css"/>
	<link rel="stylesheet" href="<?= $template_path; ?>/css/main.css" type="text/css"/>
	<script src="<?= $template_path; ?>/js/semantic.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".ui.dropdown").dropdown();
		});
	</script>
	<style>
		body {
			background-image: url(<?= $template_path; ?>/images/background.png) !important;
		}
	</style>
	<?= template_place_holder('head_end') ?>
</head>

<body id="root">
<?= template_place_holder('body_start') ?>
<div class="ui stackable container">
	<h1 class="ui header" style="margin-top: 15px">
		<a href="<?= getLink('') ?>"><?= $config['lua']['serverName'] ?></a>
	</h1>
	<div class="row">
		<div class="ui stackable container huge menu">
			<?php semantic_menus(MENU_CATEGORY_MAIN); ?>
			<div class="right menu">
				<div class="ui dropdown item">
					Community <i class="dropdown icon"></i>
					<div class="menu">
						<?php semantic_menus(MENU_CATEGORY_COMMUNITY, true); ?>
					</div>
				</div>
				<div class="ui dropdown item">
					Library <i class="dropdown icon"></i>
					<div class="ui menu">
						<?php semantic_menus(MENU_CATEGORY_LIBRARY, true); ?>
					</div>
				</div>
				<?php if($config['gifts_system']) { ?>
				<div class="ui dropdown item">
					Shop <i class="dropdown icon"></i>
					<div class="menu">
						<?php semantic_menus(MENU_CATEGORY_SHOP, true); ?>
					</div>
				</div>
				<?php } ?>
				<div class="item">
				<?php
				if($logged) { ?>
					<a class="ui primary button" href="<?= getLink('account/manage') ?>">My Account</a>&nbsp;
					<a class="ui button" href="<?= getLink('account/logout') ?>">
						<i class="sign-out icon"></i>Logout
					</a>
				<?php } else { ?>
					<a class="ui primary button" href="<?= getLink('account/create') ?>">Create Account</a>&nbsp;
					<a class="ui button" href="<?= getLink('account/manage') ?>">
						<i class="sign-in icon"></i>Login
					</a>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--div class="ui hidden section divider"></div-->
<div class="ui container">
	<div class="ui padded stackable grid">
		<div class="twelve wide column">

			<?php
			if(PAGE === 'news') {
				$twig->display('info-box.html.twig');
			}

			echo tickers() . template_place_holder('center_top'); ?>
			<div class="ui card" style="width: 100%">
				<div class="ui top attached message">
					<h4 class="ui header"><?= $title; ?></h4>
				</div>
				<div class="ui bottom attached segment"><?= $content; ?></div>
			</div>
		</div>
		<div class="four wide right floated column">
			<?php
				require __DIR__ . '/boxes/search.php';
				require __DIR__ . '/boxes/status.php';
				require __DIR__ . '/boxes/highscores.php';
			?>
		</div>
	</div>
</div>
<footer>
	<div class="ui center aligned container">
		<?php echo template_footer();
		if($config['template_allow_change'])
			echo template_form();
		?>
	</div>
</footer>
<?= template_place_holder('body_end') ?>
</body>
</html>

<?php

function semantic_menus($category, $submenu = false)
{
	global $menus;

	if (!isset($menus[$category])) {
		return;
	}

	$i = 0;
	foreach ($menus[$category] as $menu) {
		echo '<a class="' . ($i++ === 0 && !$submenu ? 'active ' : '') . 'item" href="' . $menu['link_full'] . '" ' .
			($menu['blank']
				? '
				target="_blank"' :
				'') . (strlen($menu['color']) == 0 ? '' : 'style="color: #' . $menu['color']) . ';">' .
			$menu['name'] . '</a>';
	}
}
