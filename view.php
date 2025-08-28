<?php
include 'db.php';

// --- Search functionality ---
$search = isset($_GET['q']) ? $_GET['q'] : "";

// --- Pagination setup ---
$perPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// Count total posts (with search filter)
$countSql = "SELECT COUNT(*) AS total FROM posts 
             WHERE title LIKE ? OR content LIKE ?";
$stmt = $conn->prepare($countSql);
$like = "%$search%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$countResult = $stmt->get_result()->fetch_assoc();
$totalPosts = $countResult['total'];
$totalPages = ceil($totalPosts / $perPage);

// Fetch posts
$sql = "SELECT * FROM posts 
        WHERE title LIKE ? OR content LIKE ?
        ORDER BY created_at DESC 
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $like, $like, $offset, $perPage);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="mb-4">📚 Blog Posts</h2>

    <!-- Search -->
    <form method="get" class="d-flex mb-3">
        <input type="text" name="q" class="form-control me-2" placeholder="Search posts..."
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title"><?= htmlspecialchars($row['title']) ?></h4>
                    <p class="card-text">
                        <?= nl2br(htmlspecialchars(substr($row['content'], 0, 150))) ?>...
                    </p>
                    <small class="text-muted">Posted on: <?= $row['created_at'] ?></small><br>

                    <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info mt-2">👁️ View</a>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning mt-2">✏️ Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger mt-2">🗑️ Delete</a>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    <?php else: ?>
        <div class="alert alert-info">No posts found.</div>
    <?php endif; ?>

    <a href="create.php" class="btn btn-success">➕ Add New Post</a>

</body>
</html>
