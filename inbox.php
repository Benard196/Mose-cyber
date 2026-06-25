<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location:index.php");
    exit();
}

include "db.php";

$user_id = $_SESSION['user_id'];

/* Mark messages as read */

$conn->query("
UPDATE messages
SET is_read = 1
WHERE receiver_id = '$user_id'
");

/* Load inbox messages */

$sql = "
SELECT messages.*,
       users.fullname
FROM messages
INNER JOIN users
ON messages.sender_id = users.id
WHERE messages.receiver_id = '$user_id'
ORDER BY messages.id DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Inbox</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

    <h2>My Inbox</h2>

    <a href="dashboard.php" class="btn btn-secondary mb-3">
        Dashboard
    </a>

    <?php
    if($result->num_rows == 0){
        echo "
        <div class='alert alert-info'>
        No messages available.
        </div>";
    }
    ?>

    <?php while($row = $result->fetch_assoc()) { ?>

    <div class="card mb-3">

        <div class="card-header">

            <strong>
                From:
                <?php echo htmlspecialchars($row['fullname']); ?>
            </strong>

        </div>

        <div class="card-body">

            <p>
                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
            </p>

            <?php if(!empty($row['file_name'])) { ?>

                <a
                href="uploads/<?php echo urlencode($row['file_name']); ?>"
                target="_blank"
                class="btn btn-success btn-sm">

                Open Attachment

                </a>

                <br><br>

            <?php } ?>

            <small class="text-muted">
                <?php echo $row['created_at']; ?>
            </small>

            <br><br>

            <a
            href="chat.php?id=<?php echo $row['sender_id']; ?>"
            class="btn btn-primary">

            Open Chat

            </a>

        </div>

    </div>

    <?php } ?>

</div>

</body>
</html>