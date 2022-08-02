<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION["user_id"])) {?>
	<script>
		alert('To accees the Account settings, you need to be logged in');
		window.location.href='login';
	</script>
<?php } ?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.html'; ?>
		<title>Account • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/account.css">
	</head>
	<body>
		<?php include "frontend/header.php"; ?>
		<main></main>
		<?php include "frontend/footer.html"; ?>
	</body>
</html>
