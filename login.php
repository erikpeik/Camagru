<?php
include_once 'includes/msg_handler.php';

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION["user_id"])) {
	header("Location: .");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.php'; ?>
		<title>Login • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body style='min-height: 0'>
		<div class='login-container'>
			<div class='box'>
				<section class="signup-form">
					<img class="login_logo" src="images/logo.svg" alt="logo">
					<form action="includes/login-inc.php" method='post'>
						<div class='input-container'>
							<label for="name">Username, or email</label>
							<input class='login_input' type='text' name='name'
							autocomplete="username" required>
						</div>
						<div class='input-container'>
							<label for="name">Password</label>
							<input class='login_input' type='password'
							pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*"
							title="Invalid password format. Lenght is at least 8 character long, at least one upper- and lowercase letter, and one special character [!@#$%^&*]"
							name='pwd' autocomplete="current-password" required>
						</div>
						<button class='login_button'type='submit' name='submit'>Log In</button>
					</form>
					<a href='reset' id='forget_password'>Forgot Password?</a>
					<div style="height: 35px"></div>
					<?php if (isset($_GET['msg'])) {
						echo(msg_handler($_GET['msg']));
					} ?>
				</section>
			</div>
			<div class='box' style='margin-top: 0.6em; padding-bottom: 1.5em; height: 110px;'>
				<p id='login-text'>Don't have an account? <span id='signup-text' onclick="location.href = 'signup'">Sign up<span></p>
				<div class='or_bar'>
						<div id='or_text'>OR</div>
						<div id='or_line'></div>
				</div>
				<button id='forget_password' class='login_guest'>Log In as Guest</button>
			</div>
		</div>
	</body>
	<script src='js/login.js'></script>
</html>
