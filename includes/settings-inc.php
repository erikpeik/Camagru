<?php

function check_username($pdo, $username) {
	$sql = "SELECT * FROM `users` WHERE `users_uid` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$username]);
	$result = $statement->fetchAll();
	return (count($result) > 0);
}

function new_email_verification($new_email, $user_info, $pdo) {
	require_once '../config/app.php';

	$hashed_activation = hash('whirlpool', $new_email);
	try {
		$sql = "UPDATE `users` SET `activation_code` = ? WHERE `users_id` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$hashed_activation, $user_info['users_id']]);
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	$link = "$APP_URL/auth?email=$new_email&activation_code=$hashed_activation";
	$subject = "Confirm your email address for Camagru";
	$message = file_get_contents('../mails/new_email.html');
	// $message = "Test!";
	$empty = array("%name%", "%email%", "%link%");
	$replace = array($user_info['users_uid'], $new_email, $link);
	$message = str_replace($empty, $replace, $message);
	$headers = array(
		'From' => 'admin@erikpeik.fi',
		'Reply-To' => 'admin@erikpeik.fi',
		'MIME-Version' => '1.0',
		'Content-type' => 'text/html; charset=iso-8859-1',
		'X-Mailer' => 'PHP/'.phpversion()
	);
	mail($new_mail, $subject, $message, $headers);
}

function email_taken($pdo, $email) {
	$sql = "SELECT * FROM `users` WHERE `users_email` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$email]);
	$result = $statement->fetchAll();
	return (count($result) > 0);
}

function mail_format($email) {
	return ((filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 255));
}
