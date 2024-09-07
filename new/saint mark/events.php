<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Hydrolic</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="images/PH.svg">
</head>
<style>
       .section {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 120px;
    margin-right:30px;
    padding: 20px;
    float:right;

}

.section-title {
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 20px;
}

.event {
    display: flex;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.event:last-child {
    border-bottom: none;
}

.event img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
}

.event-info {
    flex: 1;
}

.event-info h3 {
    font-size: 18px;
    color: #333;
    margin: 0 0 10px 0;
}

.event-info p {
    font-size: 16px;
    color: #555;
    margin: 0 0 10px 0;
}

.event-info small {
    font-size: 14px;
    color: #777;
}

p {
    margin: 0;
    font-size: 16px;
    color: #555;
}
  .delete-btn {
            margin-top: 10px;
            color: red;
            background: none;
            border: none;
            cursor: pointer;
        }

    </style>
<body>
<div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="dashboard.html">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="settings.html">Settings</a>
        <a href="events.php">Events</a>
        <a href="backend/logout.php">Logout</a>
    </div>
    <div class="add">
        <button class="add-user-btn" id="addUserBtn">Add Event</button>
    </div>
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add New Event</h2>
            <form action="event.php" method="POST" enctype="multipart/form-data">
            <div class="form-group" style="margin-bottom: 20px;">
    <label for="event_name" style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Event Name</label>
    <input type="text" id="event_name" name="event_name" required
        style="width: 100%; padding: 12px; border: 2px solid #007bff; border-radius: 8px; background-color: #ffffff; font-size: 16px; color: #333; box-sizing: border-box; transition: border-color 0.3s ease; outline: none;">
</div>

                <div class="form-group" style="margin-bottom: 20px;">
    <label for="service_section" style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Service Section</label>
    <select id="service_section" name="service_section" required
        style="width: 100%; padding: 12px; border: 2px solid #007bff; border-radius: 8px; background-color: #ffffff; font-size: 16px; color: #333; appearance: none; cursor: pointer; transition: border-color 0.3s ease;">
        <option value="S1 Human capacity building">S1 Human capacity building</option>
        <option value="S2 Water supply">S2 Water supply</option>
        <option value="S3 Promotion of hygiene and sanitation">S3 Promotion of hygiene and sanitation</option>
        <option value="S4 Environment protection and management">S4 Environment protection and management</option>
    </select>
</div>

<div class="form-group" style="margin-bottom: 20px;">
    <label for="event_image" style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Event Picture</label>
    <input type="file" id="event_image" name="event_image" accept="image/*" required
        style="width: 100%; padding: 12px; border: 2px solid #007bff; border-radius: 8px; background-color: #ffffff; font-size: 16px; color: #333; box-sizing: border-box; transition: border-color 0.3s ease; outline: none;">
</div>

                <div class="form-group" style="margin-bottom: 20px;">
    <label for="event_description" style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Event Description</label>
    <textarea id="event_description" name="event_description" rows="4" required
        style="width: 100%; padding: 12px; border: 2px solid #007bff; border-radius: 8px; background-color: #f8f9fa; font-size: 16px; color: #333; resize: vertical;"></textarea>
</div>
<div class="form-group" style="margin-bottom: 20px;">
    <label for="created_by" style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">Created By</label>
    <input id="created_by" name="created_by" type="text" required
        style="width: 100%; padding: 12px; border: 2px solid #007bff; border-radius: 8px; background-color: #ffffff; font-size: 16px; color: #333; box-sizing: border-box; transition: border-color 0.3s ease;">
</div>

                <div class="form-group">
                    <input type="submit" value="Add Event">
                </div>
        </div>
    </div>
</div>
<section style="width:1300px; margin-left:300px">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PH";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $eventId = intval($_GET['delete_id']);

    $stmt = $conn->prepare("SELECT event_image FROM events WHERE id = ?");
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $stmt->bind_result($eventImage);
    $stmt->fetch();
    $stmt->close();
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param('i', $eventId);

    if ($stmt->execute()) {
        if ($eventImage && file_exists($eventImage)) {
            unlink($eventImage);
        }
        echo "Event deleted successfully.";
        
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

}
$sql = "SELECT id, event_name, service_section, event_image, event_description, created_by FROM events";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    

        echo '<section style="padding: 20px; background-color: #f4f4f4; margin-bottom: 20px; border-radius: 8px; text-align: left; float:left;>';
        echo '<h3 style="color: #333;">' . htmlspecialchars($row['event_name']) . '</h3>';
        echo '<p style="font-size: 16px; color: #555;">Section: ' . htmlspecialchars($row['service_section']) . '</p>';
        echo '<img src="' . htmlspecialchars($row['event_image']) . '" alt="Event Image" style="width: 300px; height:200px; height: auto; border-radius: 8px; margin-bottom: 15px;">';
        echo '<p style="font-size: 16px; color: #555; width:300px">' . htmlspecialchars($row['event_description']) . '</p>';
        echo '<p style="font-size: 14px; color: #777;">Created by: ' . htmlspecialchars($row['created_by']) . '</p>';
        echo '<a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?delete_id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to delete this event?\');" style="color: #ff0000; text-decoration: none;">Delete</a>';
        echo '</section>';
        
    
    }

    echo "</table>";
} else {
    echo "No events found.";
}

$conn->close();
?>
</section>
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