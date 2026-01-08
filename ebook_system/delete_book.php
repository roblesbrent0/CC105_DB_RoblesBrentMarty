<?php
session_start();
include('db.php');

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$book_id = intval($_GET['book_id']);
$sql = "DELETE FROM books WHERE book_id = $book_id";
if ($conn->query($sql)) {
    header('Location: admin_dashboard.php');
    exit();
} else {
    echo "Error deleting book: " . $conn->error;
}
?>
