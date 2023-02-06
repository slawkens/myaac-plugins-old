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

class GesiorShop {
	public static function getDonationType() {
		global $config;

		$field = 'premium_points';
		if(strtolower($config['donation_type']) == 'coins') {
			$field = 'coins';
		}

		return $field;
	}

    public static function changePoints(OTS_Account $account, $amount) {
        if (!$account->isLoaded()) {
            return false;
        }

        $field = self::getDonationType();
        $account->setCustomField($field, $account->getCustomField($field) + $amount);
        return true;
    }

    private static function parseOffer($_offer) {
	    list($offer_id, $offer_points, $offer_itemid1, $offer_count1, $offer_itemid2, $offer_count2, $offer_type, $offer_description, $offer_name, $offer_hidden) = $_offer;

        $offer = array('id' => $offer_id, 'name' => $offer_name, 'type' => $offer_type, 'points' => $offer_points, 'description' => $offer_description, 'hidden' => $offer_hidden);
        switch($offer_type) {
            case 'pacc':
                $offer = array_merge($offer, array('days' => $offer_count1));
                break;

            case 'item':
                $offer = array_merge($offer, array('item_id' => $offer_itemid1, 'item_count' => $offer_count1));
                break;

            case 'container':
                $offer = array_merge($offer, array('item_id' => $offer_itemid1, 'item_count' => $offer_count1, 'container_id' => $offer_itemid2, 'container_count' => $offer_count2));
                break;

            case 'addon':
                $offer = array_merge($offer, array('look_female' => $offer_itemid1, 'addons_female' => $offer_count1, 'look_male' => $offer_itemid2, 'addons_male' => $offer_count2));
                break;

            case 'mount':
                $offer = array_merge($offer, array('mount_id' => $offer_itemid1));
                break;
        }

        return $offer;
    }

    public static function getOfferById($id) {
        global $db;

        $id = (int) $id;
        $data = $db->query('SELECT * FROM ' . $db->tableName('z_shop_offer') . ' WHERE ' . $db->fieldName('id') . ' = ' . $db->quote($id) . ';')->fetch();
        return self::parseOffer($data);
    }

    public static function getOffers($with_hidden = false) {
        global $db;
        $offers = array();

        $hidden = $with_hidden ? ';' : ' WHERE hidden != 1;';
        $offers_list = $db->query('SELECT * FROM ' . $db->tableName('z_shop_offer') . $hidden);
        if(is_object($offers_list)) {
            foreach($offers_list as $offer) {
                $offers[] = self::parseOffer($offer);
            }
        }

        return $offers;
    }

    public static function selectPlayerAction(OTS_Account $account, $buy_id, $buy_offer, $user_premium_points) {
        global $twig;
        unset($_SESSION['viewed_confirmation_page']);

        $account_players = array();
        $players_list = $account->getPlayersList();
        if (count($players_list) > 0) {
            $players_list->orderBy('name');

            foreach ($players_list as $player) {
                $account_players[] = $player->getName();
            }
        }

        $twig->display('/gesior-shop-system/select-player.html.twig', array(
            'buy_offer' => $buy_offer,
            'buy_id' => $buy_id,
            'account_players' => $account_players,
            'user_premium_points' => $user_premium_points
        ));
    }

