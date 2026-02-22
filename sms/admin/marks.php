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

/* ADD OR UPDATE MARK */
if(isset($_POST['assign_mark'])){

    $student = $_POST['student_id'];
    $subject = $_POST['subject'];
    $mark    = $_POST['mark'];

    if($mark < 0 || $mark > 100){
        $message = "Mark must be between 0 and 100";
        $type = "danger";
    }else{

        // check if mark exists
        $check = $conn->prepare("SELECT id FROM Marks WHERE student_id=? AND subject=?");
        $check->execute([$student,$subject]);

        if($check->fetch()){

            // UPDATE
            $update = $conn->prepare(
                "UPDATE Marks SET mark=? WHERE student_id=? AND subject=?"
            );
            $update->execute([$mark,$student,$subject]);

            $message = "Mark updated successfully";
            $type = "success";

        }else{

            // INSERT
            $insert = $conn->prepare(
                "INSERT INTO Marks(student_id,subject,mark) VALUES(?,?,?)"
            );

            $insert->execute([$student,$subject,$mark]);

            $message = "Mark added successfully";
            $type = "success";
        }
    }
}

/* GET STUDENTS */
$result = $conn->query("SELECT id,name FROM Users WHERE role='Student'");
$students = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Marks</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2 class="mb-4">Assign Marks</h2>

<?php if($message!=""): ?>
<div class="alert alert-<?php echo $type; ?>">
    <?php echo $message; ?>
</div>
<?php endif; ?>

<div class="card p-4 mb-4">
<form method="post">

    <div class="mb-3">
        <label class="form-label">Student</label>
        <select name="student_id" class="form-select">
            <?php foreach($students as $s): ?>
            <option value="<?php echo $s['id']; ?>">
                <?php echo htmlspecialchars($s['name']); ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Subject</label>
        <select name="subject" class="form-select">
            <option>English</option>
            <option>Maths</option>
            <option>Science</option>
            <option>Social Science</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Mark</label>
        <input type="number" name="mark" min="0" max="100" class="form-control">
    </div>

    <button name="assign_mark" class="btn btn-primary">Save</button>

</form>
</div>

<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

</body>
</html>