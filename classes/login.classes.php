<?php

class Login extends Dbh {

	protected function get_user($uid, $pwd) {
		$statement = $this->connect()->prepare('SELECT users_pwd FROM users
		WHERE users_uid = ? OR users_email = ?');
		if (!$statement->execute(array($name, $uid, $hashed_pwd, $email))) {
			$statement = null;
			header('location: ../index.php?error=statement_failed');
			exit();
		}
		if ($statement->rowCount() == 0) {
			$statement = null;
			header('location: ../index.php?error=usernotfound');
			exit();
		}
		$pwd_hashed = $statement->fetchAll(PDO::FETCH_ASSOC);
		$check_pwd = password_verify($pwd, $pwd_hashed[0]["users_pwd"]);
		if ($check_pwd == false) {
			$statement = null;
			header('location: ../index.php?error=wrong_pasword');
			exit();
		}
		else if ($check_pwd == true) {
			$statement = $this->connect()->prepare('SELECT * FROM users
			WHERE users_uid = ? OR users_email = ? AND USERS_PWD = ?;');
			if (!$statement->execute(array($uid, $uid, $pwd))) {
				$statement = null;
				header('location: ../index.php?error=statement_failed');
				exit();
			}
			if ($statement->rowCount() == 0) {
				$statement = null;
				header('location: ../index.php?error=usernotfound');
				exit();
			}
			$user = $statement->fetchAll(PDO:FETCH_ACCOS);
			session_start();
			$_SESSION["user_id"] = $user[0]["users_id"];
			$_SESSION["user_uid"] = $user[0]["users_uid"];
		}
		$statement = null;
	}

}
