<?php

class SignupContr extends Signup {
	private $name;
	private $email;
	private $uid;
	private $pwd;
	private $pwd_repeat;

	public function __construct($name, $email, $uid, $pwd, $pwd_repeat) {
		$this->name = $name;
		$this->email = $email;
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->pwd_repeat = $pwd_repeat;
	}

	public function signup_user() {
		include_once '../includes/auth.php';
		if ($this->empty_input()) {
			header('location: ../signup.php?msg=empty_input');
			exit();
		}
		if ($this->invalid_uid() == false) {
			header('location: ../signup.php?msg=invalid_uid');
			exit();
		}
		if ($this->invalid_email() == false) {
			header('location: ../signup.php?msg=invalid_email');
			exit();
		}
		if ($this->pwd_match() == false) {
			header('location: ../signup.php?msg=pwd_match');
			exit();
		}
		if ($this->invalid_password() == false) {
			header('location: ../signup.php?msg=invalid_password');
			exit();
		}
		if ($this->uid_taken()) {
			header('location: ../signup.php?msg=uid_taken');
			exit();
		}
		$activation_code = strval(mt_rand(100000, 999999));
		$this->set_user($this->name, $this->email, $this->uid, $this->pwd, $activation_code);
	}

	private function empty_input() {
		return ((empty($this->name) || empty($this->email)
		|| empty($this->uid) || empty($this->pwd) || empty($this->pwd_repeat)));
	}

	private function invalid_uid() {
		return (preg_match("/^[a-z0-9_]{4,20}$/i", $this->uid));
	}

	private function invalid_email() {
		return (filter_var($this->email, FILTER_VALIDATE_EMAIL));
	}

	private function pwd_match() {
		return ($this->pwd == $this->pwd_repeat);
	}

	private function invalid_password() {
		return (preg_match("/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*$/", $this->pwd));
	}

	private function uid_taken() {
		return ($this->check_user($this->uid, $this->email));
	}
}
