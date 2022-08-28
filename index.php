<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

include 'config/setup.php';
include_once "config/pdo.php";
include_once 'includes/like_functions.php';
include_once 'includes/comment_functions.php';
include_once 'includes/time_elapsed_string.php';

if (isset($_GET['logout'])) {
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_uid"]);
	header("Location: login");
	exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.php'; ?>
		<title>Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/gallery.css">
		<script src='js/comment.js'></script>
		<script src='js/image.js'></script>
		<?php require('js/does_it_match.php'); ?>
	</head>
	<body>
		<?php include "frontend/header.php"; ?>
		<main>
			<div id="overlay_box">
				<div id='overlay_bar'>
					<h1 id='overlay_header'></h1> <i id='cross' class="fa-solid fa-xmark"></i>
				</div>
				<div id='overlay_content'></div>
			</div>
			<div id='dim-background'></div>
			<?php
			if (isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
			if ($page < 1) {
				header("Location: ?page=1");
				exit();
			}
			$per_page = 5;
			$image_count = image_count($pdo);
			if ($image_count > 0) {
			$page_count = ceil($image_count / $per_page);
			if ($page > $page_count) {
				header("Location: ?page=$page_count");
				exit();
			}
			$data = fetch_page($pdo, $page, $per_page);
			foreach ($data as $image) {
				require('frontend/image_div.php');
			}
			require('frontend/pagination.php');
			} else { ?>
			<div class='no_images'>
				<h3>No images to display 😢</h3>
				<p><a href='camera'>Click here</a> to upload your first picture</p>
			</div>

			<?php } ?>
		</main>
		<script src='js/like.js'></script>
		<script src='js/comment.js'></script>
		<?php
		include 'frontend/footer.html';
		?>
	</body>
</html>
