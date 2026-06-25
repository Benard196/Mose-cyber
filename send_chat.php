<?php
session_start();
include "db.php";

$sender = $_SESSION['user_id'];
$receiver = $_POST['receiver'];
$message = $_POST['message'];

$file = "";

/* FILE UPLOAD */
if(!empty($_FILES['file']['name'])){

    $dir = "uploads/";

    if(!file_exists($dir)){
        mkdir($dir, 0777, true);
    }

    $clean = preg_replace("/[^a-zA-Z0-9.\-_]/","_",$_FILES['file']['name']);

    $file = time()."_".$clean;

    move_uploaded_file($_FILES['file']['tmp_name'],$dir.$file);
}

$conn->query("
INSERT INTO messages (sender_id,receiver_id,message,file_name)
VALUES ('$sender','$receiver','$message','$file')
");

header("Location: chat.php?id=".$receiver);
?>