<?php

include_once '../config/pdo.php';

session_start();
ob_start();

if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
}

if (isset($_POST['img']) && isset($_POST['sticker'])) {
	$image = $_POST['img'];
	$image = preg_replace("/data:image\/jpeg;base64,/", '', $image);
	$image = str_replace(' ', '+', $image);
	$image = base64_decode($image);

	$usr_img = imagecreatefromstring($image);

	$sticker = file_get_contents($_POST['sticker']);
#	imagecopyresized($resize_sticker, $sticker, 0, 0, 0, 0, imagesx($image), imagesy($image), imagesx($sticker), imagexy($sticker));
#	imagecopy($image, $resize_sticker, 0, 0, 0, 0, 640, 480);

#	$file = "../textpicture.jpeg";
#	$success = file_put_contents($file, $resize_sticker);

//	$sql = "INSERT INTO `images` (`image_id`, `users_id`, `image`)
//			VALUES (NULL, ?, ?);";
// 	$statement = $pdo->prepare($sql);
// 	if (!$statement->execute(array($_SESSION["user_id"], $image))) {
// 		$statement = null;
// 		header('location: ../camera.php?msg=error');
// 		exit();
// 	}
// 	print ($image);
}

