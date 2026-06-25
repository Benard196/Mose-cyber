<?php
include "db.php";

$msg = "";

if(isset($_POST['register'])){

$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "INSERT INTO users
(fullname,username,password)
VALUES
('$fullname','$username','$password')";

if($conn->query($sql)){
$msg = "User Registered Successfully";
}
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Register User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Register New User</h2>

<?php
if($msg!=""){
echo "<div class='alert alert-success'>$msg</div>";
}
?>

<form method="POST">

<div class="mb-3">

<label>Full Name</label>

<input
type="text"
name="fullname"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
name="register"
class="btn btn-primary">

Register User

</button>

<a href="dashboard.php"
class="btn btn-secondary">

Dashboard

</a>

</form>

</div>

</body>
</html>