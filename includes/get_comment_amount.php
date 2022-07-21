<?php

require_once '../config/pdo.php';

if (isset($_POST['image_id'])) {
	$image_id = $_POST['image_id'];
	$sql = "SELECT COUNT(*) AS count FROM `comments` WHERE `image_id` = ?;";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($image_id))) {
		$statement = null;
		header('location: ../index.php?msg=error');
		exit();
	}
	$data = $statement->fetch(PDO::FETCH_ASSOC);
	echo $data['count'];
}
