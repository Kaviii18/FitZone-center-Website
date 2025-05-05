<?php
// Include database configuration
include 'config.php';

// Validate and fetch the appointment ID
if (!isset($_GET['id']) || empty(trim($_GET['id'])) || !is_numeric($_GET['id'])) {
    echo "Invalid request. Appointment ID is missing or invalid.";
    exit();
}

$id = intval($_GET['id']);

// Fetch appointment details
$appointmentQuery = "SELECT * FROM appointments WHERE id = ?";
$stmt = $conn->prepare($appointmentQuery);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No appointment found with the specified ID.";
    exit();
}

$appointment = $result->fetch_assoc();

// Fetch members for the dropdown
$membersQuery = "SELECT id, username FROM members";
$membersResult = $conn->query($membersQuery);

// Handle form submission for updating the appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $details = $_POST['details'];
    $status = $_POST['status'];

    // Update the appointment in the database
    $updateQuery = "UPDATE appointments 
                    SET member_id = ?, appointment_date = ?, appointment_time = ?, details = ?, status = ? 
                    WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("issssi", $member_id, $appointment_date, $appointment_time, $details, $status, $id);

    if ($stmt->execute()) {
        // Redirect to the appointments page after successful update
        header("Location: appointments.php");
        exit();
    } else {
        echo "Something went wrong. Please try again.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
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
        .form-container .update-btn {
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
        <h1>Edit Appointment</h1>
        <form method="POST" action="edit_appointment.php?id=<?php echo htmlspecialchars($id); ?>">
            <label for="member_id">Select Member</label>
            <select name="member_id" id="member_id" required>
                <?php
                // Populate the dropdown with member names
                if ($membersResult->num_rows > 0) {
                    while ($member = $membersResult->fetch_assoc()) {
                        $selected = $member['id'] == $appointment['member_id'] ? "selected" : "";
                        echo "<option value='{$member['id']}' $selected>{$member['username']}</option>";
                    }
                }
                ?>
            </select>

            <label for="appointment_date">Appointment Date</label>
            <input type="date" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>" required>

            <label for="appointment_time">Appointment Time</label>
            <input type="time" id="appointment_time" name="appointment_time" value="<?php echo htmlspecialchars($appointment['appointment_time']); ?>" required>

            <label for="details">Details</label>
            <textarea id="details" name="details" rows="4"><?php echo htmlspecialchars($appointment['details']); ?></textarea>

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="Scheduled" <?php echo $appointment['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                <option value="Completed" <?php echo $appointment['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="Cancelled" <?php echo $appointment['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <button type="submit" class="update-btn">Update Appointment</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>
