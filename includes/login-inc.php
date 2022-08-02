<?php

if(isset($_POST["submit"])) {

	// Grabbing the data
	$uid = $_POST["name"];
	$pwd = $_POST["pwd"];

	// Instantiate SignupContr class
	include "../classes/dbh.classes.php";
	include "../classes/login.classes.php";
	include "../classes/login-contr.classes.php";
	$signup = new LoginContr($uid, $pwd);

	$signup->login_user();

	header('location: ../.');
}
