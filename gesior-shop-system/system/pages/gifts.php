<?php
/**
 * This is shop system taken from Gesior, modified for MyAAC.
 *
 * @name      myaac-gesior-shop-system
 * @author    Gesior <jerzyskalski@wp.pl>
 * @author    Slawkens <slawkens@gmail.com>
 * @author    whiteblXK <admin@dbstory.eu>
 * @website   github.com/slawkens/myaac-gesior-shop-system
 */
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Gifts';

require_once(LIBS . 'shop-system.php');
require_once(PLUGINS . 'gesior-shop-system/config.php');

if(!$config['gifts_system']) {
	if(!admin()) {
		$errors[] = 'The gifts system is disabled.';
		$twig->display('error_box.html.twig', array('errors' => $errors));
		return;
	} else {
		warning("You're able to access this page but it is disabled for normal users.<br/>
		Its enabled for you so you can view/edit shop offers before displaying them to use.<br/>
		You can enable it by editing this line in myaac config.local.php file:<br/>
		<p style=\"margin-left: 3em;\"><b>\$config['gifts_system'] = true;</b></p>");
	}
}

if(GesiorShop::getDonationType() == 'coins' && !fieldExist('coins', 'accounts')) {
	$errors[] = "Your server doesn't support accounts.coins. Please change back config.donation_type to points.";
	$twig->display('error_box.html.twig', array('errors' => $errors));
	return;
}

if($logged) {
	$user_premium_points = $account_logged->getCustomField(GesiorShop::getDonationType());
} else {
	$was_before = $config['friendly_urls'];
	$config['friendly_urls'] = true;
	$user_premium_points = generateLink(getLink('?subtopic=accountmanagement') . '&redirect=' . urlencode(BASE_URL . '?subtopic=gifts'), 'Login first');
	$config['friendly_urls'] = $was_before;
}

