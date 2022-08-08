<?php

function delete_user_by_id($id, $dbh, int $active = 0) {
	try {
		$sql = 'DELETE FROM users WHERE users_id = ? AND active = ?';
		$statement = $dbh->prepare($sql);
		if (!$statement->execute(array($id, $active))) {
			$statement = null;
			header('location: ../login?msg=delete_user_failed');
			exit();
		}
	}
	catch (PDOException $e) {
		print("delete_user_by_id error!: " . $e->getMessage() . "<br/>");
	}
}

function find_unverified_user($activation_code, $email, $pdo) {
	try {
		$sql = "SELECT users_id, activation_code, activation_expiry < now() as expired
		FROM users WHERE active = 0 AND users_email = ?";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($email))) {
			$statement = null;
			header('location: ../login?msg=statement_failed');
			exit();
		}
		$user = $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e) {
		print("Error!!: " . $e->getMessage() . "<br/>");
	}
	if ($user) {
		// Already expired, delete the inactive user with expired activation code
		if ((int)$user[0]['expired'] === 1) {
			delete_user_by_id($user[0]['users_id'], $pdo);
			return null;
		}
		// verify the activation code
		if ($activation_code == $user[0]['activation_code']) {
			return $user;
		}
	}
	return null;
}

function activate_user(int $users_id, $pdo) {
	try {
		$sql = 'UPDATE users SET active = 1, activated_at = CURRENT_TIMESTAMP
		WHERE users_id = ?';
		$statement = $pdo->prepare($sql);
		$statement->execute(array($users_id));
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
		return False;
	}
	return True;
}



if (isset($_POST['code']) && isset($_POST['email']) && isset($_POST['submit'])) {
	require_once '../config/database.php';

	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
	$user = find_unverified_user(hash('whirlpool', $_POST['code']), $_POST['email'], $pdo);
	if ($user) {
		activate_user($user[0]["users_id"], $pdo);
		header("Location: ../login?msg=account_activated");
	} else {
		header("Location: ../signup?msg=activation_link_not_valid");
	}
}
