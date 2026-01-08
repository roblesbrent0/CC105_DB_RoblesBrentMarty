<?php
session_start();
include('db.php');
include('header.php');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch book details
$book_id = intval($_GET['book_id']);
$sql = "SELECT books.*, categories.name 
        FROM books
        JOIN categories ON books.category = categories.category_id
        WHERE book_id = $book_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Book not found!";
    exit();
}

$book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $book['title']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="main">
        <div class="main-txt">
            <h2>Book View</h2>
        </div>
        <div class="main-action">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
    
    <div class="book-view">
        <div class="book-infor">
            <h2><?php echo $book['title']; ?></h2>
            <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
            <p><strong>Category:</strong> <?php echo $book['name']; ?></p>
            <p><strong>Description:</strong> <?php echo $book['description']; ?></p>
            <a href="<?php echo $book['file_path']; ?>" download>Download</a>
        </div>
        
        <div class="book-content">
        <iframe src="<?php echo $book['file_path']; ?>" allowfullscreen></iframe>
    </div>
    </div>
</body>
</html>
