<?php
include 'db.php';

// 1. Get post ID from URL
$id = $_GET['id'];

// 2. Fetch existing post
$sql = "SELECT * FROM posts WHERE id=$id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

// 3. If form submitted, update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $update = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    if ($conn->query($update) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="container">

<h2>Edit Post</h2>
<form method="POST" action="">
    <input type="text" name="title" value="<?php echo $post['title']; ?>" required><br><br>
    <textarea name="content" required><?php echo $post['content']; ?></textarea><br><br>
    <button type="submit">Update Post</button>
</form>

<br>
<a href="index.php">⬅ Back to Posts</a>
</div>
