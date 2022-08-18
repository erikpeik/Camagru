<?php

require_once 'resize_image_crop.php';

if (isset($_FILES['file']) && isset($_FILES['file']['name']) && isset($_POST['orientation'])) {
	$file_type = explode('.', $_FILES['file']['name']);
	$last_element = end($file_type);
	$image_file_type = strtolower($last_element);
	$extensions = array('jpg', 'jpeg', 'png');

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

	if ($_POST['orientation'] == "landscape") {
		$resized = resize_image_crop($image, 640, 480);
	} else {
		$resized = resize_image_crop($image, 480, 640);
	}
	ob_start();
	imagepng($resized);
	$data = ob_get_clean();

	print (base64_encode($data));
} else {
	echo "Error: No file selected.";
}
