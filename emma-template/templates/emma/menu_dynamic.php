<?php
defined('MYAAC') or die('Direct access not allowed!');

$menus = get_template_menus();
foreach($config['menu_categories'] as $id => $cat) {
	if(!isset($menus[$id]) || ($id == MENU_CATEGORY_SHOP && !$config['gifts_system'])) { // ignore Account Menu and shop system if disabled
		continue;
	}

	echo '<div id="' . $cat['id'] . '">
	<div class="button" onclick="menuAction(\'' . $cat['id'] . '\');">
		<div id="' . $cat['id'] . '_Status" class="status" style="background-image: url(' . $template_path . '/images/menu/open.png);"></div>
		<div id="' . $cat['id'] . '_Icon" class="icon" style="background-image: url(' . $template_path . '/images/menu/' . $cat['id'] . '_icon.png);"></div>
		<div id="' . $cat['id'] . '_Name" class="name" style="background-image: url(' . $template_path . '/images/menu/' . $cat['id'] . '.png);"></div>
	</div>
	<div id="' . $cat['id'] . '_Submenu">
		<div class="submenu">
			<ul>';
	foreach($menus[$id] as $_menu) {
		if(strpos(trim($_menu['link']), 'http') === 0) {
			echo '<li class="menu-item"><a href="' . $_menu['link'] . '" target="_blank">' . $_menu['name'] . '</a></li>';
		}
		else {
			echo '<li class="menu-item"><a href="' . getLink($_menu['link']) . '">' . $_menu['name'] . '</a></li>';
		}
	}
	
	echo '</ul>
		</div>
	</div>
</div>';
}
?>