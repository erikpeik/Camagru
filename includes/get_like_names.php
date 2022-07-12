<?php

ob_start();
header('Content-type: application/json');
ob_clean();

require '../config/pdo.php';

if (isset($_POST['image_id'])) {
	$image_id = $_POST['image_id'];
	$sql = "SELECT `users`.`users_name`, `users`.`users_uid`
			FROM `likes`
			INNER JOIN `users`
			ON `users`.`users_id` = `likes`.`users_id`
			WHERE `likes`.`image_id` = ?;";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($image_id))) {
		$statement = null;
		header('location: ../index.php?msg=error');
		exit();
	}
	$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
