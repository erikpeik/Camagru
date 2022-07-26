<?php

include_once '../config/pdo.php';

if (isset($_POST['img']) && isset($_POST['stickers'])) {
	$image = $_POST['img'];
	$image = preg_replace("/data:image\/jpeg;base64,/", '', $image);
	$image = str_replace(' ', '+', $image);
	$image = base64_decode($image);
	$image = imagecreatefromstring($image);

	$stickers = $_POST['stickers'];
	if ($stickers) {
		$stickers = explode(',', $stickers);
		foreach($stickers as $nbr) {
			$path = "../images/stickers/$nbr.png";
			$sticker = file_get_contents($path);
			if ($sticker === false) {
				print("file error: $nbr<br>".$path."<br>");
				exit();
			}
			$sticker = imagecreatefromstring($sticker);
			if ($sticker === false) {
				print("image creating error: $nbr");
				exit();
			}
			if (!isset($_POST["sticker_$nbr"])) {
				print("sticker error: $nbr");
				exit();
			}
			$stats = $_POST["sticker_$nbr"];
			$stats = explode(',', $stats);

			$width = $stats[2];
			$height = $stats[3];
			$sticker = imagescale($sticker, $width, $height);

			$top = str_replace("px", "", $stats[1]);
			$left = str_replace("px", "", $stats[0]);
			imagecopy($image, $sticker, $left, $top, 0, 0, $width, $height);
		}
	}
	ob_start();
	imagepng($image);
	$data = ob_get_clean();
	print (base64_encode($data));
}

