<?php

include_once '../config/pdo.php';

session_start();

ob_start();
if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
}
ob_get_clean();

if (isset($_POST['img']) && isset($_POST['sticker'])) {
	$image = $_POST['img'];
	$image = preg_replace("/data:image\/jpeg;base64,/", '', $image);
	$image = str_replace(' ', '+', $image);
	$image = base64_decode($image);
	$image = imagecreatefromstring($image);

	$sticker = file_get_contents($_POST['sticker']);
	$sticker = imagecreatefromstring($sticker);
	$sticker = imagescale($sticker, $_POST['width'], $_POST['height']);

	$top = str_replace("px", '', $_POST['top']);
	$left = str_replace("px", '', $_POST['left']);
	imagecopy($image, $sticker, $left, $top, 0, 0, $_POST['width'], $_POST['height']);

	$file = "../textpicture.jpeg";
	ob_start();
	imagepng($image);
	$data = ob_get_clean();
	$success = file_put_contents($file, $data);
//	$image = base64_encode($data);
	$sql = "INSERT INTO `images` (`image_id`, `users_id`, `image`)
			VALUES (NULL, ?, ?);";
 	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($_SESSION["user_id"], $data))) {
		$statement = null;
		header('location: ../camera.php?msg=error');
		exit();
	}
 	print (base64_encode($data));
}

