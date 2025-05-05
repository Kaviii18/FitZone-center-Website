<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    include 'config.php';

    // Retrieve form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing
    $role = $_POST['role'];

    try {
        // Check if email or username already exists
        $checkQuery = "SELECT id FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email or Username already exists. Please use another.');</script>";
        } else {
            // Insert new user into the database
            $insertQuery = "INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssssss", $first_name, $last_name, $username, $email, $password, $role);

            if ($stmt->execute()) {
                echo "<script>alert('Sign up successful! Please log in.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error: Could not save user details.');</script>";
            }
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="./img/fav-icon.svg">
    <title>Sign Up -FitZone</title>
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
        .form-container .signup-btn {
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
    </style>
</head>
<body>
    <div class="form-container">
        <img src="./img/fitzonelogo.png" alt="Gym Management System Logo">
        <h1>Sign Up</h1>
        <form method="POST" action="signup.php">
            <input type="text" name="first_name" placeholder="Enter First Name" required>
            <input type="text" name="last_name" placeholder="Enter Last Name" required>
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
                <option value="trainer">Trainer</option>
            </select>
            

            <button type="submit" class="signup-btn">Sign Up</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
        <a href="login.php">Already have an account? Login here</a>
    </div>
</body>
</html>









