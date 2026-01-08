<?php
session_start();
include('db.php');

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$book_id = intval($_GET['book_id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $category = $conn->real_escape_string($_POST['category']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "UPDATE books SET title = '$title', author = '$author', category = '$category', description = '$description' WHERE book_id = $book_id";
    if ($conn->query($sql)) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = "Error updating book: " . $conn->error;
    }
}

// Fetch book details
$sql = "SELECT * FROM books WHERE book_id = $book_id";
$result = $conn->query($sql);
$book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1 id="admin-t">Edit Book</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="edit_book.php?book_id=<?php echo $book_id; ?>" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
        <label for="author">Author:</label>
        <input type="text" name="author" value="<?php echo $book['author']; ?>" required>
        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo $book['category']; ?>" required>
        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $book['description']; ?></textarea>
        <button type="submit">Update Book</button>
    </form>
    <a href="admin_dashboard.php" class="back">Back to Home</a>
</body>
</html>
