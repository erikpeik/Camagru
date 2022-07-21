<?php
session_start();
ob_start();

include 'config/setup.php';
include_once "config/pdo.php";
include_once 'includes/like_functions.php';
include_once 'includes/comment_functions.php';
include_once 'includes/time_elapsed_string.php';

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
		<link rel="stylesheet" href="css/gallery.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
		<script src='js/comment.js'></script>
		<script src='js/image.js'></script>
	</head>
	<body>
		<?php include_once "frontend/header.php"; ?>
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
			$image_count = image_count($pdo);
			$data = fetch_page($pdo, $page);
			foreach ($data as $image) {
				require('frontend/image_div.php');
			}
			?>
		</main>
		<script src='js/like.js'></script>
		<script src='js/comment.js'></script>
		<?php
		include 'frontend/footer.html';
		?>
	</body>
</html>
