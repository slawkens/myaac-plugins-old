<?php

$twig_loader->prependPath(PLUGINS . 'list_of_items');

if(!isset($type)) {
	$title = 'Not Found';
	return;
}

$query = $db->query("SELECT * FROM `list_of_items` WHERE " . $addQuery . " ORDER BY `level` DESC");

$items = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($items as &$item) {
	$item['image'] = getItemImage($item['id']);
}

$twig->display('item.html.twig', [
	'items' => $items,
	'headerDesc' => $headerDesc,
]);
