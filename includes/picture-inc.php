<?php

function get_photo_info($pdo, $photo_id) {
	try {
		$sql = "SELECT `images`.*, `users`.`users_name`, `users`.`users_uid`
		FROM `images`
		LEFT JOIN `users`
		ON `images`.`users_id` = `users`.`users_id`
		WHERE image_id = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$photo_id]);
		$photo_info = $statement->fetch();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $photo_info;
}
