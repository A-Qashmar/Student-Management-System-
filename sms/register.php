<?php
require_once "db.php";

$message = "";

// get classes
$result = $conn->query("SELECT id, class_name FROM Classes");
$classes = $result->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $class_id = $_POST['class_id'];

    if($name=="" || $email=="" || $password==""){
        $message = "All fields required";
    }else{

        $check = $conn->prepare("SELECT id FROM Users WHERE email=?");
        $check->execute([$email]);

        if($check->fetch()){
            $message = "Email already registered";
        }else{

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare(
                "INSERT INTO Users (name,email,password,role,class_id) VALUES (?,?,?,?,?)"
            );

            $insert->execute([$name,$email,$hash,"Student",$class_id]);

            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- your style -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="container mt-5">

<h2>Student Register</h2>

<form method="post">
Name:<br>
<input type="text" name="name"><br><br>

Email:<br>
<input type="email" name="email"><br><br>

Password:<br>
<input type="password" name="password"><br><br>

Class:<br>
<select name="class_id">
<?php foreach($classes as $c): ?>
<option value="<?php echo $c['id']; ?>">
    <?php echo $c['class_name']; ?>
</option>
<?php endforeach; ?>
</select><br><br>

<button name="register">Create Account</button>
</form>

<p style="color:red;"><?php echo $message; ?></p>
<a href="login.php">Back to login</a>

</body>
</html>