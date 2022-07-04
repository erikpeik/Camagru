<?php

include_once '../config/pdo.php';
session_start();
ob_start();

if (isset($_POST['caption']) && isset($_POST['submit']) && isset($_POST['image'])) {
	$caption = $_POST['caption'];
	$submit = $_POST['submit'];
//	print($_POST['image']);
	if ($submit == 'submit') {
		$image = base64_decode($_POST['image']);
		try {
			$sql = "INSERT INTO `images` (`image_id`, `users_id`, `image`, `caption`)
			VALUES (NULL, ?, ?, ?);";
			$statement = $pdo->prepare($sql);
			if (!$statement->execute(array($_SESSION["user_id"], $image, htmlspecialchars($caption)))) {
				$statement = null;
				header('location: ../camera.php?msg=error');
				exit();
			}
			print("Image added to database");
		}
		catch (PDOException $e) {
			print("Error!!: " . $e->getMessage() . "<br/>");
		}
		header('location: ../camera.php?msg=image_added');
	}
	else {
		header('location: ../camera.php');
	}
}
else {
	header('location: ../camera.php?msg=information_missing');
}
