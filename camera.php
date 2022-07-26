<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

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
			<?php if (!isset($_COOKIE['usage'])) { ?>
			<div class='information'>
				<div class='info_header'>
					<h3>Usage</h1></h3><i id='cross' class="fa-solid fa-xmark"></i>
				</div>
				<div>
					Start your camera by pressing <b>Start Camera</b>. Choose your stickers.<br>
					Take picture by pressing <b>Take Picture</b>.
					You can retry taking the picture by pressing <b>Cancel</b> or write your caption and press <b>Submit</b>.<br>
					By pressing <b>Submit</b> the image will be uploaded to the database and you are ready to go!
				</div>
			</div>
			<?php } ?>
			<div class='camera-buttons'>
				<button id="start-camera"><i class="ti ti-camera-off"></i> Start Camera</button>
				<button id="click-photo"><i class="ti ti-camera"></i> Take Picture</button>
			</div>
			<div class='container'>
				<div id='stickers'>
					<ul>
						<?php for ($i = 1; $i <= 7; $i++) { ?>
						<li>
							<img src="images/stickers/<?=$i?>.png" onclick="add_sticker(<?=$i?>)">
						</li>
						<?php } ?>
					</ul>
				</div>
				<div id="video-div" style="width: 640px; height: 480px;">
					<video id="video" autoplay playsinline></video>
					<div id="add_stickers"></div>
				</div>
				<div id='drafts'></div>
			</div>
			<canvas id="canvas"></canvas>
			<form id='image-form' method='post'>
				<h1>New Post</h1>
				<textarea id='description-field' name='caption' placeholder="Write a caption..." maxlength="280" required></textarea><br />
				<div id="buttons">
					<button type='button' id='cancel-image'>Cancel</button>
					<button type='submit' name='submit' value='submit' id='submit-image'>Submit</submit>
				</div>
			</form>
		</main>
		<?php include 'frontend/footer.html'; ?>
	</body>
	<script type="text/javascript" src="js/dragElement.js"></script>
	<script type="text/javascript" src="js/camera.js"></script>
</html>
