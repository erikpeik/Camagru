<?php
	include 'database.php';
	$dsn = 'mysql:host='.$DB_HOST;
	try {
		$mysql = new PDO($dsn, $DB_USER, $DB_PASSWORD);
		$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'CREATE DATABASE IF NOT EXISTS '.$DB_NAME;
		$mysql->exec($sql	);
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
