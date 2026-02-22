<?php
session_start();
require_once "db.php";

// login function
function loginUser($email, $password)
{
    global $conn;

    $sql = "SELECT * FROM Users WHERE email = ?";
    $result = $conn->prepare($sql);
    $result->execute([$email]);

    $user = $result->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        return "Invalid email or password";
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == "Admin") {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: student/dashboard.php");
    }
    exit;
}