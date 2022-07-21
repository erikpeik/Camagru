<div class="image-div" id="image_<?=$image['image_id']?>">
	<div id='top-bar'>
		<p><?= $image['users_uid'] ?></p>
		<?php if ($image['users_id'] == $_SESSION['user_id']) { ?>
		<button onclick="remove_image(<?= $image['image_id'];?>)">
			Remove <i class="fa-solid fa-trash-alt"></i>
		</button>
		<?php } ?>
	</div>
	<img id='image-settings' src="data:image/jpg;charset=utf8;base64,<?= base64_encode($image['image']) ?>"/>
	<div id='like-row'>
		<?php
			$like_count = check_if_user_liked_picture($pdo, $image['image_id']);
		?>
		<span id='hover-button' onclick="add_like(<?=$image['image_id'];?>)">
		<?php if ($like_count == 0) { ?>
			<i id="like_button_<?= $image['image_id'] ?>" class="fa-regular fa-heart"></i>
			<?php } else { ?>
			<i id="like_button_<?= $image['image_id'] ?>" style="color: #ED4956;" class="fa-solid fa-heart"></i>
			<?php } ?>
		</span>
		<span id='hover-button' onclick="focus_comment(<?=$image['image_id'];?>)">
			<i class="fa-regular fa-comment"></i>
		</span>
	</div>
	<button id='like-text' onclick="show_likes(<?= $image['image_id']; ?>)"><span id='like_count_<?= $image['image_id']; ?>'>
	<?php
		$data = get_image_likes($pdo, $image['image_id']);
		echo $data['count'];
	?>
	</span> likes</button>
	<b id='name-left'><?= $image['users_name'] ?></b> <p><?= $image['caption'] ?></p>
	<?php
	$comment_count = get_comment_amount($pdo, $image['image_id']);
	?>
	<button class='comment-amount' onclick="get_comments(<?= $image['image_id'] ?>)">View all <span id='comment_amount_<?= $image['image_id'] ?>'>
				<?= $comment_count ?>
		</span> comments</button>

	<div id='comments_<?= $image['image_id'] ?>'></div>
	<h5 id='time-ago'>
		<?= time_elapsed_string($image['posted_at']);?>
	</h5>
	<div id='send-comment'>
			<form method='post' action=''>
				<div class='input-container'>
					<textarea id='comment_<?= $image['image_id'] ?>'
					placeholder='Add a comment...' name='comment' oninput="auto_grow(this.form)" required></textarea>
					<input type='submit' value='Post' onClick="add_comment(this.form, <?=$image['image_id'];?>); return false;">
				</div>
			</form>
	</div>
</div>
