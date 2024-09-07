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

$imagePath = null;

if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['event_image']['name']);

    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['event_image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile;
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        echo "Invalid file type.";
        exit;
    }
}

$eventName = sanitizeInput($_POST['event_name']);
$serviceSection = sanitizeInput($_POST['service_section']);
$eventDescription = sanitizeInput($_POST['event_description']);
$createdBy = sanitizeInput($_POST['created_by']);

$sql = "INSERT INTO events (event_name, service_section, event_image, event_description, created_by) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssss', $eventName, $serviceSection, $imagePath, $eventDescription, $createdBy);

if ($stmt->execute()) {
    echo "New event added successfully.";
    header("Location: events.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
