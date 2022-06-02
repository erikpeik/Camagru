<?php

class Dbh {
	protected function connect() {
		try {
			$username = 'root';
			$password = 'phppiscine';
			$dbh = new PDO('mysql:dbname=camagru_emende;host=localhost;port=3308', $username, $password);
			return $dbh;
		}
		catch (PDOException $e) {
			print("Error!: " . $e->getMessage() . "<br/>");
		}
	}
}
