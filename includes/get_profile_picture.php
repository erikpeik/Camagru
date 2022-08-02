<?php

if (!isset($_SESSION)) {
	session_start();
}

function get_profile_picture($pdo) {

	try {
		$sql = "SELECT `profile_picture` FROM users WHERE users_id = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute([$_SESSION["user_id"]]);
		$fetch = $statement->fetchColumn();
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit ();
	}

	$profile_picture = "data:image/jpeg;base64," . $fetch;

	return $profile_picture;
}
