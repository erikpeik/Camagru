<script>
	function does_users_id_match(users_id) {
		if (users_id == <?= $_SESSION['user_id'] ?>) {
			return true;
		} else {
			return false;
		}
	}
</script>
