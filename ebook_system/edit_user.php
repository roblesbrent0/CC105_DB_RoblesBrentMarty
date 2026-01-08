<?php
session_start();
include('db.php');

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$user_id = intval($_GET['user_id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "UPDATE users SET name = '$name', email = '$email', role = '$role' WHERE user_id = $user_id";
    if ($conn->query($sql)) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}

// Fetch user details
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1 id="admin-t">Edit User</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="edit_user.php?user_id=<?php echo $user_id; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <label for="role">Role:</label>
        <select name="role">
            <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select>
        <button type="submit">Update User</button>
    </form>
    <a href="admin_dashboard.php" class="back">Back to Home</a>
</body>
</html>
