<?php

if (!isset($_SESSION)) {
	session_start();
}

function get_user_info($pdo, $username) {
	try {
		$sql = "SELECT `users_id`, `users_name`, `users_uid`, `users_email`,
		`profile_picture`, `created_at` FROM `users` WHERE `users_uid` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$username]);
		$fetch = $statement->fetch();
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	if ($fetch == false) {
		return false;
	}
	return $fetch;
}

function get_users_images($pdo, $users_id) {
	try {
		$sql = "SELECT * FROM `images` WHERE `users_id` = ? ORDER BY `posted_at` DESC";
		$statement = $pdo->prepare($sql);
		$statement->execute([$users_id]);
		$fetch = $statement->fetchAll();
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	if ($fetch == false) {
		return false;
	}
	return $fetch;
}

function get_users_likes($pdo, $users_id) {
	try {
		$sql = "SELECT * FROM `likes` WHERE `users_id` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$users_id]);
		$fetch = $statement->fetchAll();
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	if ($fetch == false) {
		return false;
	}
	return count($fetch);
}
