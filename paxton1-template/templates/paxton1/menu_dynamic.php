<?php
defined('MYAAC') or die('Direct access not allowed!');

$menus = get_template_menus();

foreach($menus as $category => $menu) {
	if(!isset($menus[$category]) || ($category == 5 && !$config['gifts_system'])) { // ignore Account Menu and shop system if disabled
		continue;
	}
	
	echo '<div id="menu-top">' . $config['menu_categories'][$category]['name'] . '</div>
<div id="menu-cnt">
	<ul>
		<li>
			<ul>';
	
	foreach($menus[$category] as $_menu) {
		if(strpos(trim($_menu['link']), 'http') === 0) {
			echo '<li><a href="' . $_menu['link'] . '" target="_blank">' . $_menu['name'] . '</a></li>';
		}
		else {
			echo '<li><a href="' . getLink($_menu['link']) . '">' . $_menu['name'] . '</a></li>';
		}
	}
	
	echo '</ul>
		</li>
	</ul>
</div>';
}
?>