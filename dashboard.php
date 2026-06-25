<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location:index.php");
    exit();
}

$my_id = $_SESSION['user_id'];

$search = $_GET['search'] ?? "";
?>

<!DOCTYPE html>
<html>
<head>

<title>WhatsApp Style Dashboard</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#111b21;
    color:white;
}

.container{
    display:flex;
    height:100vh;
}

/* LEFT PANEL */
.left{
    width:30%;
    background:#202c33;
    overflow-y:auto;
}

.search{
    padding:10px;
}

.search input{
    width:100%;
    padding:10px;
    border:none;
    border-radius:5px;
}

/* USER ITEM */
.user{
    display:flex;
    align-items:center;
    padding:10px;
    border-bottom:1px solid #2a3942;
    cursor:pointer;
}

.user:hover{
    background:#2a3942;
}

.dot{
    width:10px;
    height:10px;
    border-radius:50%;
    margin-right:8px;
}

.name{
    flex:1;
}

/* RIGHT PANEL */
.right{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#aaa;
}

a{
    text-decoration:none;
    color:white;
}

</style>

</head>

<body>

<div class="container">

<!-- LEFT SIDE -->
<div class="left">

<div class="search">

<form method="GET">

<input type="text"
name="search"
placeholder="Search users..."
value="<?php echo $search; ?>">

</form>

</div>

<?php

if($search != ""){
    $users = $conn->query("
        SELECT * FROM users
        WHERE fullname LIKE '%$search%'
        AND id != '$my_id'
    ");
}else{
    $users = $conn->query("
        SELECT * FROM users
        WHERE id != '$my_id'
    ");
}

while($u = $users->fetch_assoc()){

$online = (strtotime($u['last_seen']) > time() - 10);

?>

<a href="chat.php?id=<?php echo $u['id']; ?>">

<div class="user">

<div class="dot" style="background:<?php echo $online?'green':'gray'; ?>"></div>

<div class="name">
<strong><?php echo $u['fullname']; ?></strong>
<br>
<small style="color:#aaa;">
<?php echo date("H:i", strtotime($u['last_seen'])); ?>
</small>
</div>

</div>

</a>

<?php } ?>

</div>

<!-- RIGHT SIDE -->
<div class="right">

<h2>Select a chat to start messaging</h2>

</div>

</div>

</body>
</html>