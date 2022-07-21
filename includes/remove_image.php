<?php

session_start();
include_once '../config/pdo.php';

if (isset($_POST['image_id']) && isset($_SESSION['user_id'])) {
	$image_id = $_POST['image_id'];
	$user_id = $_SESSION['user_id'];
	try {
		$sql = "SELECT COUNT(*) as `count` FROM images WHERE image_id = ? AND users_id = ?;";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($image_id, $user_id))) {
			$statement = null;
			print("Statement failed");
			return(0);
		}
		$result = $statement->fetch(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
	if ($result['count'] > 0) {
		// Deleting image
		try {
		$sql = "DELETE FROM images WHERE image_id = ? AND users_id = ?;";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute(array($image_id, $user_id))) {
			$statement = null;
			print("Statement failed");
			return(0);
		}
		$statement = null;
		}
		catch (PDOException $e) {
			print("Error!: " . $e->getMessage() . "<br/>");
		}

		// Deleting likes of that image
		try {
			$sql = "DELETE FROM likes WHERE image_id = ?;";
			$statement = $pdo->prepare($sql);
			if (!$statement->execute(array($image_id))) {
				$statement = null;
				print("Statement failed");
				return(0);
			}
			$statement = null;
		}
		catch (PDOException $e) {
			print("Error!: " . $e->getMessage() . "<br/>");
		}

		// Deleting comments of that image
		try {
			$sql = "DELETE FROM comments WHERE image_id = ?;";
			$statement = $pdo->prepare($sql);
			if (!$statement->execute(array($image_id))) {
				$statement = null;
				print("Statement failed");
				return(0);
			}
			$statement = null;
		}
		catch (PDOException $e) {
			print("Error!: " . $e->getMessage() . "<br/>");
		}
	}
}
