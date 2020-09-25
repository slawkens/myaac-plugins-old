<?php
if (!$logged) {
?>
<div class="window outerBox">
	<div class="innerWindow innerBox"></div>
	<div class="windowHeader">
		Login
	</div>
	<div class="windowBody">
		<form class="loginForm" action="account/manage" method="post">
			<input type="text" name="account_login" placeholder="account name">
			<input type="password" name="password_login" placeholder="password">
			<input type="submit" name="submit" value="Login">
		</form>
	</div>
</div>
<?php
}

$menusFromFile = require BASE_DIR . 'plugins/TibiaClient-template/menus.php';
$menuCategories = $config['menu_categories'];
$menus = [];

if (tableExist(TABLE_PREFIX . 'menu')) {
	$menus = get_template_menus();
}

if (count($menus) === 0) {
	$menus = $menusFromFile;
}

foreach ($menuCategories as $category => $values) {
	$tmp_menu = $menus[$category];
	foreach ($tmp_menu as &$menu) {
		$link_full = strpos(trim($menu['link']), 'http') === 0 ? $menu['link'] : getLink($menu['link']);
		$menu['link_full'] = $link_full;
		$menu['blank'] = (isset($menu['blank']) ? $menu['blank'] == 1 || $menu['blank'] : false);
	}

	$menus[$category] = $tmp_menu;
}

if ($logged) {
	$twig->display('menu.html.twig', ['name' => $menuCategories[MENU_CATEGORY_ACCOUNT_LOGGED]['name'], 'links' =>
		$menus[MENU_CATEGORY_ACCOUNT_LOGGED]]);
}

foreach ($menuCategories as $category => $values) {
	if ($category === MENU_CATEGORY_ACCOUNT_LOGGED) {
		continue;
	}

	if ($category === MENU_CATEGORY_SHOP && !$config['gifts_system']) {
		continue;
	}

	$twig->display('menu.html.twig', ['name' => $values['name'], 'links' => $menus[$category]]);
}
