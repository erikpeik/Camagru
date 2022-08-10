<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

require_once "config/app.php";
include_once 'config/pdo.php';
include_once 'includes/profile-inc.php';
require_once 'includes/like_functions.php';
require_once 'includes/comment_functions.php';
require_once 'config/app.php';

if (!isset($_GET['username'])) {
	if ($_SESSION['user_id'] == -1) { ?>
		<script>
			alert("Guests doesn't have profile page.", "index");
			window.location.href = "<?=$APP_URL?>";
		</script>
		<?php exit();
	}
	header("Location: profile/". $_SESSION["user_uid"]);
	exit();
} else {
	$user_info = get_user_info($pdo, $_GET['username']);
	if ($user_info) {
		$images = get_users_images($pdo, $user_info['users_id']);
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once "frontend/head.php"; ?>
		<?php if (isset($user_info) && $user_info != false) { ?>
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
				<?php if (isset($user_info) && $user_info != false) { ?>
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
							<?php if ($images != false && isset($user_info['users_id'])) { ?>
							<li><span id='bold'><?= count($images) ?></span> posts</li>
							<li><span id='bold'><?= get_users_likes($pdo, $user_info['users_id']);?></span> likes</li>
							<?php } ?>
						</ul>
						<p id='bold'><?=$user_info["users_name"]?></p>
					</div>
				</div>
					<?php
					if ($images != false) { ?>
						<div class='image_grid'>
					 <?php foreach($images as $image) {
						$likes = get_image_likes($pdo, $image['image_id']);
						$comments = get_comment_amount($pdo, $image['image_id']); ?>
						<div class='image_container'>
							<img src="data:image/jpg;charset=utf8;base64,<?= base64_encode($image['image']); ?>"/>
							<a href='<?=$APP_URL?>/picture/<?=$image['image_id']?>'>
							<div class='image_overlay'>
								<div class='image_stats'>
									<ul>
										<li><i class="fa-solid fa-heart"></i> <?= $likes['count'] ?></li>
										<li><i class="fa-solid fa-comment"></i> <?= $comments ?></li>
									</ul>
								</div>
							</div>
					 	</a>
						</div>
					<?php }
					} else { ?>
						<div class='no_images'>
							<p id="warning_text" style='font-weight: 500'>No images found</p>
						</div>
					<?php } ?>
				</div>
				<?php } else { ?>
					<p id='warning_text'>Sorry, this page isn't available.</p>
					<p style='text-align: center;'>The link you followed may be broken, or the page may have been removed. <a href='<?= $APP_URL ?>'>Go back to Camagru.</a></p>
				<?php }?>
			</div>
		</main>
		<?php include "frontend/footer.html"; ?>
	</body>
	<script src="<?=$APP_URL?>/js/profile.js"></script>
</html>
