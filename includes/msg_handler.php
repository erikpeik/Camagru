<?php

function msg_handler($code) {
	if ($code == 'empty_input') {
		$message = 'Empty input, try again.';
	}
	else if ($code == 'invalid_uid') {
		$message = "Invalid username. Requirements:<br />".
		"- Length is between 4-20<br />".
		"- Contains only letters, numbers and underscore _";
	}
	else if ($code == 'invalid_email') {
		$message = 'Invalid email format, try again.';
	}
	else if ($code == 'pwd_match') {
		$message = "Password doesn't match, try again.";
	}
	else if ($code == 'invalid_password') {
		$message = "Invalid password format. Requirements:<br />".
		"- Length is at least 8 character long<br />".
		"- At least one uppercase and lowercase letter<br />".
		"- One special character [!@#$%^&*]";
	}
	else if ($code == 'uid_taken') {
		$message = "Username is already taken, try other one.";
	}
	else if ($code == 'user_not_found') {
		$message = "The username you entered doesn't belong to an account. ".
		"Please check your username and try again.";
	}
	else if ($code == 'wrong_password') {
		$message = "Sorry, your password was incorrect. ".
		"Please double-check your password.";
	}
	else if ($code == 'user_or_password_wrong') {
		$message = "The username or password you entered was wrong. ".
		"Please double-check your username and password.";
	}
	else if ($code == 'user_not_active') {
		$message = "User is not active. Please check your email for activation link";
	}
	else if ($code == 'delete_user_failed') {
		$message = "User deletion failed, or it's already deleted.";
	}
	else if ($code == 'account_activated') {
		$message = "<span style='color: green;'>Account activated. You can Log in now.</span>";
	}
	else if ($code == 'activation_link_not_valid') {
		$message = "Activation link/code was not valid, or it's already activated. ".
		"You can try Log in.";
	}
	else if ($code == 'name_too_long') {
		$message = "Your name is too long. Max length is 255 characters.";
	}
	else if ($code == 'password_too_long') {
		$message = "Your password is too long. Max length is 255 characters.";
	}
	else if ($code == 'email_change_link_not_valid') {
		$message = "Email change link was not valid, or it's already changed.";
	}
	else if ($code == 'email_changed') {
		$message = "<span style='color: green;'>Email changed. You can Log in now.</span>";
	}
	else if ($code == 'invalid_code') {
		$message = "Invalid password reset code.";
	}
	else if ($code == "password_changed") {
		$message = "<span style='color: green;'>Password changed. You can Log in now.</span>";
	}
	else {
		$message = 'Unknown error code:<br />'.$code;
	}
	return ("<div class='message-box'><p>$message</p></div>");
}
