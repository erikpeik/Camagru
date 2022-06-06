<?php

include_once 'config/app.php';

function generate_activation_code() {
	return bin2hex(random_bytes(16));
}

function send_activation_email($email, $activation_code) {
	$activation_link = "https://localhost:8080/camagru/auth.php?email=$email&activation_code=$activation_code";
	$subject = 'Activate your account';
	$message = "Hi, Please click the following link to activate your account: ".$activation_link;
	mail($email, $subject, $message);
}

function delete_user_by_id($id, int $active = 0) {
	include_once 'config/app.php';

	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	$sql = 'DELETE FROM users WHERE id = ? AND active = ?';
	$statement = $dbh->prepare($sql);
	if (!$statement->execute(array($id))) {
		$statement = null;
		header('location: ../login.php?error=delete_user_failed');
		exit();
	}
}

function find_unverified_user($activation_code, $email) {
	include_once 'config/app.php';

	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	$sql = 'SELECT users_id, activation_code, activation_expiry < now() as expired
	FROM users WHERE active = 0 AND email = ?';
	$statement = $dbh->prepare($sql);
	if (!$statement->execute(array($email))) {
		$statement = null;
		header('location: ../login.php?error=statement_failed');
		exit();
	}
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	if ($user) {
		// Already expired, delete the inactive user with expired activation code
		if ((int)$user['expired'] === 1) {
			delete_user_by_id($user['users_id']);
			return null;
		}
		// verify the activation code
		if (password_verify($activation_code, $user['activation_code'])) {
			return $user;
		}
	}
	return null;
}

function activate_user(int $user_id) {
	include_once 'config/app.php';
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	$sql = 'UPDATE users SET active = 1, activated_at = CURRENT_TIMESTAMP
	WHERE id = :id';
	$statement = $dbh->prepare($sql);
	$statement->bindValue(':id', $user_id, PDO::PARAM_INT);
	return $statement->execute();
}
