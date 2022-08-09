<?php

function send_password_change_email($pdo, $row) {
	require_once '../config/app.php';

	if (!isset($row['users_email']) || !isset($row['users_uid'])) {
		return false;
	}

	$email = $row['users_email'];
	$uid = $row['users_uid'];
	$subject = "Password Change";
	// make random code
	$code = hash('whirlpool', $email);
	$link = "$APP_URL/reset?email=$email&code=$code";
	try {
		$sql = "UPDATE `users` SET `activation_code` = ? WHERE `users_id` = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$code, $uid]);
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}
	$message = file_get_contents('../mails/password_change.html');
	$empty = array("%name%", "%link%");
	$replace = array($uid, $link);
	$message = str_replace($empty, $replace, $message);
	$headers = array(
		'From' => 'camagru@erikpeik.fi',
		'Reply-To' => 'camagru@erikpeik.fi',
		'MIME-Version' => '1.0',
		'Content-type' => 'text/html; charset=iso-8859-1',
		'X-Mailer' => 'PHP/'.phpversion()
	);
	mail($email, $subject, $message, $headers);
	return true;
}

if (isset($_POST['name']) && isset($_POST['submit']) && $_POST['submit'] == 'send_reset') {
	require_once '../config/pdo.php';

	if (empty($_POST['name'])) {
		echo "Error: You need to fill in all fields";
		exit();
	}
	$name = $_POST['name'];
	try {
		$sql = "SELECT `users_email`, `users_uid` FROM `users`
		WHERE (`users_uid` = ? OR `users_email` = ?) AND `active` = 1;";
		$statement = $pdo->prepare($sql);
		$statement->execute([$name, $name]);
		$row = $statement->fetch();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit();
	}
	if (!$row) {
		echo "Error: User not found, or isn't activated";
		exit();
	} else {

		send_password_change_email($pdo, $row);
	}

} else {
	echo "Error: You need to fill in all fields";
}
