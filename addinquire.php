<?php
// Include database configuration
include 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inquiry = trim($_POST['inquiry']);
    $date = date('Y-m-d H:i:s'); // Current date and time
    $status = "Pending";

    // Insert the inquiry into the database
    $sql = "INSERT INTO inquiries (inquiry, response, date, status) VALUES (?, '', ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $inquiry, $date, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Inquiry added successfully!'); window.location.href='inquiries.php';</script>";
    } else {
        echo "<script>alert('Error adding inquiry. Please try again.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inquiry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #121212;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px 5px #4CAF50;
            position: relative;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin: 15px 0 5px;
            color: white;
        }

        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }

        form button {
            padding: 10px 20px;
            margin: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        form button:hover {
            background: #45a049;
        }

        .reset-btn {
            background: #e74c3c;
        }

        .reset-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Inquiry</h1>
        <form method="POST">
            <label for="inquiry">Inquiry</label>
            <textarea name="inquiry" id="inquiry" rows="5" required></textarea>
            <button type="submit">Add Inquiry</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>

