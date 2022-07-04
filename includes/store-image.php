<?php

include_once '../config/pdo.php';
session_start();

if (isset($_POST['title']) && isset($_POST['description'])
&& isset($_POST['submit']) && isset($_POST['image'])) {
	$title = $_POST['title'];
	$desc = $_POST['description'];
	$submit = $_POST['submit'];
//	print($_POST['image']);
	if ($submit == 'submit') {
		$image = base64_decode($_POST['image']);
		try {
			$sql = "INSERT INTO `images` (`image_id`, `users_id`, `image`, `title`, `description`)
			VALUES (NULL, ?, ?, ?, ?);";
			$statement = $pdo->prepare($sql);
			if (!$statement->execute(array($_SESSION["user_id"], $image, htmlspecialchars($title), htmlspecialchars($desc)))) {
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
