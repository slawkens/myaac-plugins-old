<?php
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Gifts History';

require_once(PLUGINS . 'gesior-shop-system/libs/shop-system.php');

GesiorShop::showHistoryAction($account_logged);
