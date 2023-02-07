<?php

// Google reCAPTCHA (prevent spam bots)

return [
	'enabled' => 'no', // enable recaptcha verification code
	'type' => 'v3', // 'v2-checkbox', 'v2-invisible', 'v3'

	// get your own site and secret keys at https://www.google.com/recaptcha
	'site_key' => '',
	'secret_key' => '',

	// following option apply only for ReCaptcha v2-checkbox
	'v2_theme' => 'light', // light, dark

	// following option apply only for ReCaptcha v3
	// min score for validation, between 0 - 1.0
	// https://developers.google.com/recaptcha/docs/v3#interpreting_the_score
	'v3_min_score' => 0.5,
];
