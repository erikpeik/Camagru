<script>
	function does_users_id_match(users_id) {
		<?php if (isset($_SESSION) && isset($_SESSION['user_id'])) { ?>
		if (users_id != null && users_id == <?= $_SESSION['user_id'] ?>) {
			return true;
		} else {
			return false;
		}
		<?php } else { ?>
			return false;
		<?php } ?>
	}
</script>
