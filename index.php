<?php
session_start();
include "db.php";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE username='$username' 
            AND password='$password'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];

        header("Location: dashboard.php");
        exit();

    }else{
        $error = "Wrong Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cyber System Login</title>
</head>
<body>

<h2>Cyber System Login</h2>

<?php
if(isset($error)){
    echo "<p style='color:red'>$error</p>";
}
?>

<form method="POST">

    <input type="text"
           name="username"
           placeholder="Username"
           required>

    <br><br>

    <input type="password"
           name="password"
           placeholder="Password"
           required>

    <br><br>

    <button type="submit" name="login">
        Login
    </button>

</form>

</body>
</html>