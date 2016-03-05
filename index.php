<?php
$size = isset($_GET['s']) ? max(16, min(800, $_GET['s'])) : 250;
$user = isset($_GET['u']) ? preg_replace("/[^a-zA-Z0-9_]+/", "",$_GET['u']) : '';

require_once 'common.php';

$im = get_skin($user);

while (($size / 16) != floor($size / 16)) $size++;

$s = $size / 16;
$h = floor($size * 2);

$av = imagecreatetruecolor($size, $h);
imagesavealpha($av, true);
imagefill($av, 0, 0, imagecolorallocatealpha($av, 0, 0, 0, 127));

if (imagesy($im) > 32) {
	// 1.8+ Skin
	if ((imagecolorat($im, 54, 20) >> 24) & 0x7F == 127) {
		// Alex Style Skin (3px Arm Width)
		// Front
		imagecopyresized($av, $im, $s * 4, 0, 8, 8, $s * 8, $s * 8, 8, 8);
		imagecopyresized($av, $im, $s * 4, $s * 8, 20, 20, $s * 8, $s * 12, 8, 12);
		imagecopyresized($av, $im, $s * 1, $s * 8, 44, 20, $s * 3, $s * 12, 3, 12);
		imagecopyresized($av, $im, $s * 12, $s * 8, 36, 52, $s * 3, $s * 12, 3, 12);
		imagecopyresized($av, $im, $s * 4, $s * 8 + $s * 12, 4, 20, $s * 4, $s * 12, 4, 12);
		imagecopyresized($av, $im, $s * 8, $s * 8 + $s * 12, 20, 52, $s * 4, $s * 12, 4, 12);

		// Black Hat Issue
		imagecolortransparent($im, imagecolorat($im, 63, 0));

		// Face Accessories
		imagecopyresized($av, $im, $s * 4, 0, 40, 8, $s * 8, $s * 8, 8, 8);
	
		// Body Accessories
		imagecopyresized($av, $im, $s * 4, $s * 8, 20, 36, $s * 8, $s * 12, 8, 12);
	
		// Arm Accessores
		imagecopyresized($av, $im, $s * 1, $s * 8, 44, 36, $s * 3, $s * 12, 3, 12);
		imagecopyresized($av, $im, $s * 12, $s * 8, 52, 52, $s * 3, $s * 12, 3, 12);
	
		// Leg Accessores
		imagecopyresized($av, $im, $s * 4, $s * 8 + $s * 12, 4, 36, $s * 4, $s * 12, 4, 12);
		imagecopyresized($av, $im, $s * 8, $s * 8 + $s * 12, 4, 52, $s * 4, $s * 12, 4, 12);
	} else {
		// Steve Style Skin (4px Arm Width)
		// Front
		imagecopyresized($av, $im, $s * 4, 0, 8, 8, $s * 8, $s * 8, 8, 8);
		imagecopyresized($av, $im, $s * 4, $s * 8, 20, 20, $s * 8, $s * 12, 8, 12);
		imagecopyresized($av, $im, 0, $s * 8, 44, 20, $s * 4, $s * 12, 4, 12);
		imagecopyresized($av, $im, $s * 12, $s * 8, 36, 52, $s * 4, $s * 12, 4, 12);
		imagecopyresized($av, $im, $s * 4, $s * 8 + $s * 12, 4, 20, $s * 4, $s * 12, 4, 12);
		imagecopyresized($av, $im, $s * 8, $s * 8 + $s * 12, 20, 52, $s * 4, $s * 12, 4, 12);

		// Black Hat Issue
		imagecolortransparent($im, imagecolorat($im, 63, 0));

		// Face Accessories
		imagecopyresized($av, $im, $s * 4, 0, 40, 8, $s * 8, $s * 8, 8, 8);

		// Body Accessories
		imagecopyresized($av, $im, $s * 4, $s * 8, 20, 36, $s * 8, $s * 12, 8, 12);

		// Arm Accessores
		imagecopyresized($av, $im, 0, $s * 8, 44, 36, $s * 4, $s * 12, 4, 12);
		imagecopyresized($av, $im, $s * 12, $s * 8, 52, 52, $s * 4, $s * 12, 4, 12);

		// Leg Accessores
		imagecopyresized($av, $im, $s * 4, $s * 8 + $s * 12, 4, 36, $s * 4, $s * 12, 4, 12);
		imagecopyresized($av, $im, $s * 8, $s * 8 + $s * 12, 4, 52, $s * 4, $s * 12, 4, 12);
	}
} else {
	$mi = imagecreatetruecolor(64, 32);
	imagecopyresampled($mi, $im, 0, 0, 64 - 1, 0, 64, 32, -64, 32);
	imagesavealpha($mi, true);
	imagefill($mi, 0, 0, imagecolorallocatealpha($mi, 0, 0, 0, 127));
	
	// Front
	imagecopyresized($av, $im, $s * 4, 0, 8, 8, $s * 8, $s * 8, 8, 8);
	imagecopyresized($av, $im, $s * 4, $s * 8, 20, 20, $s * 8, $s * 12, 8, 12);
	imagecopyresized($av, $im, 0, $s * 8, 44, 20, $s * 4, $s * 12, 4, 12);
	imagecopyresized($av, $mi, $s * 12, $s * 8, 16, 20, $s * 4, $s * 12, 4, 12);
	imagecopyresized($av, $im, $s * 4, $s * 8 + $s * 12, 4, 20, $s * 4, $s * 12, 4, 12);
	imagecopyresized($av, $mi, $s * 8, $s * 8 + $s * 12, 56, 20, $s * 4, $s * 12, 4, 12);

	// Black Hat Issue
	imagecolortransparent($im, imagecolorat($im, 63, 0));

	// Accessories
	imagecopyresized($av, $im, $s * 4, 0, 40, 8, $s * 8, $s * 8, 8, 8);
	
	imagedestroy($mi);
}

header('Content-type: image/png');
imagepng($av);
imagedestroy($im);
imagedestroy($av);