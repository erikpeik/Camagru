<?php

if (!isset($_SESSION)) {
	session_start();
}

include_once '../config/pdo.php';

if (isset($_POST['caption']) && isset($_POST['submit']) && isset($_POST['image'])) {
	$caption = $_POST['caption'];
	$submit = $_POST['submit'];
	if ($submit == 'submit') {
		$image = str_replace(' ', '+', $_POST['image']);
		$image = base64_decode($image);
		try {
			$sql = "INSERT INTO `images` (`image_id`, `users_id`, `image`, `caption`)
			VALUES (NULL, ?, ?, ?);";
			$statement = $pdo->prepare($sql);
			if (!$statement->execute(array($_SESSION["user_id"], $image, htmlspecialchars($caption)))) {
				$statement = null;
				print("Statement failed");
				exit();
			}
			print("Image added to database");
		}
		catch (PDOException $e) {
			print("Error!!: " . $e->getMessage() . "<br/>");
		}
	}
	else {
		print("Error: submit button not pressed");
	}
}
else {
	print("Information missing");
}
