<?php
// Include database configuration
include 'config.php';

// Fetch all members for the dropdown
$membersQuery = "SELECT id, username FROM members";
$membersResult = $conn->query($membersQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $details = $_POST['details'];

    // Insert the new appointment into the database
    $sql = "INSERT INTO appointments (member_id, appointment_date, appointment_time, details) 
            VALUES ('$member_id', '$appointment_date', '$appointment_time', '$details')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the appointments page after successful addition
        header("Location: appointments.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 400px;
            margin: 50px auto;
            background: #121212;
            padding: 20px;
            border: 2px solid #2ecc71;
            border-radius: 10px;
            box-shadow: 0 0 20px 5px #2ecc71;
            text-align: center;
        }
        .form-container h1 {
            color: #2ecc71;
            margin-bottom: 20px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }
        .form-container select,
        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }
        .form-container button {
            width: 45%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 5px;
        }
        .form-container .add-btn {
            background-color: #2ecc71;
            color: white;
        }
        .form-container .reset-btn {
            background-color: #e74c3c;
            color: white;
        }
        .form-container button:hover {
            opacity: 0.9;
        }
        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }
        .close-btn:hover {
            color: red;
        }
    </style>
</head>
<body>
    <a href="appointments.php" class="close-btn">&times;</a>
    <div class="form-container">
        <h1>Add New Appointment</h1>
        <form method="POST" action="add_appointment.php">
            <label for="member_id">Select Member</label>
            <select name="member_id" id="member_id" required>
                <option value="">-- Select Member --</option>
                <?php
                // Populate the dropdown with member names
                if ($membersResult->num_rows > 0) {
                    while ($member = $membersResult->fetch_assoc()) {
                        echo "<option value='{$member['id']}'>{$member['username']}</option>";
                    }
                }
                ?>
            </select>

            <label for="appointment_date">Appointment Date</label>
            <input type="date" id="appointment_date" name="appointment_date" required>

            <label for="appointment_time">Appointment Time</label>
            <input type="time" id="appointment_time" name="appointment_time" required>

            <label for="details">Details</label>
            <textarea id="details" name="details" rows="4" placeholder="Enter details (optional)"></textarea>

            <button type="submit" class="add-btn">Add Appointment</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>
