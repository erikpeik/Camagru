<?php

class Signup extends Dbh {
	protected function	check_user($uid, $email) {
		$statement = $this->connect()->prepare('SELECT users_uid FROM users
		WHERE users_uid = ? OR users_email = ?;');
		if (!$statement->execute(array($uid, $email))) {
			$statement = null;
			header('location: ../signup.php?error=statement_failed');
			exit();
		}
		return (($statement->rowCount() > 0));
	}

	protected function set_user($name, $email, $uid, $pwd, $activation_code, int $expiry = 30 * 60) {
		$statement = $this->connect()->prepare('INSERT INTO users (users_name,
		users_uid, users_pwd, users_email,activation_code, activation_expiry) VALUES (?, ?, ?, ?, ?, ?);');
		$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
		if (!$statement->execute(array($name, $uid, $hashed_pwd, $email,
				password_hash($activation_code, PASSWORD_DEFAULT), date('Y-m-d H:i:s', time() + $expiry)))) {
			$statement = null;
			header('location: ../signup.php?error=statement_failed');
			exit();
		}
	#	send_activation_email($email, $activation_code);
		$activation_link = "https://localhost:8080/camagru/auth.php?email=$email&activation_code=$activation_code";
		$subject = 'Activate your account';
		$message = "Hi, Please click the following link to activate your account: ".$activation_link;
		mail($email, $subject, $message);
		$statement = null;
		header("location: ../login.php?error=check_email_for_verification");
	}
}
