<?php
ob_start();

include_once 'includes/auth-inc.php';
include_once '../config/database.php';
include_once 'config/database.php';

if (isset($_GET['email']) && isset($_GET['activation_code'])) {
	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
	$user = find_unverified_user($_GET['activation_code'], $_GET['email'], $pdo);
	if ($user && activate_user($user[0]['users_id'], $pdo)) {
		header("Location: login.php?error=account_activated");
	} #else {
	#	header("Location: signup.php?error=activation_link_not_valid");
	#}
	print_r($user);
}
