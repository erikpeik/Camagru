<?php
ob_start();

include_once 'includes/auth-inc.php';
include_once 'config/database.php';

if (isset($_GET['email']) && isset($_GET['activation_code'])) {
	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
	$user = find_unverified_user($_GET['activation_code'], $_GET['email'], $pdo);
	if ($user) {
		activate_user($user[0]['users_id'], $pdo);
		header("Location: login.php?msg=account_activated");
	} else {
		header("Location: signup.php?msg=activation_link_not_valid");
	}
}

include_once 'includes/msg_handler.php';

if (isset($_GET['msg'])) {
	echo(msg_handler($_GET['msg']));
}

if (!isset($_GET['email'])) {
	header("Location: signup.php");
}

if (isset($_GET['email'])) {
	$email = $_GET['email'];
} else {
	$email = "";
}

?>
<html>
	<head>
		<?php include_once 'frontend/head.php'; ?>
		<title>Login • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
	<head>
	<body>
		<div class='login-container'>
			<div class='box'>
				<div id='mail-icon'>
					<svg xmlns="http://www.w3.org/2000/svg" id="svg-shadow" class="icon icon-tabler icon-tabler-mail-forward"
					width="98" height="98" viewBox="0 0 24 24" stroke-width="0.75" stroke="currentColor"
					fill="none" stroke-linecap="round" stroke-linejoin="round">
						<desc>Download more icon variants from https://tabler-icons.io/i/mail-forward</desc>
						<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
						<path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5"></path>
						<path d="M3 6l9 6l9 -6"></path>
						<path d="M15 18h6"></path>
						<path d="M18 15l3 3l-3 3"></path>
					</svg>
				</div>
				<p id='confirmation-h1'>Enter Confirmation Code</p>
				<p id='login-text' style='margin-top: 0px; margin-bottom: 20px'>Enter the confirmation code we sent to <?=$email?></p>
				<form action="includes/auth-inc.php" method="post">
					<section class="signup-form">
						<div class="auth-container">
							<input class="auth-input" type="text" name="code" pattern="[0-9]{6}"
								title="Confirmation Code should only contain numbers and length be 6 digits."
								placeholder="Confirmation Code" required>
						</div>
						<input type="hidden" name="email" value="<?=$email?>">
						<button class="login_button" type="submit" name="submit">Next</submit>
					</section>
				</form>
			</div>
			<div class='box' style='margin-top: 0.6em; padding-bottom: 1.5em;'>
				<p id='login-text'>Have an account? <span id='signup-text' onclick="location.href = 'login.php'">Log in<span></p>
			</div>
		</div>
	</body>
</html>
