<?php
require "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) exit("Invalid student ID.");

$stmt = $conn->prepare(
    "SELECT id, name, roll_no, email, course, created_at
     FROM students WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) exit("Student not found.");

$fileStmt = $conn->prepare(
    "SELECT original_name, file_path, file_type, file_size, uploaded_at
     FROM student_files WHERE student_id = ? ORDER BY uploaded_at DESC"
);
$fileStmt->bind_param("i", $id);
$fileStmt->execute();
$files = $fileStmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Student Profile</title></head>
<body>
<h1>Student Profile</h1>

<p><b>Name:</b> <?= htmlspecialchars($student["name"]) ?></p>
<p><b>Roll No:</b> <?= htmlspecialchars($student["roll_no"]) ?></p>
<p><b>Email:</b> <?= htmlspecialchars($student["email"]) ?></p>
<p><b>Course:</b> <?= htmlspecialchars($student["course"]) ?></p>

<h2>Uploaded Files</h2>
<?php while ($file = $files->fetch_assoc()): ?>
    <p>
        <a href="<?= htmlspecialchars($file["file_path"]) ?>" target="_blank">
            <?= htmlspecialchars($file["original_name"]) ?>
        </a>
        (<?= htmlspecialchars($file["file_type"]) ?>,
         <?= (int)$file["file_size"] ?> bytes)
    </p>
<?php endwhile; ?>
</body>
</html>
