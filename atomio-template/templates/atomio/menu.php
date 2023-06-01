<?php
defined('MYAAC') or die('Direct access not allowed!');

foreach($config['menu_categories'] as $id => $cat) {
	if (!isset($menus[$id]) || ($id == MENU_CATEGORY_SHOP && !config('gifts_system'))) {
		continue;
	}
?>
	<li><a><i class="fa fa-<?=$cat["icon"]?>"></i> <?=$cat['name']?></a>
		<ul>
			<?php foreach($menus[$id] as $link) {
				echo '<li><a href="' . $link['link_full'] . '" ' .
			($link['blank']
				? '
				target="_blank"' :
				'') . (strlen($link['color']) == 0 ? '' : 'style="color: #' . $link['color']) . ';">' .
					$link['name'] . '</a></li>';
			}
			?>
		</ul>
	</li>
<?php
}
