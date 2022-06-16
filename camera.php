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
		<button id="start-camera">Start Camera</button>
		<video id="video" width="640" height="480" autoplay></video>
		<button id="click-photo">Click Photo</button>
		<canvas id="canvas" width="640" height="480"></canvas>
	</body>
	<script type="text/javascript" src="js/camera.js"></script>
</html>
