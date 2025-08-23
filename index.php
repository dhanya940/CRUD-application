<?php
include 'db.php';

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

echo "<h2>All Posts</h2>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<small>Posted on: " . $row['created_at'] . "</small><br>";
        echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
        echo "<a href='delete.php?id=".$row['id']."'>Delete</a>";
        echo "<hr>";
    }
} else {
    echo "No posts found.";
}
?>

<br>
<a href="create.php">➕ Add New Post</a>
