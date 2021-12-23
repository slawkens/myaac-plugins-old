<?php
/**
 *
 * @name      list-of-items
 * @author    Endless <walistonbelles1@gmail.com>
 * @author    Slawkens <slawkens@gmail.com>
 */
defined('MYAAC') or die('Direct access not allowed!');

$title = 'List Of Items';

require PLUGINS . 'list_of_items/Items.php';
$items = new \MyAAC\Plugin\Items($db);

$twig_loader->prependPath(PLUGINS . 'list_of_items');

$reload = isset($_REQUEST['reload']) && (int)$_REQUEST['reload'] == 1;

if($reload && admin()) {
	$items->load($config['data_path'] . '/items/items.xml');
	success('Items reloaded.');
}

// Checks if you have an Administrator account
if(admin()) {
	// Show button to reload the items.
	echo $twig->render('reload.html.twig');
}

$type = isset($_GET['type']) ? $_GET['type'] : '';

$possibleTypes = [
	'head',
	'necklace',
	'ring',
	'body',
	'shield',
	'weapon',
	'legs',
	'feet'
];

if (empty($type) || !in_array($type, $possibleTypes)) {
	$twig->display('list.html.twig');
	return;
}

$headerTitle = 'Unknown';
$addQuery = '';

switch ($type) {
	case 'head':
		$title = 'Helmets';
		$headerTitle = 'Armor';
		break;

	case 'necklace':
		$title = 'Necklace';
		$headerTitle = 'Armor';
		break;

	case 'ring':
		$title = 'Rings';
		$headerTitle = 'Armor';
		break;

	case 'body':
		$title = 'Armors';
		$headerTitle = 'Armor';
		break;

	case 'shield':
		$title = 'Shields';
		$headerTitle = 'Defense';
		break;

	case 'weapon':
		$title = 'Weapons';
		$headerTitle = 'Attack';
		$addQuery = "`type` IN ('distance', 'club', 'sword', 'axe')";
		break;

	case 'legs':
		$title = 'Legs';
		$headerTitle = 'Armor';
		break;

	case 'feet':
		$title = 'Boots';
		$headerTitle = 'Armor';
		break;
}

if (empty($addQuery)) {
	$addQuery = "`type` = " . $db->quote($type);
}

$query = $db->query("SELECT * FROM `list_of_items` WHERE " . $addQuery . " ORDER BY `level` DESC");

$items = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($items as &$item) {
	$item['image'] = getItemImage($item['id']);
}

$twig->display('item.html.twig', [
	'items' => $items,
	'headerDesc' => $headerTitle,
]);

