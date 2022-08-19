<?php

require_once 'profile-inc.php';
require_once '../config/pdo.php';

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['user_id'])) {
	$fetch = get_users_images($pdo, $_SESSION['user_id']);
	for ($i = 0; $i < count($fetch); $i++) {
		$fetch[$i];
		for ($j = 0; $j < count($fetch[$i]); $j++) {
			unset($fetch[$i][$j]);
		}
		$fetch[$i]['image'] = base64_encode($fetch[$i]['image']);
	}
	// print_r($fetch);
	$result = json_encode($fetch);
	if ($result == false) {
		echo "Error!";
		exit ();
	}
	echo $result;
}

