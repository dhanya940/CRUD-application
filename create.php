<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // go back to list
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="container">

<h2>Create New Post</h2>
<form method="POST" action="">
    <input type="text" name="title" placeholder="Enter Title" required><br><br>
    <textarea name="content" placeholder="Enter Content" required></textarea><br><br>
    <button type="submit">Save Post</button>
</form>

<br>
<a href="index.php">⬅ Back to Posts</a>
</div>
