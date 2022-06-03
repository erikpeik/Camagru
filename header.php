<?php session_start(); ?>

<link rel="stylesheet" href="css/header.css">
<header>
	<nav class="navbar">
		<img class="logo" src="images/logo.svg" alt="logo" onclick="location.href = 'index.php'">
		<ul class="nav-links">
			<li id='user-icon' class="ti ti-user"></i></li>
			<li id='logout-icon' title='Logout' onclick="location.href = 'index.php?logout=true'"><i class="ti ti-door-exit"></i></li>
		</ul>

	</nav>
</header>
