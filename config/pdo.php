<?php
include_once 'database.php';
include_once '../config/database.php';

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
