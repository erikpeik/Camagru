<?php
session_start();
ob_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php 
		    include_once 'frontend/head.html';
		 
		?>
		<title>Camera • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/camera.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<?php include_once "frontend/header.php" ?>
		<main>
			<div class='camera-buttons'>
				<button id="start-camera"><i class="ti ti-camera-off"></i> Start Camera</button>
				<button id="click-photo"><i class="ti ti-camera"></i> Take Picture</button>
			</div>

			<div id="video-div">
				<video id="video" autoplay playsinline></video>
				<img id="sticker" style='top: 0; left: 0;' src="images/stickers/42.png">
			</div>
			<canvas id="canvas"></canvas>
			<div id="final-image"></div>
			<form id='image-form' action='includes/store-image.php' method='post'>
				<h1>New Post</h1>
				<!-- <label for='description'>Description</label><br /> -->
				<textarea id='description-field' name='caption' placeholder="Write a caption..." maxlength="280" required></textarea><br />
				<div id="buttons">
					<button type='button' onClick="location.href = 'camera.php'" id='cancel-image'>Cancel</button>
					<button type='submit' name='submit' value='submit' id='submit-image'>Submit</submit>
				</div>
			</form>
		</main>
		<?php include 'frontend/footer.html'; ?>
	</body>
	<script type="text/javascript" src="js/camera.js"></script>
</html>
