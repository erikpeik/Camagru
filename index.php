<?php
session_start();
ob_start();

include 'config/setup.php';

if (!isset($_SESSION["user_id"])) {
	header("Location: login.php");
}
if (isset($_GET['logout'])) {
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_uid"]);
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.html'; ?>
		<title>Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<?php include_once "frontend/header.php";
		include_once "config/pdo.php";

		$sql = "SELECT * FROM `images`;";
		$statement = $pdo->prepare($sql);
		if (!$statement->execute()) {
			$statement = null;
			header('location: ../index.php?msg=statement_failed');
			exit();
		}
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data as $image) {
			print('<img src="data:image/jpg;charset=utf8;base64,'.base64_encode($image['image']).'"/>');
		}
		?>

	</body>
</html>
