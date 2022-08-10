<?php

if (!isset($_SESSION)) {
	session_start();
}


if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != -1) {
	require_once '../config/pdo.php';
	try {
		$sql = "DELETE FROM `comments` WHERE `users_id` = ?;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id']]);

		$sql = "DELETE FROM `likes` WHERE `users_id` = ?;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id']]);

		$sql = "DELETE FROM `images` WHERE `users_id` = ?;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id']]);

		$sql = "DELETE FROM `users` WHERE `users_id` = ?;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id']]);

		unset($_SESSION['user_id']);
		unset($_SESSION['user_uid']);

	} catch (PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
	print ("1");
}
else {
	print ("0");
}