if(!empty($action)) {
	$errors = array();
	if(!$logged || !$account_logged->isLoaded()) {
		$errors[] = 'Please login first';
		$twig->display('error_box.html.twig', array('errors' => $errors));
		return;
	}

	switch ($action) {
		case 'select_player':
			$buy_id = isset($_REQUEST['buy_id']) ? (int)$_REQUEST['buy_id'] : null;
			if(empty($buy_id)) {
				$errors[] = 'Please <a href="?subtopic=gifts">select item</a> first.';
				break;
			}

			$buy_offer = GesiorShop::getOfferById($buy_id);
			if(!isset($buy_offer['id']) || $buy_offer['hidden'] == '1') {
				$errors[] = 'Offer with ID <b>' . $buy_id . '</b> doesn\'t exist. Please <a href="?subtopic=gifts">select item</a> again.';
				break;
			}

			if($user_premium_points < $buy_offer['points']) {
				$errors[] = 'For this item you need <b>' . $buy_offer['points'] . '</b> points. You have only <b>' . $user_premium_points . '</b> premium points. Please <a href="?subtopic=gifts">select other item</a> or buy premium points.';
				break;
			}

			GesiorShop::selectPlayerAction($account_logged, $buy_id, $buy_offer, $user_premium_points);
			break;

		case 'confirm_transaction':
			$buy_id = isset($_POST['buy_id']) ? (int)$_POST['buy_id'] : null;
			if(empty($buy_id)) {
				$errors[] = 'Please <a href="?subtopic=gifts">select item</a> first.';
				break;
			}

			$buy_offer = GesiorShop::getOfferById($buy_id);
			if(!isset($buy_offer['id']) || $buy_offer['hidden'] == '1') {
				$errors[] = 'Offer with ID <b>' . $buy_id . '</b> doesn\'t exist. Please <a href="?subtopic=gifts">select item</a> again.';
				break;
			}

			$buy_from = isset($_POST['buy_from']) ? stripslashes(urldecode($_POST['buy_from'])) : '';
			if(empty($buy_from)) {
				$buy_from = 'Anonymous';
			}

			if(!check_name($buy_from)) {
				$errors[] = 'Invalid nick ("from player") format. Please <a href="?subtopic=gifts&action=select_player&buy_id=' . $buy_id . '">select other name</a> or contact with administrator.';
				break;
			}

			$buy_name = isset($_POST['buy_name']) ? stripslashes(urldecode($_POST['buy_name'])) : '';
			if(!check_name($buy_name)) {
				$errors[] = 'Invalid name format. Please <a href="?subtopic=gifts&action=select_player&buy_id=' . $buy_id . '">select other name</a> or contact with administrator.';
				break;
			}

			if($user_premium_points < $buy_offer['points']) {
				$errors[] = 'For this item you need <b>' . $buy_offer['points'] . '</b> points. You have only <b>' . $user_premium_points . '</b> premium points. Please <a href="?subtopic=gifts">select other item</a> or buy premium points.';
				break;
			}

			$buy_player = new OTS_Player();
			$buy_player->find($buy_name);
			if(!$buy_player->isLoaded()) {
				$errors[] = 'Player with name <b>' . $buy_name . '</b> doesn\'t exist. Please <a href="?subtopic=gifts&action=select_player&buy_id=' . $buy_id . '">select other name</a>.';
				break;
			}

			GesiorShop::confirmTransactionAction($account_logged, $buy_player, $buy_id, $buy_offer, $buy_from, $buy_name, $user_premium_points, $errors);
			break;

		case 'show_history':
			GesiorShop::showHistoryAction($account_logged);
			break;
	}

	if(!empty($errors)) {
		$twig->display('error_box.html.twig', array('errors' => $errors));
	}
} else {
	unset($_SESSION['viewed_confirmation_page']);

	$offer_types = array();
	$tmp_query = $db->query('SELECT `name`, `description` FROM `' . 'z_shop_categories` WHERE `hidden` != 1')->fetchAll();
	foreach($tmp_query as $tmp_res) {
		$offer_types[$tmp_res['name']] = $tmp_res['description'];
	}

    $get_offer_type = isset($_GET['offertype']) ? $_GET['offertype'] : 'item';
	if($get_offer_type == "mount") {
		$query = $db->query("SELECT `id` FROM `z_shop_offer` WHERE `offer_type` = 'mount' LIMIT 1;");
		if($query->rowCount() > 0) {
			$tmp = '';
			if($cache->enabled() && $cache->fetch('mounts', $tmp)) {
				$config['mounts'] = unserialize($tmp);
			} else {
				$mounts = new DOMDocument();
				$file = $config['data_path'] . 'XML/mounts.xml';
				if(file_exists($file)) {
					$mounts->load($file);
					if($mounts) {
						$config['mounts'] = array();
						foreach($mounts->getElementsByTagName('mount') as $mount) {
							$id = $mount->getAttribute('id');
							$config['mounts'][$id] = $mount->getAttribute('clientid');
						}
						if($cache->enabled()) {
							$cache->set('mounts', serialize($config['mounts']), 120);
						}
					}
				}
			}
		}
	}


    $offers_fetch = array();
    $tmp = null;
    if($cache->enabled() && $cache->fetch('shop_offers_fetch', $tmp)) {
        $offers_fetch = unserialize($tmp);
    } else {
        $offers_fetch = GesiorShop::getOffers();
        if(!empty($offers_fetch)) {
            $mount_image = 'images/shop-system/mounts_category.png';

            foreach($offers_fetch as $id => $item) {
                $item_type = $item['type'];
                if($item_type == "item" || $item_type == "container") {
                    $item_id = isset($item['item_id']) ? $item['item_id'] : null;
                    if ($item_id) {
                        $offers_fetch[$id]['item_img'] = getItemImage($item_id);
                    }

                    $container_id = isset($item['container_id']) ? $item['container_id'] : null;
                    if ($item_type == "container" && $container_id) {
                        $offers_fetch[$id]['container_img'] = getItemImage($container_id);
                    }
                } elseif($item_type == "mount") {
                    $mount = isset($config['mounts'][$item['mount_id']]) ? $config['mounts'][$item['mount_id']] : null;
                    if(isset($config['mounts']) && !empty($mount)) {
                        $mount_image = $config['outfit_images_url'] . '?id=' . $mount. '&addons=0&head=' . $config['shop_outfit_colors']['head'] . '&body=' . $config['shop_outfit_colors']['body'] . '&legs=' . $config['shop_outfit_colors']['legs'] . '&feet=' . $config['shop_outfit_colors']['feet'];
                    }

                    $offers_fetch[$id]['mount_img_dir'] = $mount_image;
                }
            }
        }

        if($cache->enabled()) {
            $cache->set('shop_offers_fetch', serialize($offers_fetch), 120);
        }
    }

	$twig->display('/gesior-shop-system/gifts.html.twig', array(
	    'title' => $title,
		'logged' => !empty($logged) ? $logged : null,
		'user_premium_points' => $user_premium_points,
		'offer_types' => $offer_types,
		'offers_fetch' => $offers_fetch,
		'get_offer_type' => $get_offer_type,
		'outfit_colors' => $config['shop_outfit_colors'],
	));
}
