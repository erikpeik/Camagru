<?php

if(isset($_POST["submit"])) {

	// Grabbing the data
	$name = $_POST["name"];
	$email = $_POST["email"];
	$uid = $_POST["uid"];
	$pwd = $_POST["pwd"];
	$pwd_repeat = $_POST["pwd_repeat"];

	// Instantiate SignupContr class
	include "../classes/dbh.classes.php";
	include "../classes/signup.classes.php";
	include "../classes/signup-contr.classes.php";
	$signup = new SignupContr($name, $email, $uid, $pwd, $pwd_repeat);

	$signup->signup_user();

#	header('location: ../index.php');
}
