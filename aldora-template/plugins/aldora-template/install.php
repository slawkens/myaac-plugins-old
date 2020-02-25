<?php
defined('MYAAC') or die('Direct access not allowed!');

$template = 'aldora';

require TEMPLATES . $template . '/config.php';

if (!tableExist(TABLE_PREFIX . 'menu')) {
	return;
}

$query = $db->query('SELECT `id` FROM `' . TABLE_PREFIX . 'menu` WHERE `template` = ' . $db->quote($template) . ' LIMIT 1;');
if ($query->rowCount() > 0) {
	return;
}

$categories = require PLUGINS . $template . '-template/menus.php';

foreach ($categories as $category => $menus) {
	$i = 0;
	foreach ($menus as $name => $link) {
		$color = '';
		$blank = 0;

		if (is_array($link)) {
			if (isset($link['color'])) {
				$color = $link['color'];
			}
			if (isset($link['blank'])) {
				$blank = $link['blank'] === true ? 1 : 0;
			}

			$link = $link['link'];
		}

		$db->insert(TABLE_PREFIX . 'menu',
			[
				'template' => $template,
				'name' => $name,
				'link' => $link,
				'blank' => $blank,
				'color' => $color,
				'category' => $category,
				'ordering' => $i++,
			]);

		unset($color);
	}

}
