<?php
session_start();

// redirect if not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}