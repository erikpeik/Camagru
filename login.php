<?php

include_once 'includes/error_handler.php';

session_start();
if (isset($_SESSION["user_id"])) {
	header("Location: index.php");
}
echo('test');
if (isset($_GET['error'])) {
	echo(error_handler($_GET['error']));
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login • Camagru</title>
		<link rel="stylesheet" href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css">
		<script src="https://kit.fontawesome.com/c0a2ce9299.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<div class='login-container'>
			<div class='box'>
				<section class="signup-form">
					<img class="login_logo" src="images/logo.svg" alt="logo">
					<form action="includes/login-inc.php" method='post'>
						<div class='input-container'>
							<label for="name">Username, or email</label>
							<input class='login_input' type='text' name='name' autocomplete="username" required>
						</div>
						<div class='input-container'>
							<label for="name">Password</label>
							<input class='login_input' type='password' name='pwd' autocomplete="current-password" required>
						</div>
						<button class='login_button'type='submit' name='submit'>Log In</button>
					</form>
				</section>
			</div>
			<div class='box' style='margin-top: 0.6em; padding-bottom: 1.5em;'>
				<p id='login-text'>Don't have an account? <span id='signup-text' onclick="location.href = 'signup.php'">Sign up<span></p>
			</div>
		</div>
	</body>
</html>
