<?php

include_once '../config/pdo.php';

session_start();
ob_start();

if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
}

if (isset($_POST['img'])) {
	$image = str_replace(' ', '+', $_POST['img']);
	// merge two images together
	$image = imagecreatefromstring(base64_decode($image));
	$sticker = imagecreatefrompng($_POST['sticker']);
	$image = imagecreatefrompng('../images/stickers/test_image.png');
	imagecopy($image, $sticker, 0, 0, 0, 0, imagesx($sticker), imagesy($sticker));

	$sql = "INSERT INTO `images` (`image_id`, `users_id`, `image`)
			VALUES (NULL, ?, ?);";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($_SESSION["user_id"], base64_encode($image)))) {
		$statement = null;
		header('location: ../camera.php?msg=error');
		exit();
	}
	print ($image);
}

