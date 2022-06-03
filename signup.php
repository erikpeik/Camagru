<?php
session_start();
if (isset($_SESSION["user_id"])) {
	header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sign Up • Camagru</title>
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
					<img class="login_logo" style='margin-bottom: 1em;' src="images/logo.svg" alt="logo">
					<p id='signup-welcome'>Sign up to see photos and videos from your friends.</p>
					<form action="includes/signup-inc.php" method='post'>
					<div class='input-container'>
							<label for="name">Email</label>
							<input type='text' name='email' autocomplete="email" required>
						</div>
						<div class='input-container'>
							<label for="name">Full Name</label>
							<input type='text' name='name' autocomplete="fname" required>
						</div>
						<div class='input-container'>
							<label for="name">Username</label>
							<input type='text' name='uid' autocomplete="username"required>
						</div>
						<div class='input-container'>
							<label for="name">Password</label>
							<input type='password' name='pwd' autocomplete="new-password" required>
						</div>
						<div class='input-container'>
							<label for="name">Repeat Password</label>
							<input type='password' name='pwd_repeat' autocomplete="new-password"required>
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
