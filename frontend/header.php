<?php session_start(); ?>

<link rel="stylesheet" href="css/header.css">
<header>
	<nav class="navbar">
		<img class="logo" src="images/logo.svg" alt="logo" onclick="location.href = 'index.php'">
		<ul class="nav-links">
			<li id='logout-icon' title='Home' onclick="location.href = 'index.php'"><i class="ti ti-home"></i></li>
			<li id='logout-icon' title='Camera' onclick="location.href = 'camera.php'"><i class="ti ti-camera-plus"></i></li>
			<li id='logout-icon' title='Logout' onclick="location.href = 'index.php?logout=true'"><i class="ti ti-door-exit"></i></li>
			<li id='user-icon'><i class="ti ti-user"><span id='name-text'><?php echo($_SESSION['user_uid']); ?></span></i></li>
		</ul>
	</nav>
</header>
