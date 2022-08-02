<?php
if (!isset($_SESSION)) {
	session_start();
}
?>

<link rel="stylesheet" href="css/header.css">
<header>
	<nav class="navbar">
		<img class="logo" src="images/logo.svg" alt="logo" onclick="location.href = '.'">
		<ul class="nav-links">
			<li id='icon' title='Camera' onclick="location.href = 'camera'"><i class="ti ti-camera-plus"></i></li>
			<li id='icon' title='Profile' onclick="location.href = 'account'"><i class="ti ti-user"></i></li>
			<li id='icon' title='Logout' onclick="location.href = 'index?logout=true'"><i class="ti ti-door-exit"></i></li>
		</ul>
	</nav>
</header>
