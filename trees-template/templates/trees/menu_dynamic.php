<?php
defined('MYAAC') or die('Direct access not allowed!');

$menus = get_template_menus();

foreach($menus as $category => $menu) {
	if(!isset($menus[$category]) || $category == 7 || ($category == 6 && !$config['gifts_system'])) { // ignore Account Menu and shop system if disabled
		continue;
	}
	
	$size = count($menus[$category]);
	
	if($size == 1) { // only one menu item, dont show full menu, just link
		if(strpos(trim($menu[0]['link']), 'http') === 0) {
			echo '<li><a href="' . $menu[0]['link'] . '" target="_blank">' . $menu[0]['name'] . '</a></li>';
		}
		else {
			echo '<li><a href="' . getLink($menu[0]['link']) . '">' . $menu[0]['name'] . '</a></li>';
		}
		
		continue;
	}
	
	echo '<li><a href="#">' . $config['menu_categories'][$category]['name'] . '</a><ul>';
	foreach($menus[$category] as $_menu) {
		if(strpos(trim($_menu['link']), 'http') === 0) {
			echo '<li><a href="' . $_menu['link'] . '" target="_blank">' . $_menu['name'] . '</a></li>';
		}
		else {
			echo '<li><a href="' . getLink($_menu['link']) . '">' . $_menu['name'] . '</a></li>';
		}
	}
	
	echo '</ul></li>';
}
?>