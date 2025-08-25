<?php
include 'db.php';

// Connect to DB
$conn = new mysqli('localhost', 'root', '', 'reservation_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin credentials
$email = "kherox05@gmail.com";
$password = "08052025";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if admin already exists
$check = $conn->prepare("SELECT id FROM admin WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "⚠️ Admin already exists.";
} else {
    // Insert new admin
    $stmt = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        echo "✅ Admin account created successfully.";
    } else {
        echo "⚠️ Error: " . $stmt->error;
    }

    $stmt->close();
}

$check->close();
$conn->close();
?>

