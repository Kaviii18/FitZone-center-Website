<?php
// Include database configuration
include 'config.php';

// Validate and fetch the schedule ID
if (!isset($_GET['id']) || empty(trim($_GET['id'])) || !is_numeric($_GET['id'])) {
    echo "Invalid request. Schedule ID is missing or invalid.";
    exit();
}

$id = intval($_GET['id']);

// Fetch the class schedule details
$scheduleQuery = "SELECT * FROM class_schedule WHERE id = ?";
$stmt = $conn->prepare($scheduleQuery);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No class schedule found with the specified ID.";
    exit();
}

$schedule = $result->fetch_assoc();

// Handle form submission for updating the class schedule
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];
    $trainer = $_POST['trainer'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Update the class schedule in the database
    $updateQuery = "UPDATE class_schedule 
                    SET class_name = ?, trainer = ?, day = ?, start_time = ?, end_time = ? 
                    WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssi", $class_name, $trainer, $day, $start_time, $end_time, $id);

    if ($stmt->execute()) {
        // Redirect to the class schedule page after successful update
        header("Location: class_schedule.php?message=Class%20schedule%20updated%20successfully");
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
    <title>Edit Class Schedule</title>
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
        .form-container input {
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
    <a href="class_schedule.php" class="close-btn">&times;</a>
    <div class="form-container">
        <h1>Edit Class Schedule</h1>
        <form method="POST" action="edit_class_schedule.php?id=<?php echo htmlspecialchars($id); ?>">
            <label for="class_name">Class Name</label>
            <input type="text" id="class_name" name="class_name" value="<?php echo htmlspecialchars($schedule['class_name']); ?>" required>

            <label for="trainer">Trainer</label>
            <input type="text" id="trainer" name="trainer" value="<?php echo htmlspecialchars($schedule['trainer']); ?>" required>

            <label for="day">Day</label>
            <select id="day" name="day" required>
                <option value="Monday" <?php echo $schedule['day'] == 'Monday' ? 'selected' : ''; ?>>Monday</option>
                <option value="Tuesday" <?php echo $schedule['day'] == 'Tuesday' ? 'selected' : ''; ?>>Tuesday</option>
                <option value="Wednesday" <?php echo $schedule['day'] == 'Wednesday' ? 'selected' : ''; ?>>Wednesday</option>
                <option value="Thursday" <?php echo $schedule['day'] == 'Thursday' ? 'selected' : ''; ?>>Thursday</option>
                <option value="Friday" <?php echo $schedule['day'] == 'Friday' ? 'selected' : ''; ?>>Friday</option>
                <option value="Saturday" <?php echo $schedule['day'] == 'Saturday' ? 'selected' : ''; ?>>Saturday</option>
                <option value="Sunday" <?php echo $schedule['day'] == 'Sunday' ? 'selected' : ''; ?>>Sunday</option>
            </select>

            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" value="<?php echo htmlspecialchars($schedule['start_time']); ?>" required>

            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" value="<?php echo htmlspecialchars($schedule['end_time']); ?>" required>

            <button type="submit" class="update-btn">Update Schedule</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>
