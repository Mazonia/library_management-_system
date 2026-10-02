<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Search Books</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by title, author, or genre">
            <button type="submit">Search</button>
        </form>

        <?php
        include '../db.php';

        $search = $_GET['search'] ?? '';
        $sql = "SELECT * FROM Books WHERE Title LIKE '%$search%' OR Author LIKE '%$search%' OR Genre LIKE '%$search%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Title</th><th>Author</th><th>Genre</th><th>Available Copies</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['Title'] . "</td><td>" . $row['Author'] . "</td><td>" . $row['Genre'] . "</td><td>" . $row['AvailableCopies'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }
        $conn->close();
        ?>
    </main>
</body>
</html>
