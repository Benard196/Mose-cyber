<?php
session_start();
include "db.php";

$me = $_GET['user'];
$you = $_GET['with'];

$sql = "
SELECT * FROM messages
WHERE (sender_id='$me' AND receiver_id='$you')
OR (sender_id='$you' AND receiver_id='$me')
ORDER BY id ASC
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

if($row['sender_id'] == $me){
?>

<div class="msg-right">
<div class="bubble-me">
<?php echo $row['message']; ?>
</div>
</div>

<?php } else { ?>

<div class="msg-left">
<div class="bubble-you">
<?php echo $row['message']; ?>
</div>
</div>

<?php } } ?>