<?php

return [
	'name' => 'Google ReCaptcha',
	'key' => 'google_recaptcha', // will be used with setting() function, must be unique for every setting
	'settings' =>
	[
		[
			'type' => 'section',
			'title' => 'Google reCAPTCHA (prevent spam bots)'
		],
		'enabled' => [
			'name' => 'Enable ReCaptcha',
			'type' => 'boolean',
			'desc' => 'Enable ReCaptcha on login and create account.<br/><a href="https://www.google.com/recaptcha" target="_blank">https://www.google.com/recaptcha</a>',
			'default' => true,
		],
		'type' => [
			'name' => 'ReCaptcha Version',
			'type' => 'options',
			'options' => ['v2-checkbox' => 'v2-checkbox', 'v2-invisible' => 'v2-invisible', 'v3' => 'v3'],
			'desc' => 'Type of ReCaptcha',
			'default' => 'v3',
			'show_if' => [
				'enabled', '=', 'true',
			]
		],
		'site_key' => [
			'name' => 'Site Key',
			'type' => 'text',
			'desc' => 'get your own site and secret keys at https://www.google.com/recaptcha',
			'default' => '',
			'show_if' => [
				'enabled', '=', 'true',
			]
		],
		'secret_key' => [
			'name' => 'Secret Key',
			'type' => 'text',
			'desc' => 'get your own site and secret keys at https://www.google.com/recaptcha',
			'default' => '',
			'show_if' => [
				'enabled', '=', 'true',
			]
		],
		'v2_theme' => [
			'name' => 'v2 Theme',
			'type' => 'options',
			'options' => ['light' => 'light', 'dark' => 'dark'],
			'desc' => 'This option apply only for type ReCaptcha v2-checkbox',
			'default' => 'light',
			'show_if' => [
				['enabled', '=', 'true'],
				['type', '=', 'v2-checkbox'],
			]
		],
		'v3_min_score' => [
			'name' => 'v3 Min Score',
			'type' => 'number',
			'min' => 0,
			'max' => 1.0,
			'step' => '.1',
			'desc' => 'This option apply only for ReCaptcha v3.<br/>Min score for validation, between 0 - 1.0<br/>https://developers.google.com/recaptcha/docs/v3#interpreting_the_score',
			'default' => 0.5,
			'show_if' => [
				['enabled', '=', 'true'],
				['type', '=', 'v3'],
			]
		],
	]
];
