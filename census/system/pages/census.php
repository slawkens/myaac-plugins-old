<?php
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Census';

if(!isset($config['census_countries']))
	$config['census_countries'] = 5;

require PLUGINS . 'census/Census.php';
require SYSTEM . 'countries.conf.php';

if (!function_exists('config')) {
	function config($key) {
		global $config;
		if (is_array($key)) {
			return $config[$key[0]] = $key[1];
		}

		return @$config[$key];
	}
}

global $twig_loader;
$twig_loader->prependPath(BASE . 'plugins/census');
$twig->addGlobal('config', $config);

$census = new \MyAAC\Plugin\Census($db);

$twig->display('census.html.twig', [
	'vocations' => $census->getVocationStats(),
	'genders' => $census->getGenderStats(),
	'countries' => $census->getCountriesStats(),
	'countriesOther' => $census->getCountriesOther(),
]);
