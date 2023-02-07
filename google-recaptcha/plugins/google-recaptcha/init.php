<?php

require __DIR__ . '/libs/GoogleReCAPTCHA.php';

$configRecaptcha = config('google_recaptcha');
if (!isset($configRecaptcha)) {
	$configRecaptcha = require __DIR__ . '/config.php';
}
