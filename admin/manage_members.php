<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Manage Members</h1>
        <nav>
            <ul>
                <li><a href="index.php">Admin Dashboard</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form method="POST" action="">
            <h2>Add New Member</h2>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="grade_class" placeholder="Grade/Class (leave empty for staff)">
            <input type="text" name="contact_info" placeholder="Contact Info" required>
            <select name="member_type">
                <option value="Student">Student</option>
                <option value="Staff">Staff</option>
            </select>
            <button type="submit" name="add_member">Add Member</button>
        </form>

        <?php
        include '../db.php';

        if (isset($_POST['add_member'])) {
            $name = $_POST['name'];
            $grade_class = $_POST['grade_class'];
            $contact_info = $_POST['contact_info'];
            $member_type = $_POST['member_type'];

            $sql = "INSERT INTO Members (Name, GradeClass, ContactInfo, MemberType) VALUES ('$name', '$grade_class', '$contact_info', '$member_type')";
            if ($conn->query($sql) === TRUE) {
                echo "New member added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        if (isset($_GET['delete'])) {
            $memberID = $_GET['delete'];
            $sql = "DELETE FROM Members WHERE MemberID = $memberID";
            if ($conn->query($sql) === TRUE) {
                echo "Member deleted successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        if (isset($_POST['edit_member'])) {
            $memberID = $_POST['member_id'];
            $name = $_POST['name'];
            $grade_class = $_POST['grade_class'];
            $contact_info = $_POST['contact_info'];
            $member_type = $_POST['member_type'];

            $sql = "UPDATE Members SET Name='$name', GradeClass='$grade_class', ContactInfo='$contact_info', MemberType='$member_type' WHERE MemberID=$memberID";
            if ($conn->query($sql) === TRUE) {
                echo "Member updated successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $sql = "SELECT * FROM Members";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Grade/Class</th><th>Contact Info</th><th>Member Type</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['MemberID'] . "</td><td>" . $row['Name'] . "</td><td>" . $row['GradeClass'] . "</td><td>" . $row['ContactInfo'] . "</td><td>" . $row['MemberType'] . "</td>
                <td>
                <a href='edit_member.php?id=" . $row['MemberID'] . "'>Edit</a> |
                <a href='manage_members.php?delete=" . $row['MemberID'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td></tr>";
            }
            echo "</table>";
        } else {
            echo "No members found.";
        }
        $conn->close();
        ?>
    </main>
</body>
</html>
