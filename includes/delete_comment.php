<?php

if (!isset($_SESSION)) {
	session_start();
}
include_once '../config/pdo.php';

if (isset($_POST['image_id']) && isset($_POST['comment_id']) && isset($_SESSION['user_id'])) {
	$image_id = $_POST['image_id'];
	$user_id = $_SESSION['user_id'];
	$comment_id = $_POST['comment_id'];

	try {
		$sql = "DELETE FROM comments WHERE comment_id = ? AND users_id = ? AND image_id = ?";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($comment_id, $user_id, $image_id))) {
			echo 'Statement error';
			exit();
		}
	}
	catch (PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit();
	}
	echo 'Comment deleted';
} else {
	echo 'Missing variables';
}
