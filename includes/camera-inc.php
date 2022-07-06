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

	ob_start();
	imagepng($image);
	$data = ob_get_clean();
 	print (base64_encode($data));
}

