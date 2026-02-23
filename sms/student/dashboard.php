<?php
require_once "../session.php";
require_once "../db.php";

// student only
if($_SESSION['role'] != "Student"){
    header("Location: ../login.php");
    exit;
}

$student_id = $_SESSION['user_id'];

// get marks
$result = $conn->prepare("SELECT subject, mark FROM Marks WHERE student_id=?");
$result->execute([$student_id]);
$marks = $result->fetchAll(PDO::FETCH_ASSOC);

// function to calculate grade
function getGrade($m){
    if($m >= 90) return "A";
    if($m >= 80) return "B";
    if($m >= 70) return "C";
    if($m >= 60) return "D";
    return "F";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- my css -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="container mt-5">

<h2>Student Dashboard</h2>

<h3>My Marks</h3>

<table class="table table-bordered">
<tr>
    <th>Subject</th>
    <th>Mark</th>
    <th>Grade</th>
</tr>

<?php if(count($marks) == 0): ?>
<tr>
    <td colspan="3" class="text-center">No marks yet</td>
</tr>
<?php else: ?>
    <?php foreach($marks as $m): ?>
    <tr>
        <td><?php echo $m['subject']; ?></td>
        <td><?php echo $m['mark']; ?></td>
        <td><?php echo getGrade($m['mark']); ?></td>
    </tr>
    <?php endforeach; ?>
<?php endif; ?>

</table>

<br>

<a class="btn btn-secondary" href="change_password.php">Change Password</a>
<a class="btn btn-info" href="profile.php">Edit Profile</a>
<a class="btn btn-danger" href="../logout.php">Logout</a>

</body>
</html>