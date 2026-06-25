<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location:index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT messages.*,
       users.fullname
FROM messages
INNER JOIN users
ON messages.receiver_id = users.id
WHERE messages.sender_id = '$user_id'
ORDER BY messages.id DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Sent Messages</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>Sent Messages</h2>

<a href="dashboard.php" class="btn btn-secondary mb-3">
Back Dashboard
</a>

<?php
if($result->num_rows == 0){
    echo "<div class='alert alert-info'>No sent messages yet</div>";
}
?>

<?php while($row = $result->fetch_assoc()){ ?>

<div class="card mb-3">

<div class="card-body">

<h5>
To: <?php echo $row['fullname']; ?>
</h5>

<hr>

<p>
<?php echo nl2br($row['message']); ?>
</p>

<?php if(!empty($row['file_name'])){ ?>

<a href="uploads/<?php echo $row['file_name']; ?>" target="_blank" class="btn btn-success btn-sm">
View File
</a>

<?php } ?>

<br><br>

<small>
<?php echo $row['created_at']; ?>
</small>

</div>

</div>

<?php } ?>

</div>

</body>
</html>