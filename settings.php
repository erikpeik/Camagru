<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_uid"])) {?>
	<script>
		alert('To accees the Settings, you need to be logged in');
		window.location.href='login';
	</script>
<?php } ?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once "frontend/head.php"; ?>
		<title>Settings • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/account.css">
	</head>
	<body>
		<?php
			require "frontend/header.php";
			require_once 'config/pdo.php';
		?>
		<main></main>
		<?php require "frontend/footer.html"; ?>
	</body>
</html>
