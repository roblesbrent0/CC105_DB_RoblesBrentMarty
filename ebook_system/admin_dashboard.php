<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <header>
        <div class="brand">
            <a href="admin_dashboard.php">Your Virtual Library Experience</a>
        </div>
    </header>

    <div class="main">
        <div class="main-txt">
                <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
                <p>What's your plan for today?</p>
            </div>
            <div class="main-action">
                <a href="logout.php">Log Out</a>
            </div>
    </div>

    <div class="container">

        <!-- Users Section -->
        <div class="section">
            <h3>Manage Users</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td id="act">
                                <a href="edit_user.php?user_id=<?php echo $user['user_id']; ?>">Edit</a> <p>|</p>
                                <a href="delete_user.php?user_id=<?php echo $user['user_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Books Section -->
        <div class="section">
            <h3>Manage Books</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($book = $books_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $book['book_id']; ?></td>
                            <td><?php echo $book['title']; ?></td>
                            <td><?php echo $book['author']; ?></td>
                            <td><?php echo $book['category']; ?></td>
                            <td id="act">
                                <a href="edit_book.php?book_id=<?php echo $book['book_id']; ?>">Edit</a> <p>|</p>
                                <a href="delete_book.php?book_id=<?php echo $book['book_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
