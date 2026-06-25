<?php
session_start();
include "db.php";

$user = $_SESSION['user_id'];

$conn->query("
UPDATE users
SET last_seen = NOW()
WHERE id = '$user'
");
?>