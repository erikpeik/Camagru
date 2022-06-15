<?php

include_once '../config/pdo.php';

if (isset($_POST['img'])) {
	$sql = "INSERT INTO `images` (`image_id`, `users_id`, `image`)
			VALUES (NULL, ?, ?);";
	$statement = $pdo->prepare($sql);
	if (!$statement->execute(array('101', $_POST['img']))) {
		$statement = null;
		header('location: ../camera.php?msg=error');
		exit();
	}
	print ($_POST['img']);
}
