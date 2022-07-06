<?php
session_start();
ob_start();

include 'config/setup.php';
include_once "config/pdo.php";

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
		<?php include_once "frontend/header.php"; ?>
		<main>
			<?php
			$sql = "SELECT `images`.*, `users`.`users_name` FROM `images`
			LEFT JOIN `users`
			ON `images`.`users_id` = `users`.`users_id`;";
			$statement = $pdo->prepare($sql);
			if (!$statement->execute()) {
				$statement = null;
				header('location: ../index.php?msg=statement_failed');
				exit();
			}
			$data = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach ($data as $image) {
				?>
				<div class="image-div">
					<div id='top-bar'>
						<h1><?= $image['users_name'] ?></h1>
					</div>
					<img id='image-settings' src="data:image/jpg;charset=utf8;base64,<?= base64_encode($image['image']) ?>"/>
					<div id='like-row'>

						<?php
							$sql = "SELECT COUNT(*) as `count` FROM `likes` WHERE `users_id` = ? AND `image_id` = ?";
							$statement = $pdo->prepare($sql);
							if (!$statement->execute(array($_SESSION["user_id"], $image['image_id']))) {
								$statement = null;
								header('location: ../index.php?msg=error');
								exit();
							}
							$data = $statement->fetch(PDO::FETCH_ASSOC);
							$like_count = $data['count'];
						?>

						<span onclick="add_like(<?=$image['image_id'];?>)">
						<?php if ($like_count == 0) { ?>
							<i id="like_button_<?= $image['image_id'] ?>" class="fa-regular fa-heart"></i>
							<?php } else { ?>
							<i id="like_button_<?= $image['image_id'] ?>" style="color: #ED4956;" class="fa-solid fa-heart"></i>
							<?php } ?>
						</span>
						<i class="fa-regular fa-comment"></i>
					</div>
					<p id='like-text'><span id='like_count_<?= $image['image_id']; ?>'>
					<?php
						$sql = "SELECT COUNT(*) as `count` FROM `likes` WHERE `image_id` = ?";
						$statement = $pdo->prepare($sql);
						if (!$statement->execute(array($image['image_id']))) {
							$statement = null;
							header('location: ../index.php?msg=error');
							exit();
						}
						$data = $statement->fetch(PDO::FETCH_ASSOC);
						echo $data['count'];
					?>
					</span> likes</p>
					<b id='name-left'><?= $image['users_name'] ?></b> <p><?= $image['caption'] ?></p>
				</div>
				<?php
				$i++;
			}
			?>
		</main>
		<script src='js/like.js'></script>
		<?php
		include 'frontend/footer.html';
		?>
	</body>
</html>
