<?php

session_start();
ob_start();

function check_if_user_liked_picture($pdo, $image_id) {
	$sql = "SELECT COUNT(*) as `count` FROM `likes` WHERE `users_id` = ? AND `image_id` = ?";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($_SESSION["user_id"], $image_id))) {
		$statement = null;
		header('location: ../index.php?msg=error');
		exit();
	}
	$data = $statement->fetch(PDO::FETCH_ASSOC);
	$like_count = $data['count'];
	return $like_count;
}

function get_image_likes($pdo, $image_id) {
	$sql = "SELECT COUNT(*) as `count` FROM `likes` WHERE `image_id` = ?";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($image_id))) {
		$statement = null;
		header('location: ../index.php?msg=error');
		exit();
	}
	$data = $statement->fetch(PDO::FETCH_ASSOC);
	return $data;
}

function fetch_all_image_data($pdo) {
	$sql = "SELECT `images`.*, `users`.`users_name`, `users`.`users_uid`
			FROM `images`
			LEFT JOIN `users`
			ON `images`.`users_id` = `users`.`users_id`
			ORDER BY `images`.`image_id` DESC;";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute()) {
		$statement = null;
		header('location: ../index.php?msg=statement_failed');
		exit();
	}
	$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $data;
}
