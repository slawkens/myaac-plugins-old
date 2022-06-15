<?php

namespace MyAAC\Plugin;

class Items
{
	/**
	 * @var \OTS_DB_MySQL
	 */
	private $db;

	/**
	 * Constructor
	 * Just ensure that table is loaded
	 *
	 * @param \OTS_DB_MySQL $db
	 */
	public function __construct(\OTS_DB_MySQL $db)
	{
		$this->db = $db;

		$this->ensureTableLoaded();
	}

	/**
	 * Loads items.xml or display error
	 *
	 * @param $itemsXMLPath
	 * @return void
	 */
	public function load($itemsXMLPath)
	{
		// Checks the items.xml file on your server.
		if(file_exists($itemsXMLPath)) {
			$items = new \DOMDocument();
			if(!$items->load($itemsXMLPath)) {
				throw new \RuntimeException('ERROR: Cannot load <i>vocations.xml</i> - the file is malformed. Check the file with xml syntax validator.');
			}
		}
		else {
			echo "Error: cannot load <b>items.xml</b>! File doesn't exist.";
			return;
		}

		// Deletes all rows from the list_of_items table
		$this->db->query("DELETE FROM `list_of_items`;");

		$this->loadItemsIntoDatabase($items);
	}

	/**
	 * Load items to database
	 * Works with fromid and toit too!
	 *
	 * @param $items
	 * @return void
	 */
	private function loadItemsIntoDatabase($items)
	{
		// Insert items into the database
		foreach($items->getElementsByTagName('item') as $item)
		{
			if ($item->getAttribute('fromid')) {
				for ($id = $item->getAttribute('fromid'); $id <= $item->getAttribute('toid'); $id++) {
					$this->parseItem($id, $item);
				}
			} else {
				$this->parseItem($item->getAttribute('id'), $item);
			}
		}
	}

	/**
	 * Parse item node
	 *
	 * @param $id
	 * @param $item
	 * @return void
	 */
	function parseItem($id, $item)
	{
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
			}
		}

		$this->db->insert('list_of_items', [
			'id' => $id,
			'name' => $item->getAttribute('name'),
			'description' => $description,
			'level' => $level,
			'type' => $type,
		]);
	}

	/**
	 * Check if table for items exists in database
	 * If not - then create it
	 *
	 * @return void
	 */
	private function ensureTableLoaded() {
		// Checks if the list_of_items table already exists, if not, it creates it in the database.
		if(!tableExist('list_of_items'))
		{
			$this->db->query(file_get_contents(__DIR__ . '/schema.sql'));
		}
	}
}
