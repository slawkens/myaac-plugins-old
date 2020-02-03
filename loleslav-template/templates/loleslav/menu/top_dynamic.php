<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<div id="menu">
	<ul class="container">
<?php

$menus = get_template_menus();
$i = 0;
foreach($menus[0] as $menu) {
	if (strpos(trim($menu['link']), 'http') === 0) {
		echo '<li' . ($i++ == 0 ? ' class="first"' : '') . '><a href="' . $menu['link'] . '" target="_blank">' . $menu['name'] . '</a></li>';
	} else {
		echo '<li' . ($i++ == 0 ? ' class="first"' : '') . '><a href="' . getLink($menu['link']) . '">' . $menu['name'] . '</a></li>';
	}
}
?>
	</ul>
</div>