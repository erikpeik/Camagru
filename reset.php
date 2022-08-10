<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION["user_id"])) {
	header("Location: .");
	exit();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.php'; ?>
		<title>Reset Password • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
		<link rel="stylesheet" href="css/header.css">
	</head>
	<body style='min-height: 0'>
		<header>
			<nav class="navbar">
				<img class="logo" src="<?=$APP_URL?>/images/logo.svg" alt="logo" onclick="location.href = '<?=$APP_URL?>'">
			</nav>
		</header>
		<main>
		<?php if (isset($_GET['email']) && isset($_GET['code'])) {
			require_once 'config/pdo.php';
			$email = $_GET['email'];
			$code = $_GET['code'];
			$sql = "SELECT * FROM `users` WHERE `users_email` = ? AND `activation_code` = ?";
			$statement = $pdo->prepare($sql);
			$statement->execute([$email, $code]);
			$user = $statement->fetch();
			if ($user) { ?>
				<div class="login-container" style="margin-top: 60px;">
					<div class="box" style="padding-bottom: 2em">
						<img class="login_logo" src="images/logo.svg" alt="logo">
						<h3 id="reset_h3">Create A Strong Password</h3>
						<p id="reset_text" style="margin-bottom: 40px;">
							Your password must be at least 8 characters
							and should include a combination of numbers,
							letters and special characters (!@#$%^&*).
						</p>
						<form id="reset_password_form" action="reset.php"
						method="post" onsubmit="return false;">
							<div class="input-container">
								<label for="password">New Password</label>
								<input type="password" name="password" required
								pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*">
							</div>
							<div class="input-container">
								<label for="confirm_password">Confirm Password</label>
								<input type="password" name="confirm_password" required
								pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*">
							</div>
							<input type="text" name="email" value="<?=$email?>" hidden>
							<input type="text" name="code" value="<?=$code?>" hidden>
							<input class="login_button" type="submit" name="reset" value="Reset">
						</form>
						<p id='reset_error'></p>
					</div>
				</div>
				<script src="js/reset_password.js"></script>
		<?php } else {
			header("Location: login?msg=invalid_code");
			exit();
		}
		} else { ?>
		<div class='login-container'>
			<div class='box' style="height: 400px;">
				<div id='lock'>
					<svg xmlns="http://www.w3.org/2000/svg"
					class="icon icon-tabler icon-tabler-lock-access"
					width="120" height="120" viewBox="0 0 24 24" stroke-width="0.5"
					stroke="currentColor" fill="none" stroke-linecap="round"
					stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
						<path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path>
						<path d="M4 16v2a2 2 0 0 0 2 2h2"></path>
						<path d="M16 4h2a2 2 0 0 1 2 2v2"></path>
						<path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path>
						<rect x="8" y="11" width="8" height="5" rx="1"></rect>
						<path d="M10 11v-2a2 2 0 1 1 4 0v2"></path>
					</svg>
				</div>
				<h3 id='reset_h3'>Trouble Logging In?</h3>
				<p id='reset_text'>Enter your email or username and we'll send you a link to get back into your account.</p>
				<section class='signup-form'>
					<form id='reset_form' method='POST' onsubmit = 'return false;'>
						<div class='input-container'>
							<label for="name">Email or Username</label>
							<input class='login_input' type='text' name='name' autocomplete="username" required>
						</div>
						<button class='login_button' type='submit' name='submit' value='send_reset'>Send Reset Link</button>
					</form>
					<p id='reset_error'></p>
				<section>
				<button id='ok_button'>OK</button>
				<div class='or_bar'>
						<div id='or_text'>OR</div>
						<div id='or_line'></div>
				</div>
				<a id='create_account' href='signup'>Create New Account</a>
			</div>
			<div class='box' id='back_to_login'>
				<a id='create_account' href='login'>Back to Login</a>
			</div>
		</div>
		<script src='js/reset.js'></script>
	<?php } ?>
		</main>
	</body>
</html>
