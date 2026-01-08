<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the email already exists
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password_hash', 'user')";
        if ($conn->query($sql)) {
            header('Location: login.php');
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <h1 id="brand">Your Virtual Library Experience</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="register.php" method="POST">
        <h2>Register</h2>
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Log in here</a></p>
    </form>
</body>
</html>
