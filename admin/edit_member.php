<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Edit Member</h1>
        <nav>
            <ul>
                <li><a href="manage_members.php">Back to Manage Members</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        include '../db.php';

        $memberID = $_GET['id'];
        $sql = "SELECT * FROM Members WHERE MemberID = $memberID";
        $result = $conn->query($sql);
        $member = $result->fetch_assoc();
        ?>

        <form method="POST" action="">
            <input type="hidden" name="member_id" value="<?php echo $member['MemberID']; ?>">
            <input type="text" name="name" value="<?php echo $member['Name']; ?>" required>
            <input type="text" name="grade_class" value="<?php echo $member['GradeClass']; ?>">
            <input type="text" name="contact_info" value="<?php echo $member['ContactInfo']; ?>" required>
            <select name="member_type">
                <option value="Student" <?php echo ($member['MemberType'] == 'Student') ? 'selected' : ''; ?>>Student</option>
                <option value="Staff" <?php echo ($member['MemberType'] == 'Staff') ? 'selected' : ''; ?>>Staff</option>
            </select>
            <button type="submit" name="edit_member">Update Member</button>
        </form>

        <?php
        if (isset($_POST['edit_member'])) {
            $name = $_POST['name'];
            $grade_class = $_POST['grade_class'];
            $contact_info = $_POST['contact_info'];
            $member_type = $_POST['member_type'];
            $memberID = $_POST['member_id'];

            $sql = "UPDATE Members SET Name='$name', GradeClass='$grade_class', ContactInfo='$contact_info', MemberType='$member_type' WHERE MemberID=$memberID";
            if ($conn->query($sql) === TRUE) {
                echo "Member updated successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
        ?>
    </main>
</body>
</html>
