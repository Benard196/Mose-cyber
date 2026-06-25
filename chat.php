<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location:index.php");
    exit();
}

$my_id = $_SESSION['user_id'];
$chat_with = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Chat</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#0b141a;
    color:white;
}

.header{
    background:#202c33;
    padding:10px;
}

.chat-box{
    height:80vh;
    overflow:auto;
    padding:10px;
}

.me{
    text-align:right;
    margin:5px;
}

.you{
    text-align:left;
    margin:5px;
}

.bubble-me{
    background:#005c4b;
    display:inline-block;
    padding:10px;
    border-radius:10px;
    max-width:70%;
}

.bubble-you{
    background:#202c33;
    display:inline-block;
    padding:10px;
    border-radius:10px;
    max-width:70%;
}

form{
    display:flex;
    background:#202c33;
}

input{
    flex:1;
    padding:10px;
    border:none;
    outline:none;
}

button{
    padding:10px;
    background:#00a884;
    border:none;
    color:white;
}

</style>

<script>

function loadChat(){
    fetch("load_chat.php?user=<?php echo $my_id; ?>&with=<?php echo $chat_with; ?>")
    .then(r=>r.text())
    .then(d=>{
        document.getElementById("box").innerHTML = d;
    });
}

setInterval(loadChat,1000);
window.onload = loadChat;

</script>

</head>

<body>

<div class="header">
Chatting...
</div>

<div class="chat-box" id="box"></div>

<form action="send_chat.php" method="POST">

<input type="hidden" name="receiver" value="<?php echo $chat_with; ?>">

<input type="text" name="message" placeholder="Type a message..." required>

<button>Send</button>

</form>

</body>
</html>