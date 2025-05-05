<?php
// Include database configuration
include 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];
    $trainer = $_POST['trainer'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Insert the new class schedule into the database
    $sql = "INSERT INTO class_schedule (class_name, trainer, day, start_time, end_time) 
            VALUES ('$class_name', '$trainer', '$day', '$start_time', '$end_time')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the class schedule page after successful addition
        header("Location: class_schedule.php?message=Class%20schedule%20added%20successfully");
        exit();
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
    <title>Add Class Schedule</title>
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
    <a href="class_schedule.php" class="close-btn">&times;</a>
    <div class="form-container">
        <h1>Add Class Schedule</h1>
        <form method="POST" action="add_class_schedule.php">
            <label for="class_name">Class Name</label>
            <input type="text" id="class_name" name="class_name" placeholder="Enter class name (e.g., Yoga, Zumba)" required>

            <label for="trainer">Trainer</label>
            <input type="text" id="trainer" name="trainer" placeholder="Enter trainer name" required>

            <label for="day">Day</label>
            <select id="day" name="day" required>
                <option value="">-- Select Day --</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>

            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" required>

            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" required>

            <button type="submit" class="add-btn">Add Class</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>
