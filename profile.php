<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

require_once("config/app.php");


if (!isset($_GET['username'])) {
	header("Location: profile/". $_SESSION["user_uid"]);
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once "frontend/head.php"; ?>
		<title>Profile • Camagru</title>
		<link rel="stylesheet" href="<?=$APP_URL?>/css/style.css">
		<link rel="stylesheet" href="<?=$APP_URL?>/css/account.css">
	</head>
	<body>
		<?php
			include "frontend/header.php";
			include_once 'config/pdo.php';
			include_once 'includes/get_profile_picture.php';
		?>
		<main>
			<?php if (isset($_GET['username'])) {
				print($_GET['username']);
			} ?>
			<?php $profile_picture = get_profile_picture($pdo); ?>
			<img src='<?=$profile_picture?>'>

		</main>
		<?php include "frontend/footer.html"; ?>
	</body>
</html>
