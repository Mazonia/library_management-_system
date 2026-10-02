<?php
include '../db.php';

$message = '';
$msg_type = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $publication_year = (int)$_POST['publication_year'];
    $genre = trim($_POST['genre']);
    $isbn = trim($_POST['isbn']);
    $available_copies = (int)$_POST['available_copies'];

    $stmt = $conn->prepare("INSERT INTO Books (Title, Author, PublicationYear, Genre, ISBN, AvailableCopies) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssissi", $title, $author, $publication_year, $genre, $isbn, $available_copies);
        if ($stmt->execute()) {
            $message = "New book added successfully.";
        } else {
            $message = "Error adding book: " . $stmt->error;
            $msg_type = 'danger';
        }
        $stmt->close();
    }
}

if (isset($_GET['delete'])) {
    $bookID = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM Books WHERE BookID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $bookID);
        if ($stmt->execute()) {
            $message = "Book deleted successfully.";
        } else {
            $message = "Error deleting book: " . $stmt->error;
            $msg_type = 'danger';
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM Books ORDER BY BookID DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books | Library Portal</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="app-header">
        <h1>📚 Manage Book Catalog</h1>
        <nav>
            <a href="index.php" class="btn btn-secondary">← Admin Dashboard</a>
        </nav>
    </header>

    <main class="container">
        <?php if ($message): ?>
            <div class="alert alert-<?= $msg_type ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Add New Book</h2>
            <form method="POST" action="" class="form-grid">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. To Kill a Mockingbird">
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" required placeholder="e.g. Harper Lee">
                </div>
                <div class="form-group">
                    <label>Publication Year</label>
                    <input type="number" name="publication_year" class="form-control" required placeholder="e.g. 1960">
                </div>
                <div class="form-group">
                    <label>Genre</label>
                    <input type="text" name="genre" class="form-control" placeholder="e.g. Fiction">
                </div>
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" class="form-control" required placeholder="9780061120084">
                </div>
                <div class="form-group">
                    <label>Available Copies</label>
                    <input type="number" name="available_copies" class="form-control" required min="0" value="1">
                </div>
                <button type="submit" name="add_book" class="btn btn-primary" style="grid-column: 1 / -1;">+ Add Book to Inventory</button>
            </form>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h2>Existing Catalog</h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Genre</th>
                            <th>ISBN</th>
                            <th>Copies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int)$row['BookID'] ?></td>
                                <td><strong><?= htmlspecialchars($row['Title']) ?></strong></td>
                                <td><?= htmlspecialchars($row['Author']) ?></td>
                                <td><?= (int)$row['PublicationYear'] ?></td>
                                <td><span class="badge"><?= htmlspecialchars($row['Genre'] ?? 'Unassigned') ?></span></td>
                                <td><code><?= htmlspecialchars($row['ISBN']) ?></code></td>
                                <td><?= (int)$row['AvailableCopies'] ?></td>
                                <td>
                                    <a href="edit_book.php?id=<?= (int)$row['BookID'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="manage_books.php?delete=<?= (int)$row['BookID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No books currently in the catalog.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
