<?php
$menus = get_template_menus();
?>
<ul>
<?php
foreach($menus[1] as $menu) {
	// hide shop when disabled
	if(in_array($menu['link'], array('points', 'gifts', 'gifts/history')) && !$config['gifts_system']) {
		continue;
	}

	if(strpos(trim($menu['link']), 'http') === 0) {
		echo '<li><a href="' . $menu['link'] . '" target="_blank">' . $menu['name'] . '</a></li>';
	}
	else {
		echo '<li><a href="' . getLink($menu['link']) . '">' . $menu['name'] . '</a></li>';
	}
}
?>
</ul>