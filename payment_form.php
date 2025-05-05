<?php
// Include database configuration
include 'config.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required fields are set
    if (isset($_POST['plan_name'], $_POST['amount'], $_POST['duration'])) {
        $user_id = $_SESSION['user_id'];
        $plan_name = $_POST['plan_name'];
        $amount = floatval($_POST['amount']); // Ensure amount is a valid float
        $duration = $_POST['duration'];

        // Save the payment record to the database
        $sql = "INSERT INTO payments (user_id, plan_name, amount, duration, status) VALUES (?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $plan_name, $amount, $duration);

        if ($stmt->execute()) {
            // Redirect to index.php with a success message
            header("Location: index.php?success=1");
            exit();
        } else {
            $error_message = "Error saving payment: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="./img/fav-icon.svg">
    <title>Make Payment</title>
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
            border: 2px solid #4CAF50;
            border-radius: 10px;
            box-shadow: 0 0 20px 5px #4CAF50;
            text-align: center;
        }
        .form-container img {
            width: 80px;
            margin-bottom: 20px;
        }
        .form-container h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .form-container input, .form-container select {
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
        .form-container .submit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .form-container .reset-btn {
            background-color: #e74c3c;
            color: white;
        }
        .form-container a {
            color: #4CAF50;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }
        .form-container button:hover {
            opacity: 0.9;
        }
        .error-message {
            color: #e74c3c;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <img src="./img/fitzonelogo.png" alt="Gym Management System Logo">
        <h1>Make Payment</h1>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <form method="POST" action="payment_form.php">
            <select name="plan_name" required>
                <option value="" disabled selected>Select Plan</option>
                <option value="Beginner">Beginner Plan</option>
                <option value="Pro">Pro Plan</option>
                <option value="Custom">Custom Plan</option>
            </select>

            <input type="number" name="amount" placeholder="Enter Amount" step="0.01" required>

            <select name="duration" required>
                <option value="" disabled selected>Select Duration</option>
                <option value="1 Month">1 Month</option>
                <option value="6 Months">6 Months</option>
                <option value="1 Year">1 Year</option>
            </select>

            <button type="submit" class="submit-btn">Pay Now</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>

        <a href="index.php">Go to Home</a>
    </div>
</body>
</html>




