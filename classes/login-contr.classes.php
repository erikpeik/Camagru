<?php

class LoginContr extends Login {
	private $uid;
	private $pwd;

	public function __construct($uid, $pwd) {
		$this->uid = $uid;
		$this->pwd = $pwd;
	}

	public function login_user() {
		if ($this->empty_input()) {
			header('location: ../login.php?msg=empty_input');
			exit();
		}
		$this->get_user($this->uid, $this->pwd);
	}

	private function empty_input() {
		return (empty($this->uid) || empty($this->pwd));
	}
}
