<?php
require_once "../session.php";
require_once "../db.php";

if($_SESSION['role'] != "Student"){
    header("Location: ../login.php");
    exit;
}

$message = "";
$type = "";

$id = $_SESSION['user_id'];

/* get student data */
$result = $conn->prepare("SELECT name,email,class_id FROM Users WHERE id=?");
$result->execute([$id]);
$user = $result->fetch(PDO::FETCH_ASSOC);

/* get classes */
$cls = $conn->query("SELECT id,class_name FROM Classes");
$classes = $cls->fetchAll(PDO::FETCH_ASSOC);


/* update profile */
if(isset($_POST['update'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $class_id = $_POST['class_id'];

    if($name=="" || $email==""){
        $message = "All fields required";
        $type="error";
    }else{

        // check email if changed
        $check = $conn->prepare("SELECT id FROM Users WHERE email=? AND id!=?");
        $check->execute([$email,$id]);

        if($check->fetch()){
            $message="Email already used";
            $type="error";
        }else{

            $update=$conn->prepare("UPDATE Users SET name=?,email=?,class_id=? WHERE id=?");
            $update->execute([$name,$email,$class_id,$id]);

            $message="Profile updated";
            $type="success";

            // refresh data
            $user['name']=$name;
            $user['email']=$email;
            $user['class_id']=$class_id;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- my css -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="container mt-5">

<h2>Edit Profile</h2>

<?php if($message!=""): ?>
<p style="color:<?php echo $type=='success' ? 'green' : 'red'; ?>">
    <?php echo $message; ?>
</p>
<?php endif; ?>

<form method="post">

Name:<br>
<input type="text" name="name" value="<?php echo $user['name']; ?>"><br><br>

Email:<br>
<input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>

Class:<br>
<select name="class_id">
<?php foreach($classes as $c): ?>
<option value="<?php echo $c['id']; ?>"
<?php if($c['id']==$user['class_id']) echo "selected"; ?>>
<?php echo $c['class_name']; ?>
</option>
<?php endforeach; ?>
</select><br><br>

<button name="update">Save Changes</button>

</form>

<br>
<a href="dashboard.php">Back</a>

</body>
</html>