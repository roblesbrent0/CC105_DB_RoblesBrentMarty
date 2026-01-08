<?php
session_start();
include('db.php');
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $user_id = $_SESSION['user_id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);

    // Handle file upload
    if (isset($_FILES['book_file']) && $_FILES['book_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['book_file']['tmp_name'];
        $file_name = $_FILES['book_file']['name'];
        $file_size = $_FILES['book_file']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['pdf'];

        // Validate file type
        if (!in_array($file_ext, $allowed_ext)) {
            $error = "Only PDF files are allowed.";
        } elseif ($file_size > 5 * 1024 * 1024) { // Limit to 5MB
            $error = "File size must not exceed 5MB.";
        } else {
            // Move file to uploads directory
            $uploads_dir = 'uploads/';
            if (!is_dir($uploads_dir)) {
                mkdir($uploads_dir, 0777, true);
            }
            $file_destination = $uploads_dir . uniqid() . "_" . $file_name;
            if (move_uploaded_file($file_tmp, $file_destination)) {
                // Insert book details into the database
                $sql = "INSERT INTO books (user_id, title, author, description, file_path, category) 
                        VALUES ('$user_id', '$title', '$author', '$description', '$file_destination', '$category')";

                if ($conn->query($sql)) {
                    $success = "Book uploaded successfully!";
                } else {
                    $error = "Database error: " . $conn->error;
                }

            } else {
                $error = "Failed to upload file.";
            }
        }
    } else {
        $error = "Please select a file to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main">
        
    <h1>Upload a Book</h1>

<?php if (isset($error)): ?>
    <div class="message error"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="message success"><?php echo $success; ?></div>
<?php endif; ?>

<form action="upload_book.php" method="POST" enctype="multipart/form-data">
    <label for="title">Book Title:</label>
    <input type="text" name="title" id="title" required>
    <label for="authors">Author:</label>
    <input type="text" name="authors" id="authors" required>
    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="5"></textarea>
    <label for="category">Category:</label>
    <select name="category" id="category" required>
        <option value="1">Fiction</option>
        <option value="2">History</option>
        <option value="3">Horror</option>
        <option value="4">Fantasy</option>
        <option value="5">Science</option>
    </select>

    <label for="book_file">Upload Book (PDF):</label>
    <input type="file" name="book_file" id="book_file" accept=".pdf" required>

    <button type="submit" value="Upload Book">Upload</button>
</form>

<a href="index.php" class="back">Back to Home</a>
    </div>
</body>
</html>
