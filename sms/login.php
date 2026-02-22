<?php
require_once "auth.php";

$error = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $result = loginUser($email, $password);

    if($result){
        $error = $result;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- your style -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="container mt-5">

<h2>Login</h2>

<form method="post">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>

<p style="color:red;"><?php echo $error; ?></p>

<p>Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>