<?php
session_start();
include('db.php');
include('header.php');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Search term
$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $conn->real_escape_string($_POST['search_term']);
}

// ✅ CORRECT JOIN QUERY (authors + categories)
$sql = "
SELECT 
    b.book_id,
    b.title,
    a.author_name,
    GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
FROM books b
JOIN authors a ON b.author_id = a.author_id
LEFT JOIN book_categories bc ON b.book_id = bc.book_id
LEFT JOIN categories c ON bc.category_id = c.category_id
WHERE 
    b.title LIKE '%$search_term%' 
    OR a.author_name LIKE '%$search_term%' 
    OR c.name LIKE '%$search_term%'
GROUP BY b.book_id
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<div class="main">
    <div class="main-txt">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
        <p>What's your plan for today?</p>
    </div>
    <div class="main-action">
        <a href="upload_book.php">Upload Book</a>
    </div>
</div>

<form action="index.php" method="POST">
    <input id="search-term" type="text" name="search_term" placeholder="Search by title, author, or category"
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
        echo "<p><strong>Category:</strong> {$row['categories']}</p>";
        echo "<a href='book_details.php?book_id={$row['book_id']}'>View</a>";
        echo "</div>";
    }
} else {
    echo "<p>No books found matching your search.</p>";
}
?>
</div>

<!-- ========================= -->
<!-- AVAILABLE BOOKS SECTION -->
<!-- ========================= -->

<div class="featured-books">
    <h3>Available Books</h3>
    <div class="book-list">
<?php
$sqlz = "
SELECT b.book_id, b.title, a.author_name
FROM books b
JOIN authors a ON b.author_id = a.author_id
";

$resultz = $conn->query($sqlz);

if ($resultz) {
    while ($book = $resultz->fetch_assoc()) {
        echo "<a href='book_details.php?book_id={$book['book_id']}'>";
        echo "{$book['title']} by {$book['author_name']}";
        echo "</a>";
    }
}
?>
    </div>
</div>

</body>
</html>
