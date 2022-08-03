<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

require_once "config/app.php";
include_once 'config/pdo.php';
include_once 'includes/profile-inc.php';

if (!isset($_GET['username'])) {
	header("Location: profile/". $_SESSION["user_uid"]);
}
$user_info = get_user_info($pdo, $_GET['username']);
$images = get_users_images($pdo, $user_info['users_id']);
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once "frontend/head.php"; ?>
		<?php if ($user_info != false) { ?>
			<title><?= $user_info['users_name'] . " (@".$user_info['users_uid'] . ")" ?> • Camagru</title>
		<?php } else { ?>
			<title>User not found • Camagru</title>
		<?php } ?>
		<link rel="stylesheet" href="<?=$APP_URL?>/css/style.css">
		<link rel="stylesheet" href="<?=$APP_URL?>/css/profile.css">

	</head>
	<body>
		<?php include "frontend/header.php"; ?>
		<main>
			<div class="profile-container">
				<div class='user_info'>
					<div class="profile-picture">
						<img src="<?= 'data:image/jpeg;base64,' .$user_info['profile_picture'] ?>" alt="Profile Picture">
					</div>
					<div class="profile-info">
						<div id='username_bar'>
							<h1><?=$user_info["users_uid"]?></h1>
							<?php if ($user_info["users_uid"] == $_SESSION["user_uid"]) { ?>
							<button id='settings_button'>Edit profile</button>
							<?php } ?>
						</div>
						<ul id='posts_likes'>
							<li><span id='bold'><?= count($images) ?></span> posts</li>
							<li><span id='bold'><?= get_users_likes($pdo, $user_info['users_id']);?></span> likes</li>
						</ul>
						<p id='bold'><?=$user_info["users_name"]?></p>
				</div>
				<div class='image_grid'>
					<?php foreach($images as $image) { ?>
					<img src="data:image/jpg;charset=utf8;base64,<?= base64_encode($image['image']); ?>"/>
					<?php } ?>
				</div>
			</div>
		</main>
		<?php include "frontend/footer.html"; ?>
	</body>
	<script src="<?=$APP_URL?>/js/profile.js"></script>
</html>
