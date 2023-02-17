<?php
defined('MYAAC') or die('Direct access not allowed!');

$configRecaptcha = config('google_recaptcha');
if(getBoolean($configRecaptcha['enabled'])) {
	if ($this->_type == HOOK_ADMIN_HEAD_END) {
		echo '<script src="https://www.google.com/recaptcha/api.js' . ($configRecaptcha['type'] == 'v3' ? 'render=' . config('recaptcha_site_key') : '') . '"></script>';
	}
	else if($this->_type == HOOK_ADMIN_BODY_END) {
		$twig->display('google-recaptcha/templates/recaptcha-v3.html.twig', [
				'action' => (PAGE == 'account/create' ? 'register' : 'login')
			]
		);
	}
}
