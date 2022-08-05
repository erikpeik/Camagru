<?php

function check_username($pdo, $username) {
	$sql = "SELECT * FROM `users` WHERE `users_uid` = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$username]);
	$result = $statement->fetchAll();
	return (count($result) > 0);
}
