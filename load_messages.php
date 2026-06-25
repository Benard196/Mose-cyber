<?php
session_start();
include "db.php";

$user = $_SESSION['user_id'];
$receiver = $_GET['id'];

$sql = "
SELECT *
FROM messages
WHERE
(sender_id='$user' AND receiver_id='$receiver')
OR
(sender_id='$receiver' AND receiver_id='$user')
ORDER BY id ASC
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

if($row['sender_id']==$user){

echo "
<div style='text-align:right'>
<b>You:</b>
".$row['message']."
</div><hr>";

}else{

echo "
<div>
<b>Friend:</b>
".$row['message']."
</div><hr>";

}
}
?>