    public static function confirmTransactionAction(OTS_Account $account, OTS_Player $buy_player, $buy_id, $buy_offer, $buy_from, $buy_name, &$user_premium_points, &$errors) {
	    global $db, $twig;
        $set_session = false;

        $buy_player_account = $buy_player->getAccount();

        $viewed_confirmation_page = isset($_SESSION['viewed_confirmation_page']) && $_SESSION['viewed_confirmation_page'] == 'yes';
        $buy_confirmed = isset($_POST['buy_confirmed']) && $_POST['buy_confirmed'] == 'yes';
        if($viewed_confirmation_page && $buy_confirmed) {
            $query = null;
            $save_transaction = null;

            switch($buy_offer['type']) {
                case 'pacc':
                    $is_othire = fieldExist('premend', 'accounts');
                    if($is_othire && $buy_player->isOnline()) {
                        $errors[] = 'Player with name <b>' . $buy_name . '</b> is online. Please logout. Then <a href="?subtopic=gifts&action=select_player&buy_id=' . $buy_id . '">refresh this page</a>.';
                        break;
                    }

                    $save_transaction = 'INSERT INTO ' . $db->tableName('z_shop_history') . ' (id, to_name, to_account, from_nick, from_account, price, offer_id, trans_state, trans_start, trans_real, is_pacc) VALUES (NULL, ' . $db->quote($buy_player->getName()) . ', ' . $db->quote($buy_player_account->getId()) . ', ' . $db->quote($buy_from) . ',  ' . $db->quote($account->getId()) . ', ' . $db->quote($buy_offer['points']) . ', ' . $db->quote($buy_offer['id']) . ', \'realized\', ' . $db->quote(time()) . ', ' . $db->quote(time()) . ', 1);';
                    if ($is_othire) {
                        $time = $buy_player_account->getCustomField('premend');
                        if ($time == 0) {
                            $time = time();
                        }

                        $buy_player_account->setCustomField('premend', $time + $buy_offer['days'] * 86400);
                    } else {// rest
                        $buy_player_account->setCustomField('premdays', $buy_player_account->getCustomField('premdays') + $buy_offer['days']);

                        if ($buy_player_account->getCustomField('lastday') == 0) {
                            $buy_player_account->setCustomField('lastday', time());
                        }
                    }
                    break;

                case 'item':
                    $query = 'INSERT INTO '.$db->tableName('z_ots_comunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$db->quote($buy_player->getName()).', \'login\', \'give_item\', '.$db->quote($buy_offer['item_id']).', '.$db->quote($buy_offer['item_count']).', 0, 0, \'item\', '.$db->quote($buy_offer['name']).', \'\', \'1\');';
                    break;

                case 'addon':
                    $query = 'INSERT INTO '.$db->tableName('z_ots_comunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$db->quote($buy_player->getName()).', \'login\', \'give_item\', '.$db->quote($buy_offer['look_female']).', '.$db->quote($buy_offer['look_male']).', '.$db->quote($buy_offer['addons_female']).', '.$db->quote($buy_offer['addons_male']).', \'addon\', '.$db->quote($buy_offer['name']).', \'\', \'1\');';
                    break;

                case 'mount':
                    $query = 'INSERT INTO '.$db->tableName('z_ots_comunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$db->quote($buy_player->getName()).', \'login\', \'give_item\', '.$db->quote($buy_offer['mount_id']).', 0, 0, 0, \'mount\', '.$db->quote($buy_offer['name']).', \'\', \'1\');';
                    break;

                case 'container':
                    $query = 'INSERT INTO '.$db->tableName('z_ots_comunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$db->quote($buy_player->getName()).', \'login\', \'give_item\', '.$db->quote($buy_offer['item_id']).', '.$db->quote($buy_offer['item_count']).', '.$db->quote($buy_offer['container_id']).', '.$db->quote($buy_offer['container_count']).', \'container\', '.$db->quote($buy_offer['name']).', \'\', \'1\');';
                    break;

                default:
                    $errors[] = 'Unsupported offer type.';
            }

            if(empty($errors)) {
                if (!empty($query)) {
                    $db->query($query);
                }

                if (empty($save_transaction)) {
                    $save_transaction = 'INSERT INTO ' . $db->tableName('z_shop_history') . ' (id, comunication_id, to_name, to_account, from_nick, from_account, price, offer_id, trans_state, trans_start, trans_real) VALUES (NULL, ' . $db->lastInsertId() . ', ' . $db->quote($buy_player->getName()) . ', ' . $db->quote($buy_player_account->getId()) . ', ' . $db->quote($buy_from) . ',  ' . $db->quote($account->getId()) . ', ' . $db->quote($buy_offer['points']) . ', ' . $db->quote($buy_offer['id']) . ', \'wait\', ' . $db->quote(time()) . ', \'0\');';
                }
                $db->query($save_transaction);

                $user_premium_points -= $buy_offer['points'];
                self::changePoints($account, -$buy_offer['points']);
            }
        } else {
            $set_session = true;
            $_SESSION['viewed_confirmation_page'] = 'yes';
        }

        if(empty($errors)) {
            $twig->display('/gesior-shop-system/confirm-transaction.html.twig', array(
                'show_confirmation_page' => (!$viewed_confirmation_page || !$buy_confirmed) ? true : false,
                'buy_offer' => $buy_offer,
                'buy_player_name' => $buy_player->getName(),
                'buy_from' => $buy_from,
                'buy_id' => $buy_id,
                'buy_name' => $buy_name,
                'user_premium_points' => $user_premium_points
            ));
        }

        if(!$set_session) {
            unset($_SESSION['viewed_confirmation_page']);
        }
    }

    private static function fetchHistory(OTS_Account $account) {
	    global $db;

        $history_items = array();
        $history_paccs = array();

        $shop_history_query = $db->query('SELECT * FROM ' . $db->tableName('z_shop_history') . ' WHERE (' . $db->fieldName('to_account') . ' = ' . $db->quote($account->getId()) . ' OR ' . $db->fieldName('from_account') . ' = ' . $db->quote($account->getId()) . ');');
        if(is_object($shop_history_query)) {
            foreach($shop_history_query as $shop_history) {
                $item_name = array('item_name' => GesiorShop::getOfferById($shop_history['offer_id']));

                if(empty($shop_history['is_pacc'])) {
                    $history_items[] = array_merge($item_name, $shop_history);
                } else {
                    $history_paccs[] = array_merge($item_name, $shop_history);
                }
            }
        }

        return array($history_items, $history_paccs);
    }

    public static function showHistoryAction(OTS_Account $account) {
        global $twig;

        list($items_history, $paccs_history) = self::fetchHistory($account);
        $twig->display('/gesior-shop-system/show-history.html.twig', array(
            'logged_id' => !empty($account) ? $account->getId() : null,
            'items_history' => $items_history,
            'paccs_history' => $paccs_history
        ));
    }

    public static function createOfferInformation($offer, $offer_type) {
        $information = '';
        if (empty($offer) || empty($offer_type)) {
            return $information;
        }

        switch ($offer_type) {
            case 'pacc':
                $information = $offer['days'] . ' premium days';
                break;

            case 'item':
                $information = 'Item ID: ' . $offer['item_id'] . ', count: ' . $offer['item_count'];
                break;

            case 'container':
                $information = 'Container Id: ' . $offer['container_id'] . ', count: ' . $offer['container_count'] . '. Item ID: ' . $offer['item_id'] . ', count: ' . $offer['item_count'];
                break;

            case 'addon':
                $information = 'Look Female: ' . $offer['look_female'] . ', addons female: ' . $offer['addons_female'] . '. Look Male: ' . $offer['look_male'] . ', addons male: : ' . $offer['addons_male'];
                break;

            case 'mount':
                $information = 'Mount Id: ' . $offer['mount_id'];
                break;
        }

        return $information;
    }

    public static function deleteOffer($id, &$errors) {
        global $db;

        if(isset($id)) {
            if($db->select('z_shop_offer', array('id' => $id)) !== false) {
                $db->delete('z_shop_offer', array('id' => $id));
            } else {
                $errors[] = 'Offer with id ' . $id . ' does not exists.';
            }
        } else {
            $errors[] = 'Offer id not set.';
        }

        return !count($errors);
    }

    public static function toggleOffer($id, &$errors, &$status) {
        global $db;

        if(isset($id)) {
            $query = $db->select('z_shop_offer', array('id' => $id));
            if($query !== false) {
                $db->update('z_shop_offer', array('hidden' => ($query['hidden'] == 1 ? 0 : 1)), array('id' => $id));
                $status = $query['hidden'];
            } else {
                $errors[] = 'Offer with id ' . $id . ' does not exists.';
            }
        } else {
            $errors[] = 'Offer id not set.';
        }

        return !count($errors);
    }
}