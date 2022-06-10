<?php

function delete_user_by_id($id, $dbh, int $active = 0) {
	try {
		$sql = 'DELETE FROM users WHERE users_id = ? AND active = ?';
		$statement = $dbh->prepare($sql);
		if (!$statement->execute(array($id, $active))) {
			$statement = null;
			header('location: ../login.php?error=delete_user_failed');
			exit();
		}
	}
	catch (PDOException $e) {
		print("delete_user_by_id error!: " . $e->getMessage() . "<br/>");
	}
}

function find_unverified_user($activation_code, $email) {
	include_once '../config/database.php';
	include_once 'config/database.php';

	try {
	#	print("DATABASE: ".$DB_USER."<br />");
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
		$sql = "SELECT users_id, activation_code, activation_expiry < now() as expired
		FROM users WHERE active = 0 AND users_email = ?";
		$statement = $dbh->prepare($sql);
		if (!$statement->execute(array($email))) {
			$statement = null;
			header('location: ../login.php?error=statement_failed');
			exit();
		}
		$user = $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e) {
		print("Error!!: " . $e->getMessage() . "<br/>");
	}
	print(print_r($user)."<br><br>");
	if ($user) {
#		header("Location: signup.php?error=user_exists");
	#	print(print_r($user)."<br><br>");
		// Already expired, delete the inactive user with expired activation code
		if ((int)$user[0]['expired'] === 1) {
		#	header("Location: signup.php?error=delete_user");
			delete_user_by_id($user[	0]['users_id'], $dbh);
			return null;
		}
		// verify the activation code
		$hashed_authentication = password_hash($activation_code, PASSWORD_DEFAULT);
		if (password_verify($hashed_authentication, $user[0]['activation_code'])) {
			return $user;
		}
	#	header("Location: signup.php?error=delete_user");
	}
	print("Activation: ". password_hash("12345", PASSWORD_DEFAULT) ."<br>");
	print("Activation: ". $activation_code."<br>");
	print("Hashed: ". $user[0]['activation_code']);
#	header("Location: signup.php?error=no_user ");
	return null;
}

function activate_user(int $user_id) {
	include_once 'config/database.php';
	include_once '../config/database.php';
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	$sql = 'UPDATE users SET active = 1, activated_at = CURRENT_TIMESTAMP
	WHERE id = :id';
	$statement = $dbh->prepare($sql);
	$statement->bindValue(':id', $user_id, PDO::PARAM_INT);
	return $statement->execute();
}

function console_log($output, $with_script_tags = true) {
	$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
	if ($with_script_tags) {
		$js_code = '<script>' . $js_code . '</script>';
	}
	echo $js_code;
}
