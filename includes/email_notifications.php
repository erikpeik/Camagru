<?php
require_once '../config/pdo.php';

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_POST['checked'])) {
	$checked = $_POST['checked'];

	if ($checked == 'true') {
		$checked = 1;
	} else {
		$checked = 0;
	}
	$sql = "UPDATE `users` SET `email_notification` = ? WHERE `users_id` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$checked, $_SESSION['user_id']]);
}
