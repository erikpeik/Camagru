<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camagru</title>
		<link rel="stylesheet" href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css">
		<script src="https://kit.fontawesome.com/c0a2ce9299.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/header.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<?php include_once "header.php" ?>
		<section class="signup-form">
			<h2>Sign Up</h2>
			<form action="includes/signup-inc.php" method='post'>
				<input type='text' name='name' placeholder="Full Name" required>
				<input type='text' name='email' placeholder="Email" required>
				<input type='text' name='uid' placeholder="Username" autocomplete="username"required>
				<input type='password' name='pwd' placeholder="Password" autocomplete="new-password" required>
				<input type='password' name='pwd_repeat' placeholder="Repeat password" autocomplete="new-password"required>
				<button type='submit' name='submit'>Sign Up</button>
			</form>
		</section>
	</body>
</html>
