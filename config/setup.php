<?php
	include 'database.php';
	$dsn = 'mysql:host='.$DB_HOST;
	try {
		$mysql = new PDO($dsn, $DB_USER, $DB_PASSWORD);
		$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'CREATE DATABASE IF NOT EXISTS '.$DB_NAME;
		$mysql->exec($sql);
	}
	catch (PDOException $e) {
		print("Error!: " . $e->getMessage() . "<br/>");
	}
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	$sql = "CREATE TABLE IF NOT EXISTS users (
			users_id int(11) AUTO_INCREMENT PRIMARY KEY not null,
			users_name TINYTEXT not null,
			users_uid TINYTEXT not null,
			users_pwd LONGTEXT not null,
			users_email TINYTEXT not null,
			is_admin TINYINT(1) not null DEFAULT 0,
			active TINYINT(1) DEFAULT 0,
			activation_code VARCHAR(255) not null,
			activation_expiry DATETIME not null,
			activated_at DATETIME DEFAULT 0,
			created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
			updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
		);";
	$db->exec($sql);

#	const APP_URL = 'https://localhost:8080/auth'
