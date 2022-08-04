<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once '../config/pdo.php';
require_once 'profile-inc.php';

if (!isset($_SESSION['user_uid'])) {
	print("Error! User not logged in.");
	exit ();
}
$user_info = get_user_info($pdo, $_SESSION['user_uid']);
$users_images = get_users_images($pdo, $user_info['users_id']);

$stats = "";

if (isset($_POST["name"]) && $user_info['users_name'] != $_POST["name"]) {
	try {
		$sql = "UPDATE `users` SET `users_name` = ? WHERE `users_id` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$_POST["name"], $user_info['users_id']]);
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	$stats .= "1,";
} else {
	$stats .= "0,";
}

if (isset($_POST['username']) && $user_info['users_uid'] != $_POST['username']) {
	try {
		$sql = "UPDATE `users` SET `users_uid` = ? WHERE `users_id` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$_POST['username'], $user_info['users_id']]);
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	$_SESSION['user_uid'] = $_POST['username'];
	$stats .= "1";
} else {
	$stats .= "0";
}

print($stats);
