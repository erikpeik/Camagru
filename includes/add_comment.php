<?php

if (!isset($_SESSION)) {
	session_start();
}
require_once '../config/pdo.php';

function send_email_comment($pdo, $image_id, $user_id, $comment) {
	require_once '../config/app.php';

	$sql = "SELECT `users_uid`, `users_email` FROM `users` WHERE `users_id` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$_SESSION['user_id']]);
	$result = $statement->fetch();
	$sender_uid = $result['users_uid'];

	$sql = "SELECT `users_email`, `users_uid` FROM `users`
	INNER JOIN `images` ON `users`.`users_id` = `images`.`users_id`
	WHERE `image_id` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$image_id]);
	$result = $statement->fetch();
	$receiver_email = $result['users_email'];
	$receiver_uid = $result['users_uid'];

	$subject = "New comment on your image";
	$message = file_get_contents('../mails/comment.html');
	$link = "$APP_URL/picture/$image_id";
	$profile_link = "$APP_URL/profile/$sender_uid";
	$empty = array("%name%", "%sender%", "%comment%", "%link%", "%profile_link%");
	$replace = array($receiver_uid, $sender_uid, $comment, $link, $profile_link);
	$message = str_replace($empty, $replace, $message);
	$headers = array(
		'From' => 'camagru@erikpeik.fi',
		'Reply-To' => 'camagru@erikpeik.fi',
		'MIME-Version' => '1.0',
		'Content-type' => 'text/html; charset=iso-8859-1',
		'X-Mailer' => 'PHP/'.phpversion()
	);
	mail($receiver_email, $subject, $message, $headers);
}

if (isset($_POST['comment']) && isset($_POST['image_id'])) {
	$comment = $_POST['comment'];
	$image_id = $_POST['image_id'];
	$user_id = $_SESSION["user_id"];
	if (strlen($comment) > 280) {
		print("Comment too long!");
		exit();
	}
	try {
		$sql = "INSERT INTO `comments` (`users_id`, `image_id`, `comment`)
		VALUES (?, ?, ?);";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($user_id, $image_id, htmlspecialchars($comment)))) {
			$statement = null;
			header('location: ../index?msg=error');
			exit();
		}
		print("Comment added!");
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
	send_email_comment($pdo, $image_id, $user_id, $comment);
}
