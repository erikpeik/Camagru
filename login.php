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
					<div class='input-container'>
						<label for="name">Username/Email</label>
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
	</body>
</html>
