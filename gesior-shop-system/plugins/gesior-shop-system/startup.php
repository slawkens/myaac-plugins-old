<?php

$currentURL = $_SERVER['REQUEST_URI'];

// example URL
// /?tx=1FY716081B1733348&st=Completed&amt=0.10&cc=USD&cm=1&item_number=&item_name=ots%20donation
$toBeFound = ['&st=', '&amt=', '&cc=', '&item_number=', '&item_name='];
$foundCount = 0;

foreach ($toBeFound as $find) {
	if(strpos($currentURL, $find) !== false) {
		$foundCount++;
	}
}

// example URL
// /?PayerID=CLPET73SVP2AL
$sandboxToBeFound = 'PayerID=';
$sandboxFound = false;
if(strpos($currentURL, $sandboxToBeFound) !== false) {
	$sandboxFound = true;
}

// Redirect if we find pattern (example URL pointed above is currently visited)
if($foundCount === count($toBeFound) || $sandboxFound) {
	header("Location: " . BASE_URL . 'gifts');
	exit;
}
