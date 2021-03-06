<?php

session_start();
ob_start();

include_once '../config/pdo.php';

if (isset($_POST["image_id"]) & isset($_SESSION["user_id"])) {
	$image_id = $_POST["image_id"];
	$user_id = $_SESSION["user_id"];

	try {
		$sql = "SELECT COUNT(*) as `count` FROM `likes` WHERE `users_id` = ? AND `image_id` = ?";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($user_id, $image_id))) {
			$statement = null;
			header('location: ../index.php?msg=error');
			exit();
		}
		$data = $statement->fetch(PDO::FETCH_ASSOC);
		$like_count = $data['count'];
		print($like_count);

		if ($like_count == 0) {
			$sql = "INSERT INTO `likes` (`users_id`, `image_id`) VALUES (?, ?)";
		}
		else {
			$sql = "DELETE FROM `likes` WHERE `users_id` = ? AND `image_id` = ?";
		}
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($user_id, $image_id))) {
			$statement = null;
			header('location: ../index.php?msg=error');
			exit();
		}
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
}
