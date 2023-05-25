<?php
defined('MYAAC') or die('Direct access not allowed!');

require_once __DIR__ . '/../init.php';

// account_create_auto_login
// ignore recaptcha when account has been just created
if (PAGE === 'account/create') {
	return;
}

if(GoogleReCAPTCHA::enabled()) {
	if (!GoogleReCAPTCHA::verify('login')) {
		global $errors, $logged;
		unsetSession('account');
		unsetSession('password');
		unsetSession('remember_me');
		$logged = false;

		$errors[] = GoogleReCAPTCHA::getErrorMessage();
		return false;
	}
}
