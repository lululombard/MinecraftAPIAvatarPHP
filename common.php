<?php
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
		$ch = curl_init('https://api.mojang.com/users/profiles/minecraft/' . $user);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($status == 200) {
			$json = json_decode($result, true);
			if (isset($json['id'])) {
				$uuid = $json['id'];
				curl_setopt($ch, CURLOPT_URL, 'https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($status == 200) {
					$json = json_decode($result, true);
					if (isset($json['properties'])) {
						$properties = $json['properties'];
						foreach ($properties as $property) {
							if (isset($property['name']) && $property['name'] == 'textures') {
								$texture = json_decode(base64_decode($property['value']), true);
								if (isset($texture['textures']['SKIN']['url'])) {
									$skinurl = $texture['textures']['SKIN']['url'];
									curl_setopt($ch, CURLOPT_URL, $skinurl);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									$result = curl_exec($ch);
									$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
									if ($status == 200) {
										file_put_contents($filename, $result);
										$output = imagecreatefromstring($result);
										return $output;
									}
									else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
								}
								else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
							}
						}
						if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
					}
					else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
				}
				else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
			}
			else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));	
		}
		else if (file_exists($filename)) $output = imagecreatefromstring(file_get_contents($filename));
		curl_close($ch);
	}
	return $output;
}

if (isset($_GET['raw'])) {
	$user = isset($_GET['raw']) ? preg_replace("/[^a-zA-Z0-9_]+/", "",$_GET['raw']) : '';
	$im = get_skin($user);
	header('Content-type: image/png');
	imagecolortransparent($im, imagecolorat($im, 63, 0));
	imagepng($im);
	imagedestroy($im);
}
