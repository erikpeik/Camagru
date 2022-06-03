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

	protected function set_user($name, $email, $uid, $pwd) {
		$statement = $this->connect()->prepare('INSERT INTO users (users_name,
		users_uid, users_pwd, users_email) VALUES (?, ?, ?, ?);');
		$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
		if (!$statement->execute(array($name, $uid, $hashed_pwd, $email))) {
			$statement = null;
			header('location: ../signup.php?error=statement_failed');
			exit();
		}
		$statement = null;
	}

}
