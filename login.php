<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru</title>
		<link rel="stylesheet" href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css">
		<script src="https://kit.fontawesome.com/c0a2ce9299.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<?php include_once "header.php" ?>
		<div class='box'>
			<section class="signup-form">
				<img class="login_logo" src="images/logo.svg" alt="logo">
				<form action="includes/login-inc.php" method='post'>
					<input class='login_input' type='text' name='name' placeholder="Username/Email" autocomplete="username" required>
					<input class='login_input' type='password' name='pwd' placeholder="Password" autocomplete="current-password" required>
					<button class='login_button'type='submit' name='submit'>Log In</button>
				</form>
			</section>
		</div>
	</body>
</html>
