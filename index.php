<?php
$size = isset($_GET['s']) ? max(16, min(800, $_GET['s'])) : 250;
$user = isset($_GET['u']) ? preg_replace("/[^a-zA-Z0-9_]+/", "",$_GET['u']) : '';

$cache_dir = 'cache_skins';

if (!file_exists($cache_dir)) mkdir($cache_dir, 0775, true);

function get_skin($user) {
	global $cache_dir;
	$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAFDUlEQVR42u2a20sUURzH97G0LKMotPuWbVpslj1olJXdjCgyisowsSjzgrB0gSKyC5UF1ZNQWEEQSBQ9dHsIe+zJ/+nXfM/sb/rN4ZwZ96LOrnPgyxzP/M7Z+X7OZc96JpEISfWrFhK0YcU8knlozeJKunE4HahEqSc2nF6zSEkCgGCyb+82enyqybtCZQWAzdfVVFgBJJNJn1BWFgC49/VpwGVlD0CaxQiA5HSYEwBM5sMAdKTqygcAG9+8coHKY/XXAZhUNgDYuBSPjJL/GkzVVhAEU5tqK5XZ7cnFtHWtq/TahdSw2l0HUisr1UKIWJQBAMehDuqiDdzndsP2EZECAG1ZXaWMwOCODdXqysLf++uXUGv9MhUHIByDOijjdiSAoH3ErANQD73C7TXXuGOsFj1d4YH4OTJAEy8y9Hd0mCaeZ5z8dfp88zw1bVyiYhCLOg1ZeAqC0ybaDttHRGME1DhDeVWV26u17lRAPr2+mj7dvULfHw2q65fhQRrLXKDfIxkau3ZMCTGIRR3URR5toU38HbaPiMwUcKfBAkoun09PzrbQ2KWD1JJaqswjdeweoR93rirzyCMBCmIQizqoizZkm2H7iOgAcHrMHbbV9KijkUYv7qOn55sdc4fo250e+vUg4329/Xk6QB/6DtOws+dHDGJRB3XRBve+XARt+4hIrAF4UAzbnrY0ve07QW8uHfB+0LzqanMM7qVb+3f69LJrD90/1axiEIs6qIs21BTIToewfcSsA+Bfb2x67OoR1aPPzu2i60fSNHRwCw221Suz0O3jO+jh6V1KyCMGse9721XdN5ePutdsewxS30cwuMjtC860T5JUKpXyKbSByUn7psi5l+juDlZYGh9324GcPKbkycaN3jUSAGxb46IAYPNZzW0AzgiQ5tVnzLUpUDCAbakMQXXrOtX1UMtHn+Q9/X5L4wgl7t37r85OSrx+TYl379SCia9KXjxRpiTjIZTBFOvrV1f8ty2eY/T7XJ81FQAwmA8ASH1ob68r5PnBsxA88/xAMh6SpqW4HRnLBrkOA9Xv5wPAZjAUgOkB+SHxgBgR0qSMh0zmZRsmwDJm1gFg2PMDIC8/nAHIMls8x8GgzOsG5WiaqREgYzDvpTwjLDy8NM15LpexDEA3LepjU8Z64my+8PtDCmUyRr+fFwA2J0eAFYA0AxgSgMmYBMZTwFQnO9RNAEaHOj2DXF5UADmvAToA2ftyxZYA5BqgmZZApDkdAK4mAKo8GzPlr8G8AehzMAyA/i1girUA0HtYB2CaIkUBEHQ/cBHSvwF0AKZFS5M0ZwMQtEaEAmhtbSUoDADH9ff3++QZ4o0I957e+zYAMt6wHkhzpjkuAcgpwNcpA7AZDLsvpwiuOkBvxygA6Bsvb0HlaeKIF2EbADZpGiGzBsA0gnwQHGOhW2snRpbpPexbAB2Z1oicAMQpTnGKU5ziFKc4xSlOcYpTnOIUpzgVmgo+XC324WfJAdDO/+ceADkCpuMFiFKbApEHkOv7BfzfXt+5gpT8V7rpfYJcDz+jAsB233r6yyBsJ0mlBCDofuBJkel4vOwBFPv8fyYAFPJ+wbSf/88UANNRVy4Awo6+Ig2gkCmgA5DHWjoA+X7AlM//owLANkX0w0359od++pvX8fdMAcj3/QJ9iJsAFPQCxHSnQt8vMJ3v2wCYpkhkAOR7vG7q4aCXoMoSgG8hFAuc/grMdAD4B/kHl9da7Ne9AAAAAElFTkSuQmCC';
	$output = imagecreatefromstring(base64_decode($output));
	if ($user != '') {
		$filename = $cache_dir.'/'.$user.'.png';
		if (file_exists($filename) && ((filemtime($filename)+3600) > time())) {
			$output = imagecreatefromstring(file_get_contents($filename));
		}
		$ch = curl_init('http://skins.minecraft.net/MinecraftSkins/' . $user . '.png');
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($status == 301) {
			preg_match('/location:(.*)/i', $result, $matches);
			curl_setopt($ch, CURLOPT_URL, trim($matches[1]));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_NOBODY, 0);
			$result = curl_exec($ch);
			$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($status == 200) {
				file_put_contents($filename, $result);
				$output = imagecreatefromstring($result);
			}
			else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
		}
		else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
		curl_close($ch);
	}
	return $output;
}

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
