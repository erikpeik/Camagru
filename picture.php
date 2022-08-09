<?php
require 'includes/picture-inc.php';
require_once 'config/pdo.php';
require_once 'includes/like_functions.php';
require_once 'includes/comment_functions.php';
require_once 'includes/time_elapsed_string.php';

if (isset($_GET['photo'])) {
	$photo_id = $_GET['photo'];
	$image = get_photo_info($pdo, $photo_id);
} else {
	$photo_id = false;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once "frontend/head.php"; ?>
		<?php if ($photo_id != false && !empty($image) && isset($image['users_uid'])) { ?>
			<title><?= $image['users_uid']?>'s picture	• Camagru</title>
		<?php } else { ?>
			<title>Page not found • Camagru</title>
		<?php } ?>
		<link rel="stylesheet" href="<?=$APP_URL?>/css/style.css">
		<link rel="stylesheet" href="<?=$APP_URL?>/css/gallery.css">
	</head>
	<body>
		<?php require 'frontend/header.php'; ?>
		<main>
		<div id="overlay_box">
				<div id='overlay_bar'>
					<h1 id='overlay_header'></h1> <i id='cross' class="fa-solid fa-xmark"></i>
				</div>
				<div id='overlay_content'></div>
			</div>
		<div id='dim-background'></div>
		<?php if (!empty($image)) {
			require 'frontend/image_div.php';
		} else { ?>
			<p id='warning_text'>Sorry, this page isn't available.</p>
			<p style='text-align: center;'>The link you followed may be broken, or the page may have been removed. <a href='<?= $APP_URL ?>'>Go back to Camagru.</a></p>
		<?php } ?>
		</main>
		<?php require 'frontend/footer.html'; ?>
	</body>
	<script src="<?=$APP_URL?>/js/picture.js"></script>
	<?php require 'js/does_it_match.php'?>
</html>
