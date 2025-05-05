<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    include 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Fetch the role from the dropdown

    // Fetch user details from the database using username and role
    $sql = "SELECT id, first_name, last_name, email, password, role FROM users WHERE username = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($role == 'admin') {
                header("Location: dashboard.php");
            } elseif ($role == 'coach') {
                header("Location: coach_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('No account found with this username and role. Please check your details.');</script>";
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
    <link rel="shortcut icon" type="image/x-icon" href="./img/fav-icon.svg">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Login -FitZone</title>
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
        .form-container .login-btn {
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
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            
            <!-- Role Dropdown -->
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin">Admin</option>
                <option value="trainer">trainer</option>
                <option value="member">Member</option>
            </select>

            <div class="g-recaptcha" data-sitekey="6LcZeaQqAAAAADOmrZAj3IehAJ1ZBU1dcGXVE-er"></div>

            <button type="submit" class="login-btn">Login</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
        <a href="signup.php">Don't have an account? Sign up here</a>
    </div>
</body>
</html>

