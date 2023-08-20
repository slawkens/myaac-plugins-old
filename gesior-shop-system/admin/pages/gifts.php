<?php
/**
 * Gifts System
 *
 * @package   MyAAC
 * @author    whiteblXK <admin@dbstory.eu>
 * @copyright 2019 MyAAC
 * @link      https://my-aac.org
 */
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Gifts';
require_once PLUGINS . 'gesior-shop-system/libs/shop-system.php';

$types = [
	'item', 'addon', 'mount', 'pacc', 'container'
];

if(!empty($action)) {
	$id = $_REQUEST['id'] ?? null;
	$errors = array();

	if($action == 'offer_form') {
		$categories = GesiorShop::getCategories();

		$values = [
			'categories' => $categories,
			'types' => $types,
		];

		$offer_id = $_REQUEST['id'] ?? null;
		if ($offer_id !== null) {
			$values['offer'] = GesiorShop::getOfferById($offer_id);
		}

		$twig->display('gesior-shop-system/templates/admin-offers-add.html.twig', $values);
	} elseif($action == 'add' || $action == 'edit') {
		if ($action == 'edit') {
			$offer_id = $_REQUEST['offer_id'] ?? null;

			if (!$offer_id) {
				$errors[] = 'Offer id not set.';
			}
		}

		$itemid1 = $count1 = $itemid2 = $count2 = 0;

		$points = $_REQUEST['points'] ?? null;
		$category_id = $_REQUEST['category'] ?? 1;
		$offer_type = isset($_REQUEST['type']) ? strtolower($_REQUEST['type']) : null;
		$offer_name = $_REQUEST['offer_name'] ?? null;
		$offer_desc = $_REQUEST['description'] ?? '';
		if(empty($points)) {
			error('Please fill all fields. Points is empty.');
		} else if(!$category_id || !is_numeric($category_id)) {
			error('Please fill all fields. Category is empty or its not a number.');
		} else if(empty($offer_type)) {
			error('Please fill all fields. Type is empty.');
		} else if(empty($offer_name)) {
			error('Please fill all fields. Name is empty.');
		} else {
			switch($offer_type) {
				case 'item':
					$itemid1 = $_REQUEST['item_id'] ?? null;
					$count1 = $_REQUEST['item_count'] ?? null;
					if(!$itemid1 || !is_numeric($itemid1)) {
						$errors[] = 'Please fill all fields. Item ID is empty or its not a number.';
					}
					else if(!$count1 || !is_numeric($count1)) {
						$errors[] = 'Please fill all fields. Item Count is empty or its not a number.';
					}

					break;

				case 'container':
					$itemid1 = $_REQUEST['item_id'] ?? null;
					$count1 = $_REQUEST['item_count'] ?? null;
					$itemid2 = $_REQUEST['container_id'] ?? null;
					$count2 = $_REQUEST['container_count'] ?? null;
					if(!$itemid1 || !is_numeric($itemid1)) {
						$errors[] = 'Please fill all fields. Item ID is empty or its not a number.';
					}
					else if(!$count1 || !is_numeric($count1)) {
						$errors[] = 'Please fill all fields. Item Count is empty or its not a number.';
					}
					else if(!$itemid2 || !is_numeric($itemid2)) {
						$errors[] = 'Please fill all fields. Container ID is empty or its not a number.';
					}
					else if(!$count2 || !is_numeric($count2)) {
						$errors[] = 'Please fill all fields. Container Count is empty or its not a number.';
					}

					break;
				case 'addon':
					$itemid1 = $_REQUEST['look_female'] ?? null;
					$count1 = $_REQUEST['addons_female'] ?? null;
					$itemid2 = $_REQUEST['look_male'] ?? null;
					$count2 = $_REQUEST['addons_male'] ?? null;

					if(!$itemid1 || !is_numeric($itemid1)) {
						$errors[] = 'Please fill all fields. Look Female is empty or its not a number.';
					}
					else if(!isset($count1) || !is_numeric($count1)) {
						$errors[] = 'Please fill all fields. Addons Female is empty or its not a number.';
					}
					else if(!$itemid2 || !is_numeric($itemid2)) {
						$errors[] = 'Please fill all fields. Look Male is empty or its not a number.';
					}
					else if(!isset($count2) || !is_numeric($count2)) {
						$errors[] = 'Please fill all fields. Addons Male is empty or its not a number.';
					}

					break;

				case 'mount':
					$itemid1 = $_REQUEST['mount_id'] ?? null;

					if(!$itemid1 || !is_numeric($itemid1)) {
						$errors[] = 'Please fill all fields. Mount ID is empty or its not a number.';
					}

					break;

				case 'pacc':
					$count1 = $_REQUEST['days'] ?? null;

					if(!$count1 || !is_numeric($count1)) {
						$errors[] = 'Please fill all fields. Premium Days is empty or its not a number.';
					}

					break;

				case 'other':
					break;

				default:
					$errors[] = 'Unsupported offer type.';
			}

			if(empty($errors)) {
				$data = [
					'points' => $points,
					'itemid1' => $itemid1, 'count1' => $count1,
					'itemid2' => $itemid2, 'count2' => $count2,
					'category_id' => $category_id,
					'offer_type' => $offer_type,
					'offer_name' => $offer_name, 'offer_description' => $offer_desc,
				];

				if ($action == 'edit') {
					$db->update('z_shop_offer', $data, ['id' => $offer_id]);
					success('Your offer has been edited!');
				}
				else {
					$db->insert('z_shop_offer', $data);
					success('Your offer has been saved!');
				}
			}
		}
	} else if($action == 'delete') {
		GesiorShop::deleteOffer($id, $errors);
		success("Deleted successful.");
	} else if($action == 'toggle_hidden') {
		GesiorShop::toggleOffer($id, $errors, $status);
		success(($status == 1 ? 'Show' : 'Hide') . " successful.");
	}
	else if($action == 'moveup') {
		GesiorShop::move($id, -1, $errors);
	}
	else if($action == 'movedown') {
		GesiorShop::move($id, 1, $errors);
	}
	else if($action == 'edit_categories') {
		$categoriesPost = $_REQUEST['categories'] ?? null;
		if(empty($categoriesPost)) {
			$errors[] = 'Please fill all fields. Categories are empty.';
		}

		$categoriesExploded = explode(',', $categoriesPost);

		if (GesiorShop::saveCategories($categoriesExploded, $errors)) {
			success('Saved categories.');
		}

	}
	else if($action == 'reset_categories') {
		$categoriesReset = ['Items', 'Addons', 'Mounts', 'Premium Account', 'Containers', 'Other'];
		if (GesiorShop::saveCategories($categoriesReset, $errors)) {
			success('Reset categories successful.');
		}
	}

	if(!empty($errors))
		error(implode(", ", $errors));
}

$categories = GesiorShop::getCategories();

$offers = array();
$offers_fetch = GesiorShop::getOffers(true);
if(!empty($offers_fetch)) {
	foreach ($offers_fetch as $offer_id => $offer) {
		$tmp_information = GesiorShop::createOfferInformation($offer, $offer['type']);
		$offers[] = array_merge($offer, array('information' => $tmp_information));
	}
}

if ($action !== 'offer_form') {
	$twig->display('gesior-shop-system/templates/admin-categories.html.twig', [
		'categories' => implode(',', array_values($categories)),
	]);
}

$last = count($offers_fetch);
$twig->display('gesior-shop-system/templates/admin-offers.html.twig', [
	'offers' => $offers,
	'categories' => $categories,
	'last' => $last,
]);
