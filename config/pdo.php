<?php
include_once 'database.php';
include_once '../config/database.php';
print("<br>".$_SERVER['DOCUMENT_ROOT'].'/camagru/config/database.php'."<br");
include_once $_SERVER['DOCUMENT_ROOT'].'/camagru/config/database.php';
print("DSN: $DN_SDN");
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
