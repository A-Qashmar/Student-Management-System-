<?php
require_once "../session.php";
require_once "../db.php";

// admin only
if(!isset($_SESSION['role']) || $_SESSION['role'] != "Admin"){
    header("Location: ../login.php");
    exit;
}

$message = "";
$type = "";

/* ADD STUDENT */
if(isset($_POST['add_student'])){

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $class_id = $_POST['class_id'];

    if($name=="" || $email=="" || $password==""){
        $message = "All fields required";
        $type = "danger";
    }else{

        // check email
        $check = $conn->prepare("SELECT id FROM Users WHERE email=?");
        $check->execute([$email]);

        if($check->fetch()){
            $message = "Email already used";
            $type = "danger";
        }else{

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare(
                "INSERT INTO Users(name,email,password,role,class_id) VALUES(?,?,?,?,?)"
            );

            $insert->execute([$name,$email,$hash,"Student",$class_id]);

            $message = "Student added successfully";
            $type = "success";
        }
    }
}

/* DELETE STUDENT */
if(isset($_POST['delete_student'])){
    $id = $_POST['student_id'];

    $delete = $conn->prepare("DELETE FROM Users WHERE id=? AND role='Student'");
    $delete->execute([$id]);

    $message = "Student deleted successfully";
    $type = "success";
}

/* GET STUDENTS */
$result = $conn->query("
    SELECT Users.id,Users.name,Users.email,Classes.class_name
    FROM Users
    LEFT JOIN Classes ON Users.class_id = Classes.id
    WHERE role='Student'
");
$students = $result->fetchAll(PDO::FETCH_ASSOC);

/* GET CLASSES */
$cls = $conn->query("SELECT id,class_name FROM Classes");
$classes = $cls->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- my css -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="container mt-5">

<h2 class="mb-4">Manage Students</h2>

<?php if($message!=""): ?>
<div class="alert alert-<?php echo $type; ?>">
    <?php echo $message; ?>
</div>
<?php endif; ?>

<div class="card mb-4">
<div class="card-body">

<h5 class="mb-3">Add Student</h5>

<form method="post">

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="text" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Class</label>
        <select name="class_id" class="form-select">
            <?php foreach($classes as $c): ?>
            <option value="<?php echo $c['id']; ?>">
                <?php echo htmlspecialchars($c['class_name']); ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button name="add_student" class="btn btn-primary">Add Student</button>

</form>
</div>
</div>

<h4 class="mb-3">All Students</h4>

<table class="table table-bordered table-striped">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Class</th>
    <th width="120">Action</th>
</tr>

<?php foreach($students as $s): ?>
<tr>
    <td><?php echo $s['id']; ?></td>
    <td><?php echo htmlspecialchars($s['name']); ?></td>
    <td><?php echo htmlspecialchars($s['email']); ?></td>
    <td><?php echo $s['class_name'] ? htmlspecialchars($s['class_name']) : 'No Class'; ?></td>
    <td>
        <form method="post" onsubmit="return confirm('Delete this student?')">
            <input type="hidden" name="student_id" value="<?php echo $s['id']; ?>">
            <button name="delete_student" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

</body>
</html>