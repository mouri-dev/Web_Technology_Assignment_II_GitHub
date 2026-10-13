<?php
require "db.php";

$result = $conn->query(
    "SELECT id, name, roll_no, email, course, created_at
     FROM students ORDER BY id DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
</head>
<body>
<h1>Student Records</h1>
<a href="../frontend/index.html">Add Student</a>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th><th>Name</th><th>Roll No</th><th>Email</th>
    <th>Course</th><th>Actions</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row["id"]) ?></td>
    <td><?= htmlspecialchars($row["name"]) ?></td>
    <td><?= htmlspecialchars($row["roll_no"]) ?></td>
    <td><?= htmlspecialchars($row["email"]) ?></td>
    <td><?= htmlspecialchars($row["course"]) ?></td>
    <td>
        <a href="view_student.php?id=<?= $row["id"] ?>">View</a>
        <a href="edit_student.php?id=<?= $row["id"] ?>">Edit</a>
        <a href="delete_student.php?id=<?= $row["id"] ?>"
           onclick="return confirm('Delete this student?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
