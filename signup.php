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
		<title>Sign Up • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body style='min-height: 0'>
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
							<input type='text' name='name' autocomplete="fname" required
							pattern="^([a-zA-Z' -]+)$" title="Only letters and spaces">
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
				<?php if (isset($_GET['msg'])) {
					echo(msg_handler($_GET['msg']));
				} ?>
			</div>
			<div class='box' style='margin-top: 0.6em; padding-bottom: 1.5em;'>
				<p id='login-text'>Have an account? <span id='signup-text' onclick="location.href = 'login'">Log in<span></p>
			</div>
		</div>
	</body>
</html>
