<?php

function resize_image_crop($image, $width, $height) {
	$w = imagesx($image);
	$h = imagesy($image);
	if (($w == $width) && ($h == $height)) {
		// No resizing needed
		return $image;
	}

	// Trying max widht first...
	$ratio = $width / $w;
	$new_w = $width;
	$new_h = $h * $ratio;

	// If new height is smaller then required height, try other way
	if ($new_h < $height) {
		$ratio = $height / $h;
		$new_h = $height;
		$new_w = $w * $ratio;
	}

	// Create a new temporary image
	$image2 = imagecreatetruecolor($new_w, $new_h);
	imagecopyresampled($image2, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);

	// check if cropping needs to happen
	if (($new_h != $height) || ($new_w != $width)) {
		$image3 = imagecreatetruecolor($width, $height);
		if ($new_h > $height) { // vertical crop
			$x = 0;
			$y = round(($new_h - $height) / 2);
		} else { // horizontal crop
			$x = round(($new_w - $width) / 2);
			$y = 0;
		}
		imagecopyresampled($image3, $image2, 0, 0, $x, $y, $width, $height, $width, $height);
		imagedestroy($image2);
		return $image3;
	} else {
		return $image2;
	}
}

if (isset($_FILES['file'])) {
	$image_file_type = strtolower(end(explode('.', $_FILES['file']['name'])));
	$extensions = array('jpg', 'jpeg', 'png');
	$errors = array();

	if (in_array($image_file_type, $extensions) === false) {
		echo "Error: Extension not allowed, please choose a JPEG or PNG file.";
		exit ;
	}

	$check = getimagesize($_FILES['file']['tmp_name']);
	if ($check === false) {
		echo "Error: File is not an image.";
		exit ;
	}

	if ($_FILES['file']['size'] > 5242880) {
		echo "Error: File is too large. File cannot be larger than 5 MB.";
		exit ;
	}

	$file = file_get_contents($_FILES['file']['tmp_name']);
	if ($file === false) {
		echo "Error: File could not be read.";
		exit ;
	}

	$image = imagecreatefromstring($file);
	if ($image === false) {
		echo "Error: Creating image from string failed.";
		exit ;
	}

	$resized = resize_image_crop($image, 640, 480);

	ob_start();
	imagepng($resized);
	$data = ob_get_clean();

	print (base64_encode($data));
}
