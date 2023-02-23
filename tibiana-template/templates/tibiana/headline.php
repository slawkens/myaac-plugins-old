<?php
$text = $_GET['t'];
if(strlen($text) > 100) // max limit
	$text = '';

// set font path
putenv('GDFONTPATH=' . __DIR__);

// create image
//$image = imagecreatetruecolor(250, 28);
$image = imagecreatefrompng(__DIR__ . '/images/top_header-empty.png');

// make the background transparent
//imagecolortransparent($image, imagecolorallocate($image, 0, 0, 0));

// set text
$font = getenv('GDFONTPATH') . DIRECTORY_SEPARATOR . 'martel.ttf';
imagettftext($image, 16, 0, 40, 20, imagecolorallocate($image, 240, 209, 164), $font, utf8_decode($text));

// header mime type
header('Content-type: image/png');

// output image to browser
imagepng($image);
