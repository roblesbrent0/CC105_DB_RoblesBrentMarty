<?php
session_start();
include('db.php');

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$user_id = intval($_GET['user_id']);
$sql = "DELETE FROM users WHERE user_id = $user_id";
if ($conn->query($sql)) {
    header('Location: admin_dashboard.php');
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}
?>
