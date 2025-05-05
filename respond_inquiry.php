<?php
// Include database configuration file
include 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch inquiry details
    $sql = "SELECT * FROM inquiries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $inquiry = $result->fetch_assoc();
    } else {
        echo "<script>alert('Inquiry not found.'); window.location.href='inquire.php';</script>";
        exit();
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = $_POST['response'];

        // Update inquiry with the response
        $updateSql = "UPDATE inquiries SET response = ?, status = 'Resolved' WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $response, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Response submitted successfully!'); window.location.href='inquire.php';</script>";
        } else {
            echo "<script>alert('Error submitting response.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "<script>alert('Invalid inquiry ID.'); window.location.href='inquire.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respond to Inquiry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form label {
            display: block;
            margin: 15px 0 5px;
            color: #333;
        }
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }
        form button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background: #45a049;
        }
        .inquiry-details {
            background: #f9f9f9;
            padding: 10px;
            border-left: 5px solid #4CAF50;
            margin-bottom: 20px;
        }
        .back-link {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Respond to Inquiry</h1>
        <div class="inquiry-details">
            <strong>Inquiry:</strong>
            <p><?php echo htmlspecialchars($inquiry['inquiry']); ?></p>
        </div>
        <form method="POST">
            <label for="response">Response</label>
            <textarea name="response" id="response" rows="5" required></textarea>
            <button type="submit">Submit Response</button>
        </form>
        <a href="inquire.php" class="back-link">Back to Inquiries</a>
    </div>
</body>
</html>
