<?php

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_POST['login']) && $_POST['login'] == 'guest') {
	$_SESSION['user_uid'] = 'guest';
	$_SESSION['user_id'] = -1;
}
