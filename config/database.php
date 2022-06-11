<?php
	$DB_USER = 'erikpeik_root';
	$DB_PASSWORD = 'phppiscine1';
	$DB_HOST = "127.0.0.1";
	$DB_PORT = '3306';
	$DB_NAME = 'erikpeik_camagru';
	$DB_DSN = "mysql:dbname=$DB_NAME;host=$DB_HOST;port=$DB_PORT";
	$DB_OPT = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	];
