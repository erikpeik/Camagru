<?php
session_start();
ob_start();

include 'config/setup.php';
include_once "config/pdo.php";

if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
}
if (isset($_GET['logout'])) {
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_uid"]);
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.html'; ?>
		<title>Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<main>
		<?php include_once "frontend/header.php";
		$sql = "SELECT `images`.*, `users`.`users_name` FROM `images`
		LEFT JOIN `users`
		ON `images`.`users_id` = `users`.`users_id`;";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute()) {
			$statement = null;
			header('location: ../index.php?msg=statement_failed');
			exit();
		}
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data as $image) {
			?>
			<div class="image-div">
				<div id='top-bar'>
					<h1><?= $image['users_name'] ?></h1>
				</div>
				<img id='image-settings' src="data:image/jpg;charset=utf8;base64,<?= base64_encode($image['image']) ?>"/>
				<div id='like-row'>
					<i class="fa-regular fa-heart"></i>
					<i class="fa-regular fa-comment"></i>
				</div>
				<p id='like-count'>0 likes</p>
				<b><?= $image['users_name'] ?></b> <p><?= $image['caption'] ?></p>
			</div>
			<?php
		}
		?>
		</main>
		<?php
		include 'frontend/footer.html';
		?>
	</body>
</html>
