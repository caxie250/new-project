<?php
// Database connection (adjust the credentials accordingly)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PH";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Initialize image path
$imagePath = null;

// Handle file upload if file is provided
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '.../uploads/';
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
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

$firstname = sanitizeInput($_POST['firstname']);
$lastname = sanitizeInput($_POST['lastname']);
$username = sanitizeInput($_POST['username']);
$password = password_hash(sanitizeInput($_POST['password']), PASSWORD_BCRYPT);

// Prepare and execute SQL query
$sql = "INSERT INTO users (firstname, lastname, username, password, image) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sssss', $firstname, $lastname, $username, $password, $imagePath);

if ($stmt->execute()) {
    echo "New user added successfully.";
    header("Location:../users.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
