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

function fetch_page($pdo, $page, $row_count) {
	$offset = ($page - 1) * $row_count;
	try {
		$sql = "SELECT `images`.*, `users`.`users_name`, `users`.`users_uid`
				FROM `images`
				LEFT JOIN `users`
				ON `images`.`users_id` = `users`.`users_id`
				ORDER BY `images`.`image_id` DESC
				LIMIT :row_count OFFSET :offset;";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(':row_count', $row_count, PDO::PARAM_INT);
		$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
		if (!$statement->execute()) {
			$statement = null;
			header('location: ../index.php?msg=error');
			exit();
		}
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $data;
}

function image_count($pdo) {
	try {
		$sql = "SELECT COUNT(*) as `count` FROM `images`";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute()) {
			$statement = null;
			header('location: ../index.php?msg=error');
			exit();
		}
		$data = $statement->fetch(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $data['count'];
}
