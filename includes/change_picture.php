<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once 'resize_image_crop.php';
require_once '../config/pdo.php';

if (isset($_FILES['file']) && isset($_FILES['file']['name']) && isset($_SESSION['user_id'])) {
	$image = $_FILES['file'];
	$file_type = explode('.', $image['name']);
	$last_element = end($file_type);
	$image_file_type = strtolower($last_element);
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

	$resized = resize_image_crop($image, 500, 500);
	ob_start();
	imagepng($resized);
	$data = ob_get_clean();

	try {
		$sql = "UPDATE `users` SET `profile_picture` = ? WHERE users_id = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute(array(base64_encode($data), $_SESSION['user_id']));
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	print (base64_encode($data));
}
