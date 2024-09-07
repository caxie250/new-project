<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/PH.svg">
    <title>Program Hydrolic</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="dashboard.html">Dashboard</a>
        <a href="users.html">Users</a>
        <a href="settings.html">Settings</a>
        <a href="events.php">Events</a>
        <a href="#">Logout</a>
    </div>
    <div class="add">
        <button class="add-user-btn" id="addUserBtn">Add User</button>
    </div>
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add New User</h2>
            <form action="backend/user.php" method="POST">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="image">Profile Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <input type="submit" value="Add User" id="addUserButton">
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PH";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<p>Record deleted successfully.</p>";
    } else {
        echo "<p>Error deleting record: " . $conn->error . "</p>";
    }
    $stmt->close();
}


// $sql = "SELECT id, firstname, lastname, username, image FROM users";
$result = $conn->query("SELECT id, firstname, lastname, username, image FROM users");

echo "<style>";
echo "table { width: 1200px; border-collapse: collapse; margin: 20px 0; font-size: 16px; text-align: left; float:right; margin-top:200px}";
echo "th { background-color: #007bff; color: white; padding: 12px; border-bottom: 2px solid #ddd; }";
echo "td { padding: 12px; border-bottom: 1px solid #ddd; }";
echo "tr:nth-child(even) { background-color: #f2f2f2; }";
echo "tr:hover { background-color: #ddd; }";
echo "table, th, td { border: 1px solid #ddd; }";
echo "img { max-width: 100px; height: auto; }";
echo "button { padding: 5px 10px; background-color: #f44336; color: white; border: none; cursor: pointer; }";
echo "button:hover { background-color: #d32f2f; }";
echo "</style>";
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Username</th>";
    echo "<th>Profile Image</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>";
        if ($row["image"]) {
            echo "<img src='" . $row["image"] . "' alt='Profile Image' style='width: 100px; height: auto;'>";
        } else {
            echo "No Image";
        }
        echo "</td>";
        echo "<td>";
        echo "<form method='post' style='display:inline;'>";
        echo "<input type='hidden' name='delete_id' value='" . $row["id"] . "'>";
        echo "<button type='submit'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}


$conn->close();
?>

<script>
   
    var modal = document.getElementById("addUserModal");
    var btn = document.getElementById("addUserBtn");
    var span = document.getElementById("closeModal");

    btn.onclick = function() {
        modal.style.display = "flex";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
</script>
<script src="backend/adduser.js"></script>
</body>
</html>