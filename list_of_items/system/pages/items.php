<?php
/**
 *
 * @name      list-of-items
 * @author    Endless <walistonbelles1@gmail.com>
 * @author    Slawkens <slawkens@gmail.com>
 */
defined('MYAAC') or die('Direct access not allowed!');

$title = 'List Of Items';

// Checks if the list_of_items table already exists, if not, it creates it in the database.
if(!tableExist('list_of_items'))
{
	$db->query("
CREATE TABLE IF NOT EXISTS `list_of_items` (
	`id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL,
	`description` VARCHAR(1000) NOT NULL,
	`level` INT(11) NOT NULL,
	`type` VARCHAR(255) NOT NULL DEFAULT '',
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
		");
}

$twig_loader->prependPath(PLUGINS . 'list_of_items');

$reload = isset($_REQUEST['reload']) && (int)$_REQUEST['reload'] == 1;

if($reload) {

	// Checks the items.xml file on your server.
	if(file_exists($config['data_path'] . '/items/items.xml')) {
		$items = new DOMDocument();
		$items->load($config['data_path'] . '/items/items.xml');
	}

	// If not, it returns an error.
	if(!$items)
	{
		echo 'Error: cannot load <b>items.xml</b>!';
		return;
	}

	// Deletes all rows from the list_of_items table
	$db->query("DELETE FROM `list_of_items`;");

	// Insert items into the database
	foreach($items->getElementsByTagName('item') as $item)
	{
		if ($item->getAttribute('fromid')) {
			for ($id = $item->getAttribute('fromid'); $id <= $item->getAttribute('toid'); $id++) {
				myCustomAddItem($id, $item);
			}
		} else {
			myCustomAddItem($item->getAttribute('id'), $item);
		}
	}

	success('Items reloaded.');
}

function myCustomAddItem($id, $item) {
	global $db;

	$description = '';
	$type = '';
	$level = 0;

	foreach( $item->getElementsByTagName('attribute') as $attribute)
	{
		if ($attribute->getAttribute('key') == 'description'){
			$description = $attribute->getAttribute('value');
			continue;
		}

		if ($attribute->getAttribute('key') == 'weaponType') {
			$type = $attribute->getAttribute('value');

			if ($type == 'axe' || $type == 'club' || $type == 'sword') {
				foreach( $item->getElementsByTagName('attribute') as $_attribute) {
					if($_attribute->getAttribute('key') == 'attack') {
						$level = $_attribute->getAttribute('value');
						break;
					}
				}
			}
			if ($type == 'shield') {
				foreach( $item->getElementsByTagName('attribute') as $_attribute) {
					if($_attribute->getAttribute('key') == 'defense') {
						$level = $_attribute->getAttribute('value');
						break;
					}
				}
			}

			continue;
		}

		if ($attribute->getAttribute('key') == 'slotType' && empty($type)) {
			$type = $attribute->getAttribute('value');

			if ($type == 'head' || $type == 'body' || $type == 'legs' || $type == 'feet') {
				foreach( $item->getElementsByTagName('attribute') as $_attribute) {
					if($_attribute->getAttribute('key') == 'armor') {
						$level = $_attribute->getAttribute('value');
						break;
					}
				}
			}
			else if ($type == 'backpack') {
				foreach( $item->getElementsByTagName('attribute') as $_attribute) {
					if($_attribute->getAttribute('key') == 'containerSize') {
						$level = $_attribute->getAttribute('value');
						break;
					}
				}
			}
			continue;
		}
	}

	//var_dump(strlen($item->getAttribute('name')));
	$db->insert('list_of_items', [
		'id' => $id,
		'name' => $item->getAttribute('name'),
		'description' => $description,
		'level' => $level,
		'type' => $type,
	]);
}

// Checks if you have an Administrator account
if(admin()) {
	// Press the button to reload the items.
	echo $twig->render('reload.html.twig');
}

$twig->display('list.html.twig');
