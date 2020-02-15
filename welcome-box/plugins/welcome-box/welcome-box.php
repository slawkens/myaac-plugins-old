<?php
/**
 * Welcome Box for MyAAC
 *
 * @name      powerful-guilds
 * @author    slawkens <slawkens@gmail.com>
 */

use MyAAC\Plugin\WelcomeBox;

/**
 * @var $config array
 */
if('news' !== PAGE) {
	return;
}

require PLUGINS . 'welcome-box/WelcomeBox.php';

global $twig_loader;
$twig_loader->prependPath(BASE . 'plugins/welcome-box');

$tmp = null;
$cache = Cache::getInstance();
if(!$cache->enabled() || !$cache->fetch('welcome-box', $tmp)) {
	$welcomeBox = new WelcomeBox($db);
	$values = [
		'lastJoinedPlayer' => $welcomeBox->getLastJoinedPlayer(),
		'bestPlayer' => $welcomeBox->getBestPlayer(),
		'total' => $welcomeBox->getTotal(),
	];

	if($cache->enabled()) {
		$cache->set('welcome-box-values', serialize($values), 10 * 60); // cache for 10 minutes
	}
}
else {
	$values = unserialize($tmp);
}

$twig->display('welcome-box.html.twig', [
	'values' => $values
]);
