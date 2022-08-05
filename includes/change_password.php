<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once '../config/pdo.php';

function get_user_password($pdo) {
	try {
		$sql = "SELECT `users_pwd` FROM `users` WHERE `users_id` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$_SESSION['user_id']]);
		$fetch = $statement->fetch();
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	return $fetch['users_pwd'];
}

if (isset($_POST['old_password']) &&
isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];
	$confirm_password = $_POST['confirm_password'];

	if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
		echo "1"; // Fields are empty
	}
	else if ($new_password != $confirm_password) {
		echo "2"; // Passwords do not match
	}
	else if (!preg_match("/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*$/", $new_password)) {
		echo "3"; // Password is invalid
	}
	else {
		$password = get_user_password($pdo);
		if (hash('whirlpool', $old_password) != $password) {
			echo "4"; // Old password is incorrect
		}
		else if (hash('whirlpool', $new_password) == $password) {
			echo "6"; // New password is the same as the old password
		}
		else {
			$sql = "UPDATE `users` SET `users_pwd` = ? WHERE `users_id` = ?";
			$statement = $pdo->prepare($sql);
			$statement->execute([hash('whirlpool', $new_password), $_SESSION['user_id']]);
			echo "5"; // Password changed successfully
		}
	}
} else {
	echo "0"; // Fields are missing
}
