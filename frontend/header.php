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
		<?php $base = basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>
		<ul class="nav-links">
			<?php if (isset($_SESSION["user_id"])) { ?>
			<li id='icon' title='Camera' onclick="location.href = '<?=$APP_URL?>/camera'"><i class="ti ti-camera-plus"></i></li>
			<li id='icon' title='Profile' onclick="location.href = '<?=$APP_URL?>/profile'"><i class="ti ti-user"></i></li>
			<li id='icon' title='Settings' onclick="location.href = '<?=$APP_URL?>/settings'"><i class="ti ti-settings"></i></li>
			<li id='icon' title='Logout' onclick="location.href = '<?=$APP_URL?>/index?logout=true'"><i class="ti ti-door-exit"></i></li>
			<?php } else if ($base != "login" && $base != "signup") { ?>
			<li id='login_button' title='Login' onclick="location.href = '<?=$APP_URL?>/login'">Login</li>
			<li id='signup_button' title='Signup' onclick="location.href = '<?=$APP_URL?>/signup'">Sign up</li>
			<?php } ?>
		</ul>
	</nav>
</header>
