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

/* ADD CLASS */
if(isset($_POST['add_class'])){

    $name = trim($_POST['class_name']);

    if($name==""){
        $message = "Class name required";
        $type = "danger";
    }else{

        // check duplicate
        $check = $conn->prepare("SELECT id FROM Classes WHERE class_name=?");
        $check->execute([$name]);

        if($check->fetch()){
            $message = "Class already exists";
            $type = "danger";
        }else{
            $insert = $conn->prepare("INSERT INTO Classes(class_name) VALUES(?)");
            $insert->execute([$name]);
            $message = "Class added successfully";
            $type = "success";
        }
    }
}

/* DELETE CLASS */
if(isset($_POST['delete_class'])){
    $id = $_POST['class_id'];

    $delete = $conn->prepare("DELETE FROM Classes WHERE id=?");
    $delete->execute([$id]);

    $message = "Class deleted successfully";
    $type = "success";
}

/* GET CLASSES */
$result = $conn->query("SELECT * FROM Classes ORDER BY id DESC");
$classes = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- my css -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="container mt-5">

<h2 class="mb-4">Manage Classes</h2>

<?php if($message!=""): ?>
<div class="alert alert-<?php echo $type; ?>">
    <?php echo $message; ?>
</div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-body">
        <h5>Add New Class</h5>

        <form method="post" class="d-flex gap-2">
            <input type="text" name="class_name" class="form-control" placeholder="Enter class name" required>
            <button name="add_class" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>

<h4>All Classes</h4>

<table class="table table-bordered table-striped">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th width="120">Action</th>
</tr>

<?php foreach($classes as $c): ?>
<tr>
    <td><?php echo $c['id']; ?></td>
    <td><?php echo htmlspecialchars($c['class_name']); ?></td>
    <td>
        <form method="post" onsubmit="return confirm('Delete this class?')">
            <input type="hidden" name="class_id" value="<?php echo $c['id']; ?>">
            <button name="delete_class" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

</body>
</html>