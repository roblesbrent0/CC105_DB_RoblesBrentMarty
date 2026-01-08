<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Personal Ebook Experience</title>
    <link rel="stylesheet" href="css/header.css"> <!-- Assuming you have a CSS file for styling -->
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <div class="brand">
            <a href="index.php">Your Virtual Library Experience</a>
        </div>

        <div class="toggle-icon" id="toggle-icon">
            &#9776; <!-- Hamburger Icon -->
        </div>

        <div class="nav-links" id="nav-links">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="browse_books.php">Browse Books</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Only show if the user is logged in -->
                    <li><a href="upload_book.php">Upload Book</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <!-- Only show if the user is NOT logged in -->
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <script src="js/script.js"></script>


    <!-- Content Starts Here -->
    <div class="content">
