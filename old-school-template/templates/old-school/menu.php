<?php
defined('MYAAC') or die('Direct access not allowed!');

foreach($menus as $category => $menu) {
	if(!isset($menus[$category]) || ($category == MENU_CATEGORY_SHOP && !config('gifts_system'))) { // ignore shop system if disabled
		continue;
	}
?>
	<div class="left_box">
		<div class="corner_lt"></div><div class="corner_rt"></div><div class="corner_lb"></div><div class="corner_rb"></div>
		<div class="title"><img src="<?= $template_path; ?>/images/<?= $config['menu_categories'][$category]['image'];
		?>.gif" alt="News"><span style="background-image: url(<?= $template_path; ?>/widget_texts/<?= $config['menu_categories'][$category]['image']; ?>.png);"></span></div>
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
