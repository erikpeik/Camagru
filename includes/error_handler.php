<?php

function alert($msg) {
	return "<script type='text/javascript'>alert('$msg');</script>";
}

function error_handler($error) {
	if ($error == 'empty_input') {
		$message = 'Empty input, try again.';
	}
	else if ($error == 'invalid_uid') {
		$message = "Invalid username. Requirements:\\n".
		"- Length is between 4-20\\n".
		"- Contains only letters, numbers and underscore _";
	}
	else if ($error == 'invalid_email') {
		$message = 'Invalid email format, try again.';
	}
	else if ($error == 'pwd_match') {
		$message = "Password doesn\\'t match, try again.";
	}
	else if ($error == 'invalid_password') {
		$message = "Invalid password format. Requirements:\\n".
		"- Length is at least 8 character long\\n".
		"- At least one uppercase and lowercase letter\\n".
		"- One special character [!@#$%^&*]";
	}
	else if ($error == 'uid_taken') {
		$message = "Username is already taken, try other one.";
	}
	else if ($error == 'user_not_found') {
		$message = "Login failed, user not found.\\n".
		"You can register new user by clicking \\'Sign up\\' below.";
	}
	else if ($error == 'wrong_password') {
		$message = 'Login failed, wrong password.\\n'.
		"You can change your password down below.";
	}
	else {
		$message = 'Unknown error code: '.$error;
	}
	return ("<script>alert('".$message."');</script>");
}
