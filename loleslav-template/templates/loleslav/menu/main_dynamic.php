<?php
defined('MYAAC') or die('Direct access not allowed!');

foreach($menus as $category => $menu) {
	if(!isset($menus[$category]) || $category == 0 || ($category == 5 && !$config['gifts_system'])) { // ignore Top Menu and shop system if disabled
		continue;
	}
?>
<div id="box9" class="box-style2">
	<h2 class="title"><?php echo $config['menu_categories'][$category]['name']; ?></h2>
	<ul class="list1">
<?php
	foreach($menus[$category] as $_menu) {
		if(strpos(trim($_menu['link']), 'http') === 0) {
			echo '<li><a href="' . $_menu['link'] . '" target="_blank">' . $_menu['name'] . '</a></li>';
		}
		else {
			echo '<li><a href="' . getLink($_menu['link']) . '">' . $_menu['name'] . '</a></li>';
		}
	}
?>
	</ul>
</div>
<?php
}
?>