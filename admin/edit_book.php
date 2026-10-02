<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Edit Book</h1>
        <nav>
            <ul>
                <li><a href="manage_books.php">Back to Manage Books</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        include '../db.php';

        $bookID = $_GET['id'];
        $sql = "SELECT * FROM Books WHERE BookID = $bookID";
        $result = $conn->query($sql);
        $book = $result->fetch_assoc();
        ?>

        <form method="POST" action="">
            <input type="hidden" name="book_id" value="<?php echo $book['BookID']; ?>">
            <input type="text" name="title" value="<?php echo $book['Title']; ?>" required>
            <input type="text" name="author" value="<?php echo $book['Author']; ?>" required>
            <input type="number" name="publication_year" value="<?php echo $book['PublicationYear']; ?>" required>
            <input type="text" name="genre" value="<?php echo $book['Genre']; ?>">
            <input type="text" name="isbn" value="<?php echo $book['ISBN']; ?>" required>
            <input type="number" name="available_copies" value="<?php echo $book['AvailableCopies']; ?>" required>
            <button type="submit" name="edit_book">Update Book</button>
        </form>

        <?php
        if (isset($_POST['edit_book'])) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $publication_year = $_POST['publication_year'];
            $genre = $_POST['genre'];
            $isbn = $_POST['isbn'];
            $available_copies = $_POST['available_copies'];
            $bookID = $_POST['book_id'];

            $sql = "UPDATE Books SET Title='$title', Author='$author', PublicationYear=$publication_year, Genre='$genre', ISBN='$isbn', AvailableCopies=$available_copies WHERE BookID=$bookID";
            if ($conn->query($sql) === TRUE) {
                echo "Book updated successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
        ?>
    </main>
</body>
</html>
