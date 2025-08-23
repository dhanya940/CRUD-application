<?php
include 'db.php';
session_start();

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

echo "<h2>All Posts</h2>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<small>Posted on: " . $row['created_at'] . "</small><br>";

        // Show edit/delete only if logged in
        if (isset($_SESSION['user_id'])) {
            echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
            echo "<a href='delete.php?id=".$row['id']."'>Delete</a>";
        }

        echo "<hr>";
    }
} else {
    echo "No posts found.";
}

// Show login/logout links
if (isset($_SESSION['user_id'])) {
    echo "<br><a href='create.php'>➕ Add New Post</a><br>";
    echo "<a href='logout.php'>🚪 Logout (" . $_SESSION['username'] . ")</a>";
} else {
    echo "<br><a href='login.php'>🔑 Login</a> | <a href='register.php'>📝 Register</a>";
}
?>
