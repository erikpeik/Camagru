<?php
include_once 'includes/error_handler.php';
session_start();

if (isset($_SESSION["user_id"])) {
	header("Location: index.php");
}

if (isset($_GET['error'])) {
	echo(error_handler($_GET['error']));
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.html'; ?>
		<title>Sign Up • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<div class='login-container'>
			<div class='box'>
				<section class="signup-form">
					<img class="login_logo" style='margin-bottom: 1em;' src="images/logo.svg" alt="logo">
					<p id='signup-welcome'>Sign up to see photos and videos from your friends.</p>
					<form action="includes/signup-inc.php" method='post'>
					<div class='input-container'>
							<label for="name">Email</label>
							<input type='text' name='email' autocomplete="email"
							pattern="[A-Za-z0-9_\-.]+@([A-Za-z0-9_\-]+\.)+[A-Za-z0-9_\-.]{2,4}"
							title="Invalid email pattern. '@' is at least required. for example: test@outlook.com" required>
						</div>
						<div class='input-container'>
							<label for="name">Full Name</label>
							<input type='text' name='name' autocomplete="fname" required>
						</div>
						<div class='input-container'>
							<label for="name">Username</label>
							<input type='text' name='uid' autocomplete="username"
							pattern="[a-zA-Z0-9_]{4,20}"
							title="Invalid username. Lenght is between 4-20 and contains only letters, number and underscore _" required>
						</div>
						<div class='input-container'>
							<label for="name">Password</label>
							<input type='password' name='pwd' autocomplete="new-password"
							pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*"
							title="Invalid password format. Lenght is at least 8 character long, at least one upper- and lowercase letter, and one special character [!@#$%^&*]"
							required>
						</div>
						<div class='input-container'>
							<label for="name">Repeat Password</label>
							<input type='password' name='pwd_repeat' autocomplete="new-password"
							pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*"
							title="Invalid password format. Lenght is at least 8 character long, at least one upper- and lowercase letter, and one special character [!@#$%^&*]"
							required>
						</div>
						<button class='login_button' type='submit' name='submit'>Sign Up</button>
					</form>
				</section>
			</div>
			<div class='box' style='margin-top: 0.6em; padding-bottom: 1.5em;'>
				<p id='login-text'>Have an account? <span id='signup-text' onclick="location.href = 'login.php'">Log in<span></p>
			</div>
		</div>
	</body>
</html>
