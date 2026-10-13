<?php
require "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) exit("Invalid student ID.");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = trim($_POST["course"] ?? "");

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || $course === "") {
        exit("Invalid input.");
    }

    $stmt = $conn->prepare(
        "UPDATE students SET name=?, email=?, course=? WHERE id=?"
    );
    $stmt->bind_param("sssi", $name, $email, $course, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: view_student.php?id=" . $id);
    exit;
}

$stmt = $conn->prepare(
    "SELECT name, email, course FROM students WHERE id=?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
if (!$student) exit("Student not found.");
?>
<form method="POST">
    <label>Name</label>
    <input name="name" value="<?= htmlspecialchars($student["name"]) ?>" required>

    <label>Email</label>
    <input type="email" name="email"
           value="<?= htmlspecialchars($student["email"]) ?>" required>

    <label>Course</label>
    <input name="course" value="<?= htmlspecialchars($student["course"]) ?>" required>

    <button type="submit">Update</button>
</form>
