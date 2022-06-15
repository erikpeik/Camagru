<?php

class Login extends Dbh {
	private function check_if_user_exist($uid, $pwd) {
		$statement = $this->connect()->prepare('SELECT users_pwd FROM users
		WHERE users_uid = ? OR users_email = ?;');
		if (!$statement->execute(array($uid, $uid))) {
			$statement = null;
			header('location: ../login.php?msg=statement_failed');
			exit();
		}
		if ($statement->rowCount() == 0) {
			$statement = null;
			header('location: ../login.php?msg=user_not_found');
			exit();
		}
		return $statement;
	}

	private function check_user_and_password($uid, $pwd) {
		$statement = $this->connect()->prepare('SELECT * FROM users
		WHERE users_uid = ? OR users_email = ? AND USERS_PWD = ?;');
		if (!$statement->execute(array($uid, $uid, $pwd))) {
			$statement = null;
			header('location: ../login.php?msg=statement_failed');
			exit();
		}
		if ($statement->rowCount() == 0) {
			$statement = null;
			header('location: ../login.php?msg=user_or_password_wrong');
			exit();
		}
		return $statement;
	}

	private function check_if_user_active($uid) {
		$sql = 'SELECT users_uid, users_pwd, active, users_email
		FROM users WHERE users_uid = ? or users_email = ?;';
		$statement = $this->connect()->prepare($sql);
		if (!$statement->execute(array($uid, $uid))) {
			$statement = null;
			header('location: ../login.php?msg=statement_failed');
			exit();
		}
		if ($statement->rowCount() == 0) {
			$statement = null;
			header('location: ../login.php?msg=user_not_found');
			exit();
		}
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		return ((int)$user['active'] === 1);
	}

	protected function get_user($uid, $pwd) {
		$statement = $this->check_if_user_exist($uid, $pwd);
		$pwd_hashed = $statement->fetchAll(PDO::FETCH_ASSOC);
		$check_pwd = (hash('whirlpool', $pwd) == $pwd_hashed[0]["users_pwd"]);
		if ($check_pwd == false) {
			$statement = null;
			header('location: ../login.php?msg=wrong_password');
			exit();
		}
		else if ($check_pwd == true) {
			$statement = $this->check_user_and_password($uid, hash('whirlpool', $pwd));
			$user = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (!$this->check_if_user_active($uid)) {
				header('location: ../login.php?msg=user_not_active');
				exit();
			}
			session_start();
			$_SESSION["user_id"] = $user[0]["users_id"];
			$_SESSION["user_uid"] = $user[0]["users_uid"];
		}
		$statement = null;
	}
}
