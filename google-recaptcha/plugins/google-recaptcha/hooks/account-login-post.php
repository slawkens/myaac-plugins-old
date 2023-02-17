<?php
defined('MYAAC') or die('Direct access not allowed!');

// account_create_auto_login
// ignore recaptcha when account has been just created
if (PAGE === 'account/create') {
	return;
}

$configRecaptcha = config('google_recaptcha');
if(getBoolean($configRecaptcha['enabled']))
{
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
