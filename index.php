<?php
session_start();
ob_start();

include 'config/setup.php';
include_once "config/pdo.php";
include_once 'includes/like_functions.php';

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
		<?php include_once "frontend/header.php"; ?>
		<main>
			<div id="like-names">
				<div id='likes-bar'>
					<h1>Likes</h1> <i id='cross' class="fa-solid fa-xmark"></i>
				</div>
				<div id='like-users'></div>
			</div>
			<div id='dim-background'></div>
			<?php
			$data = fetch_all_image_data($pdo);
			foreach ($data as $image) {
				?>
				<div class="image-div">
					<div id='top-bar'>
						<h1><?= $image['users_uid'] ?></h1>
					</div>
					<img id='image-settings' src="data:image/jpg;charset=utf8;base64,<?= base64_encode($image['image']) ?>"/>
					<div id='like-row'>
						<?php
							$like_count = check_if_user_liked_picture($pdo, $image['image_id']);
						?>
						<span onclick="add_like(<?=$image['image_id'];?>)">
						<?php if ($like_count == 0) { ?>
							<i id="like_button_<?= $image['image_id'] ?>" class="fa-regular fa-heart"></i>
							<?php } else { ?>
							<i id="like_button_<?= $image['image_id'] ?>" style="color: #ED4956;" class="fa-solid fa-heart"></i>
							<?php } ?>
						</span>
						<i class="fa-regular fa-comment"></i>
					</div>
					<button id='like-text' onclick="show_likes(<?= $image['image_id']; ?>)"><span id='like_count_<?= $image['image_id']; ?>'>
					<?php
						$data = get_image_likes($pdo, $image['image_id']);
						echo $data['count'];
					?>
					</span> likes</button>
					<b id='name-left'><?= $image['users_name'] ?></b> <p><?= $image['caption'] ?></p>
				</div>
				<?php
				$i++;
			}
			?>
		</main>
		<script src='js/like.js'></script>
		<?php
		include 'frontend/footer.html';
		?>
	</body>
</html>
