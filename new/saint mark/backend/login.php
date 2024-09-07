<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PH";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$username = sanitizeInput($_POST['username']);
$password = sanitizeInput($_POST['password']);

$sql = "SELECT id, username, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../dashboard.html");
        exit;
    } else {
        echo "Invalid password.";
    }
} else {
    echo "Invalid username.";
}

$stmt->close();
$conn->close();
?>
