<?php

require_once '../config/pdo.php';

if (isset($_POST['image_id'])) {
	// Get all the comments for the image_id
	$image_id = $_POST['image_id'];
	$sql = "SELECT u.`users_name`, u.`users_uid`, c.`comment`, c.`posted_at`
			FROM `comments` as c
			INNER JOIN `users` as u
			ON u.`users_id` = c.`users_id`
			WHERE c.`image_id` = ?
			ORDER BY c.`posted_at` ASC;";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($image_id))) {
		$statement = null;
		header('location: ../index.php?msg=error');
		exit();
	}
	$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
