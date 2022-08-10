<?php
if (!isset($_SESSION)) {
	session_start();
}

require_once("config/app.php");
?>

<link rel="stylesheet" href="<?=$APP_URL?>/css/header.css">
<header>
	<nav class="navbar">
		<img class="logo" src="<?=$APP_URL?>/images/logo.svg" alt="logo" onclick="location.href = '<?=$APP_URL?>'">
		<ul class="nav-links">
			<?php if (isset($_SESSION["user_id"]) && $_SESSION['user_id'] != -1) { ?>
			<li id='icon' title='Camera' onclick="location.href = '<?=$APP_URL?>/camera'"><i class="ti ti-camera-plus"></i></li>
			<li id='icon' title='Profile' onclick="location.href = '<?=$APP_URL?>/profile'"><i class="ti ti-user"></i></li>
			<li id='icon' title='Settings' onclick="location.href = '<?=$APP_URL?>/settings'"><i class="ti ti-settings"></i></li>
			<?php } ?>
			<li id='icon' title='Logout' onclick="location.href = '<?=$APP_URL?>/index?logout=true'"><i class="ti ti-door-exit"></i></li>
		</ul>
	</nav>
</header>
