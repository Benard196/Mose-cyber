<?php
session_start();
include "db.php";

$receiver = $_GET['id'];

if(isset($_POST['reply'])){

    $sender = $_SESSION['user_id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages
    (sender_id,receiver_id,message)
    VALUES
    ('$sender','$receiver','$message')";

    if($conn->query($sql)){
        echo "Reply Sent";
    }
}
?>

<h2>Reply Message</h2>

<form method="POST">

<textarea
name="message"
rows="5"
cols="40"
required></textarea>

<br><br>

<button name="reply">Send Reply</button>

</form>

<br>

<a href="inbox.php">Back Inbox</a>