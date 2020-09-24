<?php
if(!$logged) {
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

$menus = require BASE_DIR . 'plugins/TibiaClient-template/menus.php';

if(tableExist(TABLE_PREFIX . 'menu')) {
	$menus = get_template_menus();
}
else {
	foreach($config['menu_categories'] as $category => $values) {
		$tmp_menu = $menus[$category];
		foreach($tmp_menu as &$menu) {
			$link_full = strpos(trim($menu['link']), 'http') === 0 ? $menu['link'] : getLink($menu['link']);
			$menu['link_full'] = $link_full;
			$menu['blank'] = (isset($menu['blank']) ? $menu['blank'] == 1 : false);
		}

		$menus[$category] = $tmp_menu;
	}
}

if($logged) {
	$twig->display('menu.html.twig', ['name' => 'Your Account', 'links' =>
		$menus[MENU_CATEGORY_ACCOUNT_LOGGED]]);
}
$twig->display('menu.html.twig', ['name' => 'News', 'links' => $menus[MENU_CATEGORY_NEWS]]);
$twig->display('menu.html.twig', ['name' => 'Account', 'links' => $menus[MENU_CATEGORY_ACCOUNTS]]);
$twig->display('menu.html.twig', ['name' => 'Community', 'links' => $menus[MENU_CATEGORY_COMMUNITY]]);
$twig->display('menu.html.twig', ['name' => 'Library', 'links' => $menus[MENU_CATEGORY_LIBRARY]]);

if(config('gifts_system')) {
	$twig->display('menu.html.twig', ['name' => 'Shop', 'links' => $menus[MENU_CATEGORY_SHOP]]);
}
