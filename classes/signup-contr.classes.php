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
		if ($this->empty_input()) {
			header('location: ../index.php?error=empty_input');
			exit();
		}
		if ($this->invalid_uid() == false) {
			header('location: ../index.php?error=invalid_uid');
			exit();
		}
		if ($this->invalid_email() == false) {
			header('location: ../index.php?error=invalid_email');
			exit();
		}
		if ($this->pwd_match() == false) {
			header('location: ../index.php?error=pwd_match');
			exit();
		}
#		if ($this->uid_taken()) {
#			header('location: ../index.php?error=uid_taken');
#			exit();
#		}
		$this->set_user($this->name, $this->email, $this->uid, $this->pwd);
	}

	private function empty_input() {
		return ((empty($this->name) || empty($this->email)
		|| empty($this->uid) || empty($this->pwd) || empty($this->pwd_repeat)));
	}

	private function invalid_uid() {
		return (preg_match("/^[A-Za-z0-9_]{4,20}$/", $this->uid));
	}

	private function invalid_email() {
		return (filter_var($this->email, FILTER_VALIDATE_EMAIL));
	}

	private function pwd_match() {
		return ($this->pwd == $this->pwd_repeat);
	}

	private function uid_taken() {
		return ($this->check_user($this->uid, $this->email));
	}
}
