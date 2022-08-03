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
	<body>
		<div class='login-container'>
			<div class='box'>
				<section class="signup-form">
					<img class="login_logo" src="images/logo.svg" alt="logo">
					<form action="includes/login-inc.php" method='post'>
						<div class='input-container'>
							<label for="name">Username, or email</label>
							<input class='login_input' type='text' name='name' autocomplete="username"
							pattern="[a-zA-Z0-9_@.]{4,20}"
							title="Invalid username. Lenght is between 4-20 and contains only letters, number and underscore _" required>
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
					<?php if (isset($_GET['msg'])) {
						echo(msg_handler($_GET['msg']));
					} ?>
				</section>
			</div>
			<div class='box' style='margin-top: 0.6em; padding-bottom: 1.5em;'>
				<p id='login-text'>Don't have an account? <span id='signup-text' onclick="location.href = 'signup'">Sign up<span></p>
			</div>
		</div>
	</body>
</html>
