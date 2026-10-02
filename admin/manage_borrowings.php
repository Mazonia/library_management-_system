<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Borrowings</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Manage Borrowings</h1>
        <nav>
            <ul>
                <li><a href="index.php">Admin Dashboard</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        include '../db.php';

        $sql = "SELECT Borrowings.BorrowingID, Members.Name as MemberName, Books.Title as BookTitle, Borrowings.BorrowDate, Borrowings.DueDate, Borrowings.ReturnDate
                FROM Borrowings
                JOIN Members ON Borrowings.MemberID = Members.MemberID
                JOIN Books ON Borrowings.BookID = Books.BookID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Member Name</th><th>Book Title</th><th>Borrow Date</th><th>Due Date</th><th>Return Date</th><th>Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $status = $row['ReturnDate'] ? 'Returned' : 'Not Returned';
                echo "<tr><td>" . $row['BorrowingID'] . "</td><td>" . $row['MemberName'] . "</td><td>" . $row['BookTitle'] . "</td><td>" . $row['BorrowDate'] . "</td><td>" . $row['DueDate'] . "</td><td>" . ($row['ReturnDate'] ? $row['ReturnDate'] : 'N/A') . "</td><td>$status</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No borrowings found.";
        }
        $conn->close();
        ?>
    </main>
</body>
</html>
