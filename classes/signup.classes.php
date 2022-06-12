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
		include_once '../includes/auth.php';

		date_default_timezone_set("Europe/Helsinki");
		$statement = $this->connect()->prepare('INSERT INTO users (users_name,
		users_uid, users_pwd, users_email,activation_code, activation_expiry) VALUES (?, ?, ?, ?, ?, ?);');
		$hashed_pwd = hash('whirlpool', $pwd);
		if (!$statement->execute(array($name, $uid, $hashed_pwd, $email,
			hash('whirlpool', $activation_code), date('Y-m-d H:i:s', time() + $expiry)))) {
			$statement = null;
			header('location: ../signup.php?error=statement_failed');
			exit();
		}
		$this->send_activation_email($email, $name, $activation_code);
		$statement = null;
		header("location: ../auth.php?email=$email");
	}

	protected function send_activation_email($email, $name, $activation_code) {
		include_once('../config/app.php');

		$hashed_activation = hash('whirlpool', $activation_code);
		$activation_link = "$APP_URL/auth.php?email=".$email."&activation_code=".$hashed_activation;
		$subject = 'Activate your account';
		$message = file_get_contents('../mails/activate_mail.html');
		$empty = array("%name%", "%code%", "%link%");
		$replace = array($name, $activation_code, $activation_link);
		$message = str_replace($empty, $replace, $message);
		$headers = array(
			'From' => 'admin@erikpeik.fi',
			'Reply-To' => 'admin@erikpeik.fi',
			'MIME-Version' => '1.0',
			'Content-type' => 'text/html; charset=iso-8859-1',
			'X-Mailer' => 'PHP/'.phpversion()
		);
		mail($email, $subject, $message, $headers);
	}
}
