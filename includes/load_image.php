<?php

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
	// move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name']);
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
	$resized = imagecreatetruecolor(640, 480);
	if (imagecopyresampled($resized, $image, 0, 0, 0, 0, 640, 480, imagesx($image), imagesy($image)) == false) {
		echo "Error: Resampling image failed.";
		exit ;
	}
	ob_start();
	imagepng($resized);
	$data = ob_get_clean();
	print (base64_encode($data));
}
