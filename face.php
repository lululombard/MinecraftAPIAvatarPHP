<?php
$size = isset($_GET['s']) ? max(8, min(250, $_GET['s'])) : 48;
$user = isset($_GET['u']) ? $_GET['u'] : '';

require_once 'common.php';

$im = get_skin($user);
$av = imagecreatetruecolor($size, $size);
imagecopyresized($av, $im, 0, 0, 8, 8, $size, $size, 8, 8);		// Face
imagecolortransparent($im, imagecolorat($im, 63, 0));		// Black Hat Issue
imagecopyresized($av, $im, 0, 0, 40, 8, $size, $size, 8, 8);		// Accessories
header('Content-type: image/png');
imagepng($av);
imagedestroy($im);
imagedestroy($av);