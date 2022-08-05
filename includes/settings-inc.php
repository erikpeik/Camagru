<?php

function check_username($pdo, $username) {
	$sql = "SELECT * FROM `users` WHERE `users_uid` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$username]);
	$result = $statement->fetchAll();
	return (count($result) > 0);
}

function new_email_verification($new_email, $user_info, $pdo) {
	$hashed_activation = hash('whirlpool', $new_email);
	try {
		$sql = "UPDATE `users` SET `activation_code` = ? WHERE `users_id` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$hashed_activation, $user_info['users_id']]);
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
}

function email_taken($pdo, $email) {
	$sql = "SELECT * FROM `users` WHERE `users_email` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$email]);
	$result = $statement->fetchAll();
	return (count($result) > 0);
}
