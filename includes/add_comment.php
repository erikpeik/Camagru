<?php

if (!isset($_SESSION)) {
	session_start();
}
require_once '../config/pdo.php';

if (isset($_POST['comment']) && isset($_POST['image_id'])) {
	$comment = $_POST['comment'];
	$image_id = $_POST['image_id'];
	$user_id = $_SESSION["user_id"];
	if (strlen($comment) > 280) {
		print("Comment too long!");
		exit();
	}

	try {
		$sql = "INSERT INTO `comments` (`users_id`, `image_id`, `comment`)
		VALUES (?, ?, ?);";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($user_id, $image_id, htmlspecialchars($comment)))) {
			$statement = null;
			header('location: ../index.php?msg=error');
			exit();
		}
		print("Comment added!");
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
}
