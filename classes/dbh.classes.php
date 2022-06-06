<?php
class Dbh {
	protected function connect() {
		try {
			include '../config/database.php';
			$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
			return $dbh;
		}
		catch (PDOException $e) {
			print("Error!: " . $e->getMessage() . "<br/>");
		}
	}
}
