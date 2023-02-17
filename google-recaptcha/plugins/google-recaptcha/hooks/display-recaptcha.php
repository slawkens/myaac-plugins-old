<?php
defined('MYAAC') or die('Direct access not allowed!');

/**
 * @var $configRecaptcha array
 */
if(getBoolean(config('google_recaptcha')['enabled'])) {
	$twig->display('google-recaptcha/templates/recaptcha-display.html.twig');
}
