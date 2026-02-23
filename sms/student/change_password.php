<?php
require_once "../session.php";
require_once "../db.php";

// student only
if($_SESSION['role'] != "Student"){
    header("Location: ../login.php");
    exit;
}

$message = "";
$type = "";

if(isset($_POST['change'])){

    $old = trim($_POST['old_password']);
    $new = trim($_POST['new_password']);

    if($old=="" || $new==""){
        $message = "All fields required";
        $type = "error";
    }else{

        // get current password
        $result = $conn->prepare("SELECT password FROM Users WHERE id=?");
        $result->execute([$_SESSION['user_id']]);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if(!$user || !password_verify($old, $user['password'])){
            $message = "Old password incorrect";
            $type = "error";
        }else{

            $hash = password_hash($new, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE Users SET password=? WHERE id=?");
            $update->execute([$hash,$_SESSION['user_id']]);

            $message = "Password updated";
            $type = "success";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- my css -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="container mt-5">

<h2>Change Password</h2>

<form method="post">
Old Password:<br>
<input type="password" name="old_password"><br><br>

New Password:<br>
<input type="password" name="new_password"><br><br>

<button name="change">Update Password</button>
</form>

<?php if($message!=""): ?>
<p style="color:<?php echo $type=='success' ? 'green' : 'red'; ?>">
    <?php echo $message; ?>
</p>
<?php endif; ?>

<a href="dashboard.php">Back</a>

</body>
</html>