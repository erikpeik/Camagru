<?php

if (isset($_POST['password']) && isset($_POST['confirm_password']) &&
	isset($_POST['email']) && isset($_POST['code']) && isset($_POST['submit'])) {
	require_once "../config/pdo.php";

	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$submit = $_POST['submit'];
	$email = $_POST['email'];
	$code = $_POST['code'];

	if (empty($password) || empty($confirm_password) || empty($email) ||
		empty($code) || $submit != "Reset") {
		echo "1"; // Fields are empty
	}
	else if ($password != $confirm_password) {
		echo "2"; // Passwords do not match
	}
	else if (!preg_match("/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
		echo "3"; // Password is invalid
	}
	else {
		try {
			$sql = "SELECT * FROM `users`
					WHERE `users_email` = ? AND `activation_code` = ?";
			$statement = $pdo->prepare($sql);
			$statement->execute([$email, $code]);
			$user = $statement->fetch();
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			exit ();
		}
		if ($user) {
			if ($user['users_pwd'] == hash('whirlpool', $password)) {
				echo "6"; // New password is the same as the old password
				exit();
			}
			try {
				$sql = "UPDATE `users`
						SET `users_pwd` = ?, `activation_code` = ?
						WHERE `users_email` = ?";
				$statement = $pdo->prepare($sql);
				$hashed_password = hash('whirlpool', $password);
				$change_code = bin2hex(random_bytes(18));
				$statement->execute([$hashed_password, $change_code, $email]);
			} catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
				exit ();
			}
			echo "4"; // Password changed successfully
		} else {
			echo "5"; // Email or code is incorrect
		}
	}
} else {
	echo "0"; // Fields are missing
}
