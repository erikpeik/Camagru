<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_uid"])) {?>
	<script>
		alert('To accees the Settings, you need to be logged in');
		window.location.href='login';
	</script>
<?php }

require_once('includes/profile-inc.php');
require_once 'config/pdo.php';

$user_data = get_user_info($pdo, $_SESSION["user_uid"]);
?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once "frontend/head.php"; ?>
		<title>Settings • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/settings.css">
	</head>
	<body>
		<?php require "frontend/header.php"; ?>
		<main>
			<div id="overlay_box">
				<div id='overlay_bar'>
					<h1 id='overlay_header'></h1> <i id='cross' class="fa-solid fa-xmark"></i>
				</div>
				<div id='overlay_content'></div>
			</div>
			<div id='dim-background'></div>
			<div class='container'>
				<div class='name_bar'>
					<img src="<?= 'data:image/jpeg;base64,' . $user_data['profile_picture'] ?>"
						alt="Profile Picture" id='profile_picture'>
					<div id ='text-staff'>
						<h1 id='username'><?=$user_data["users_uid"]?></h1>
						<button id='change_picture'>Change profile photo</button>
					</div>
				</div>
				<form id='change_form' style='margin-top: 20px;'class='form'>
					<div id='input_div'>
						<label for="name">Name</label>
						<input type='text' name="name"value="<?= $user_data['users_name'] ?>">
						<span id='name_message' class='message_box'></span>
					</div>
					<div id='input_div'>
						<label for="username">Username</label>
						<input type='text' name="username" value="<?= $user_data['users_uid'] ?>">
						<span id='username_message' class='message_box'></span>
					</div>
					<div id='input_div'>
						<label for="email">Email</label>
						<input type='text' name="email" value="<?= $user_data['users_email'] ?>">
						<span id='email_message' class='message_box'></span>
					</div>
					<button type='submit' value='submit'>Submit</button>
					<button id='delete_account' value='delete'>
						<span id='delete_text'>Delete my account</span>
						<span id='delete_icon' class='fa-solid fa-trash-alt'></span>
					</button>
				</form>
				<hr>
				<form id='password_form' class='form' method='post'>
					<h3>Change Password</h3>
					<input hidden autocomplete="username">
					<div id='input_div'>
						<label style='width: 136px;' for="old_password">Old Password</label>
						<input type='password' name="old_password" value="" autocomplete="current-password">
					</div>
					<div id='input_div'>
						<label style='width: 136px;' for="new_password">New Password</label>
						<input type='password' name="new_password" value="" autocomplete="new-password">
					</div>
					<div id='input_div'>
						<label style='width: 136px;' for="confirm_password">Confirm Password</label>
						<input type='password' name="confirm_password" value="" autocomplete="new-password">
					</div>
					<span id='password_message' class='message_box'></span>
					<button type='submit' value='submit'>Submit</button>
				</form>
			</div>
		</main>
		<?php require "frontend/footer.html"; ?>
	</body>
	<script src="js/settings.js"></script>
</html>
