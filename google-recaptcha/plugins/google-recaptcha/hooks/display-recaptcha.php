<?php

/**
 * @var $configRecaptcha array
 */
if(getBoolean(config('google_recaptcha')['enabled'])) {
	$twig->display('google-recaptcha/templates/recaptcha-display.html.twig');
}
