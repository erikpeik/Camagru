<?php

include_once '../config/pdo.php';

$post_id = $_POST['post_id'];
$type = $_POST['type'];

try {
	$sql = "SELECT COUNT(*) as `like_count` FROM `likes` WHERE `post_id` = ? AND `type` = ?";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($post_id, $type))) {
		$statement = null;
		header('location: ../index.php?msg=error');
		exit();
	}
	$data = $statement->fetch(PDO::FETCH_ASSOC);
	$like_count = $data['like_count'];

	if ($like_count == 0) {
		$insertquery = "INSERT INTO `likes` (`users_id`, `post_id`, `type`) VALUES (?, ?, ?)";
	}

}
catch (PDOException $e) {
	print("Error!: " . $e->getMessage() . "<br/>");
}
