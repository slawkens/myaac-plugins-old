<?php
defined('MYAAC') or die('Direct access not allowed!');

require_once __DIR__ . '/../init.php';

if(GoogleReCAPTCHA::enabled()) {
	global $logged;
	if ($logged) {
		return; // do not display when logged in
	}

	if ($this->_type == HOOK_ADMIN_HEAD_END) {
		echo '<script src="https://www.google.com/recaptcha/api.js' . (setting('google_recaptcha.type') == 'v3' ? '?render=' . setting('google_recaptcha.site_key') : '') . '"></script>';
	}
	else if($this->_type == HOOK_ADMIN_BODY_END) {
		$twig->display('google-recaptcha/templates/recaptcha-v3.html.twig', [
				'action' => (PAGE == 'account/create' ? 'register' : 'login')
			]
		);
	}
}
