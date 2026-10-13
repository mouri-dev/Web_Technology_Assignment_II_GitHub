<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

$name     = trim($_POST["name"] ?? "");
$rollNo   = trim($_POST["roll_no"] ?? "");
$email    = trim($_POST["email"] ?? "");
$course   = trim($_POST["course"] ?? "");
$password = $_POST["password"] ?? "";

if ($name === "" || $rollNo === "" || $email === "" ||
    $course === "" || $password === "") {
    exit("All required fields must be filled.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Invalid email address.");
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Prepared statement prevents SQL injection.
$stmt = $conn->prepare(
    "INSERT INTO students (name, roll_no, email, course, password_hash)
     VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("sssss", $name, $rollNo, $email, $course, $passwordHash);

if (!$stmt->execute()) {
    exit("Unable to add student. Roll number or email may already exist.");
}

$studentId = $stmt->insert_id;
$stmt->close();

if (isset($_FILES["file"]) && $_FILES["file"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES["file"];

    $maxSize = 5 * 1024 * 1024; // 5 MB
    $allowed = [
        "image/jpeg" => "jpg",
        "image/png"  => "png",
        "application/pdf" => "pdf"
    ];

    if ($file["error"] !== UPLOAD_ERR_OK) {
        exit("File upload failed.");
    }

    if ($file["size"] > $maxSize) {
        exit("File exceeds the 5 MB limit.");
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file["tmp_name"]);

    if (!isset($allowed[$mime])) {
        exit("Unsupported file type.");
    }

    $extension = $allowed[$mime];
    $storedName = bin2hex(random_bytes(16)) . "." . $extension;
    $uploadDir = __DIR__ . "/uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $target = $uploadDir . $storedName;

    // Generated unique filename prevents accidental overwriting.
    if (!move_uploaded_file($file["tmp_name"], $target)) {
        exit("Could not save uploaded file.");
    }

    $relativePath = "uploads/" . $storedName;

    $fileStmt = $conn->prepare(
        "INSERT INTO student_files
         (student_id, original_name, stored_name, file_path, file_type, file_size)
         VALUES (?, ?, ?, ?, ?, ?)"
    );

    $fileStmt->bind_param(
        "issssi",
        $studentId,
        $file["name"],
        $storedName,
        $relativePath,
        $mime,
        $file["size"]
    );

    $fileStmt->execute();
    $fileStmt->close();
}

header("Location: index.php");
exit;
?>
