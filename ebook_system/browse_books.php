<?php
session_start();
include('db.php');
include('header.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
}

// ===========================
// FIXED QUERY (JOIN AUTHORS)
// ===========================
$sql = "SELECT 
            books.book_id,
            books.title,
            authors.author_name,
            categories.name AS category_name
        FROM books
        JOIN authors ON books.author_id = authors.author_id
        JOIN categories ON books.category = categories.category_id
        WHERE books.title LIKE '%$search_term%'
           OR authors.author_name LIKE '%$search_term%'
           OR categories.name LIKE '%$search_term%'";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="main">
    <div class="main-txt">
        <h2>Browse Books</h2>
        <p>Looking for something?</p>
    </div>
    <div class="main-action">
        <a href="upload_book.php">Upload Book</a>
    </div>
</div>

<form action="browse_books.php" method="POST">
    <input id="search-term" type="text" name="search_term"
           placeholder="Search by title, author, or category"
           value="<?php echo htmlspecialchars($search_term); ?>" required>
    <button id="search-btn" type="submit" name="search">Search</button>
</form>

<div class="books-result">
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='book-item'>";
        echo "<h3>{$row['title']}</h3>";
        echo "<p><strong>Author:</strong> {$row['author_name']}</p>";
        echo "<p><strong>Category:</strong> {$row['category_name']}</p>";
        echo "<a href='book_details.php?book_id={$row['book_id']}'>View</a>";
        echo "</div>";
    }
} else {
    echo "<p>No books found matching your search.</p>";
}
?>
</div>

</body>
</html>
