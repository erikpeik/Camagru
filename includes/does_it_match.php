<?php

require_once "../config/pdo.php";

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['user_id']) && isset($_POST['users_id']) && isset($_POST['image_id'])) {
	$sql = "SELECT * FROM `images` WHERE `image_id` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$_POST['image_id']]);
	$comment = $statement->fetch(PDO::FETCH_ASSOC);
	if ($_POST['users_id'] == $_SESSION['user_id']) {
		echo "true";
		return ;
	}
	if ($comment['users_id'] == $_SESSION['user_id']) {
		echo "true";
		return ;
	}

}
echo "false";
return ;

?>
