<?php
require_once "../session.php";
require_once "../db.php";

// admin only
if(!isset($_SESSION['role']) || $_SESSION['role'] != "Admin"){
    header("Location: ../login.php");
    exit;
}

// total students
$stmt = $conn->query("SELECT COUNT(*) FROM Users WHERE role='Student'");
$totalStudents = $stmt->fetchColumn();

// total classes
$stmt = $conn->query("SELECT COUNT(*) FROM Classes");
$totalClasses = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2 class="mb-3">Admin Dashboard</h2>
<p class="text-muted">Welcome Admin</p>

<hr>

<h4 class="mb-3">System Statistics</h4>

<div class="row mb-4">

    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5>Total Students</h5>
                <h3><?php echo $totalStudents; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5>Total Classes</h5>
                <h3><?php echo $totalClasses; ?></h3>
            </div>
        </div>
    </div>

</div>

<hr>

<h4 class="mb-3">Management</h4>

<div class="d-grid gap-2 col-4">
    <a href="classes.php" class="btn btn-primary">Manage Classes</a>
    <a href="students.php" class="btn btn-primary">Manage Students</a>
    <a href="marks.php" class="btn btn-primary">Manage Marks</a>
</div>

<br>

<a href="../logout.php" class="btn btn-danger">Logout</a>

</body>
</html>