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
require_once LIBS . 'shop-system.php';

if(!empty($action)) {
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $errors = array();

    if($action == 'offer_form') {
        $categories = array();

        $query = $db->query("SELECT * FROM `z_shop_categories` WHERE `hidden` = 0;");
        if (is_object($query)) {
            foreach ($query as $category) {
                $categories[] = $category;
            }
        }

        $twig->display('gesior-shop-system/admin-offers-add.html.twig', array(
            'categories' => $categories
        ));
    } elseif($action == 'add') {
        $itemid1 = $count1 = $itemid2 = $count2 = 0;

        $points = isset($_REQUEST['points']) ? $_REQUEST['points'] : null;
        $offer_type = isset($_REQUEST['type']) ? strtolower($_REQUEST['type']) : null;
        $offer_name = isset($_REQUEST['offer_name']) ? $_REQUEST['offer_name'] : null;
        $offer_desc = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        if(empty($points)) {
            error('Please fill all fields. Points is empty.');
        } else if(empty($offer_type)) {
            error('Please fill all fields. Type is empty.');
        } else if(empty($offer_name)) {
            error('Please fill all fields. Name is empty.');
        } else {
            switch($offer_type) {
                case 'item':
                    $itemid1 = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : null;
                    $count1 = isset($_REQUEST['item_count']) ? $_REQUEST['item_count'] : null;
                    if(!$itemid1 || !is_numeric($itemid1)) {
                        $errors[] = 'Please fill all fields. Item ID is empty or its not a number.';
                    }
                    else if(!$count1 || !is_numeric($count1)) {
                        $errors[] = 'Please fill all fields. Item Count is empty or its not a number.';
                    }

                    break;

                case 'container':
                    $itemid1 = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : null;
                    $count1 = isset($_REQUEST['item_count']) ? $_REQUEST['item_count'] : null;
                    $itemid2 = isset($_REQUEST['container_id']) ? $_REQUEST['container_id'] : null;
                    $count2 = isset($_REQUEST['container_count']) ? $_REQUEST['container_count'] : null;
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
                    $itemid1 = isset($_REQUEST['look_female']) ? $_REQUEST['look_female'] : null;
                    $count1 = isset($_REQUEST['addons_female']) ? $_REQUEST['addons_female'] : null;
                    $itemid2 = isset($_REQUEST['look_male']) ? $_REQUEST['look_male'] : null;
                    $count2 = isset($_REQUEST['addons_male']) ? $_REQUEST['addons_male'] : null;

                    if(!$itemid1 || !is_numeric($itemid1)) {
                        $errors[] = 'Please fill all fields. Look Female is empty or its not a number.';
                    }
                    else if(!$count1 || !is_numeric($count1)) {
                        $errors[] = 'Please fill all fields. Addons Female is empty or its not a number.';
                    }
                    else if(!$itemid2 || !is_numeric($itemid2)) {
                        $errors[] = 'Please fill all fields. Look Male is empty or its not a number.';
                    }
                    else if(!$count2 || !is_numeric($count2)) {
                        $errors[] = 'Please fill all fields. Addons Male is empty or its not a number.';
                    }

                    break;

                case 'mount':
                    $itemid1 = isset($_REQUEST['mount_id']) ? $_REQUEST['mount_id'] : null;

                    if(!$itemid1 || !is_numeric($itemid1)) {
                        $errors[] = 'Please fill all fields. Mount ID is empty or its not a number.';
                    }

                    break;

                case 'pacc':
                    $count1 = isset($_REQUEST['days']) ? $_REQUEST['days'] : null;

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
                $db->insert('z_shop_offer', array(
                    'points' => $points,
                    'itemid1' => $itemid1, 'count1' => $count1,
                    'itemid2' => $itemid2, 'count2' => $count2,
                    'offer_type' => $offer_type,
                    'offer_name' => $offer_name, 'offer_description' => $offer_desc,
                ));

                success('Your offer has been saved!');
            }
        }
    } else if($action == 'delete') {
        GesiorShop::deleteOffer($id, $errors);
        success("Deleted successful.");
    } else if($action == 'toggle_hidden') {
        GesiorShop::toggleOffer($id, $errors, $status);
        success(($status == 1 ? 'Show' : 'Hide') . " successful.");
    }

    if(!empty($errors))
        error(implode(", ", $errors));
}

$offers = array();
$offers_fetch = GesiorShop::getOffers(true);
if(!empty($offers_fetch)) {
    foreach ($offers_fetch as $offer_id => $offer) {
        $tmp_information = GesiorShop::createOfferInformation($offer, $offer['type']);
        $offers[] = array_merge($offer, array('information' => $tmp_information));
    }
}

$twig->display('gesior-shop-system/admin-offers.html.twig', array(
    'offers' => $offers
));