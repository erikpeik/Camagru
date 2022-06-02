<?php session_start(); ?>

<link rel="stylesheet" href="css/header.css">
<header>
	<nav class="navbar">
		<div class="menu">
			<img class="logo" src="images/logo.svg" alt="logo" onclick="location.href = 'index.php'">
			<ul class="nav-links">
				<li><i class="ti ti-home" id="house"></i></li>
				<li><i class="ti ti-send"></i></li>
				<li><i class="ti ti-camera-plus"></i></li>
				<li><i class="fa-regular fa-compass"></i></li>
				<li><i class="fa-regular fa-heart"></i></li>
				<?php if (!isset($_SESSION["user_id"])) { ?>
				<li><button onclick="location.href = 'login.php'">LOGIN</button></li>
				<li><button onclick="location.href = 'signup.php'">SIGN UP</button></li>
				<?php } else { echo("<li class='text' style='font-size: 1em;'>Welcome " . $_SESSION["user_uid"] . "</li>"); } ?>

			</ul>
		</div>
	</nav>
</header>
