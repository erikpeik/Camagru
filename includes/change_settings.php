<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once '../config/pdo.php';
require_once 'profile-inc.php';
require_once 'settings-inc.php';

if (!isset($_SESSION['user_uid'])) {
	print("Error! User not logged in.");
	exit ();
}
$user_info = get_user_info($pdo, $_SESSION['user_uid']);
$users_images = get_users_images($pdo, $user_info['users_id']);

$stats = "";

if (isset($_POST["name"]) && $user_info['users_name'] != $_POST["name"]) {
	if (check_full_name($_POST["name"]) == false) {
		$stats .= "2,";
	} else if (name_too_long($_POST['name']) == false) {
		$stats .= '3,';
	} else {
		try {
			$sql = "UPDATE `users` SET `users_name` = ? WHERE `users_id` = ?";
			$statement = $pdo->prepare($sql);
			$statement->execute([$_POST["name"], $user_info['users_id']]);
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
			exit ();
		}
		$stats .= "1,";
	}
} else {
	$stats .= "0,";
}

if (isset($_POST["username"]) && $user_info['users_uid'] != $_POST["username"]) {
	if (invalid_username($_POST['username']) == false) {
		$stats .= "3,";
	} else if (check_username($pdo, $_POST['username'])) {
		$stats .= "2,";
	} else {
		try {
			$sql = "UPDATE `users` SET `users_uid` = ? WHERE `users_id` = ?";
			$statement = $pdo->prepare($sql);
			$statement->execute([$_POST['username'], $user_info['users_id']]);
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
			exit ();
		}
		$_SESSION['user_uid'] = $_POST['username'];
		$stats .= "1,";
	}
} else {
	$stats .= "0,";
}

if (isset($_POST["email"]) && $user_info["users_email"] != $_POST["email"]) {
	if (email_taken($pdo, $_POST["email"])) {
		$stats .= "2";
	} else if (mail_format($_POST["email"]) == false) {
		$stats .= "3";
	} else {
		new_email_verification($_POST["email"], $user_info, $pdo);
		$stats .= "1";
	}
} else {
	$stats .= "0";
}

print($stats);
