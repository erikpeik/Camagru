<?php

ob_start();

function get_comment_amount($pdo, $image_id) {
	$sql = "SELECT COUNT(*) as `count` FROM `comments` WHERE `image_id` = ?";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array($image_id))) {
		$statement = null;
		header('location: ../index.php?msg=error');
		exit();
	}
	$data = $statement->fetch(PDO::FETCH_ASSOC);
	return $data['count'];
}
