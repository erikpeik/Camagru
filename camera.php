<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.html'; ?>
		<title>Camera • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/camera.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<?php include_once "frontend/header.php" ?>
		<div class='camera-buttons'>
			<button id="start-camera"><i class="ti ti-camera-off"></i> Start Camera</button>
			<button id="click-photo"><i class="ti ti-camera"></i> Take Picture</button>
		</div>

		<div id="video-div">
			<video id="video" autoplay playsinline></video>
			<img id="sticker" style='top: 0; left: 0;' src="images/stickers/42.png">
		</div>
		<canvas id="canvas"></canvas>	
	</body>
	<script type="text/javascript" src="js/camera.js"></script>
</html>
