<?php

include_once 'includes/database.php';
include_once 'includes/auth-inc.php';


if (isset($_GET['email']) && isset($_GET['activation_code'])) {
	$user = find_unverified_user($_GET['activation_code'], $_GET['email']);
	print_r($user);
	if ($user && activate_user($user[0]['users_id'])) {
		print("HellloWorld<br>");
		header("Location: login.php?error=account_activated");
	}
#	print_r($user);
	#header("Location: signup.php?error=activation_link_not_valid");
}
