<?php
session_start();
include "db.php";

/* Protect page */
if(!isset($_SESSION['user_id'])){
    header("Location:index.php");
    exit();
}

if(isset($_POST['send'])){

    $sender = $_SESSION['user_id'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];

    $file = "";

    /* =========================
       FILE UPLOAD SECTION
    ========================== */

    if(!empty($_FILES['file']['name'])){

        $uploadDir = "uploads/";

        // Create uploads folder if not exists
        if(!file_exists($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        // Clean filename (remove spaces & special characters)
        $originalName = basename($_FILES['file']['name']);
        $cleanName = preg_replace("/[^a-zA-Z0-9.\-_]/", "_", $originalName);

        // Unique file name
        $file = time() . "_" . $cleanName;

        $targetPath = $uploadDir . $file;

        // Move file safely
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)){
            die("❌ File upload failed. Check uploads folder permissions.");
        }
    }

    /* =========================
       SAVE MESSAGE TO DATABASE
    ========================== */

    $sql = "INSERT INTO messages (sender_id, receiver_id, message, file_name)
            VALUES ('$sender', '$receiver', '$message', '$file')";

    if($conn->query($sql)){
        echo "<p style='color:green;'>✔ Message Sent Successfully</p>";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
</head>
<body>

<h2>Send Message</h2>

<form method="POST" enctype="multipart/form-data">

    <!-- Select receiver -->
    <select name="receiver" required>

        <option value="">Select User</option>

        <?php
        $users = $conn->query("SELECT * FROM users WHERE id != '".$_SESSION['user_id']."'");

        while($u = $users->fetch_assoc()){
        ?>

        <option value="<?php echo $u['id']; ?>">
            <?php echo $u['fullname']; ?>
        </option>

        <?php } ?>

    </select>

    <br><br>

    <!-- Message -->
    <textarea name="message" placeholder="Type message..." required></textarea>

    <br><br>

    <!-- File upload -->
    <input type="file" name="file">

    <br><br>

    <button type="submit" name="send">
        Send Message
    </button>

</form>

<br>

<a href="dashboard.php">Back Dashboard</a>

</body>
</html>