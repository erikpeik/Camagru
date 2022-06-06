<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Camera • Camagru</title>
		<link rel="stylesheet" href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css">
		<script src="https://kit.fontawesome.com/c0a2ce9299.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/header.css">
		<link rel="stylesheet" href="css/camera.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<?php include_once "frontend/header.php" ?>
		<button id="start-camera">Start Camera</button>
		<video id="video" width="320" height="240" autoplay></video>
		<button id="click-photo">Click Photo</button>
		<canvas id="canvas" width="320" height="240"></canvas>
	</body>
	<script type="text/javascript" src="js/camera.js"></script>
</html>
