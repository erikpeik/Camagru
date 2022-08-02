<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION["user_id"])) {?>
	<script>
		alert('To accees the Account settings, you need to be logged in');
		window.location.href='login';
	</script>
<?php } ?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once 'frontend/head.html'; ?>
		<title>Account • Camagru</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/account.css">
	</head>
	<body>
		<?php include "frontend/header.php"; ?>
		<main>
			<?php
			try {
			include_once 'config/pdo.php';
			$sql = "SELECT `profile_picture` FROM users WHERE users_id = ?";
			$statement = $pdo->prepare($sql);
			$statement->execute([$_SESSION["user_id"]]);
			$profile_picture = $statement->fetchColumn();
			}
			catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
			print("<img style='border-radius: 50%;'src='data:image/jpeg;base64,$profile_picture'");
			?>
		</main>
		<?php include "frontend/footer.html"; ?>
	</body>
</html>
