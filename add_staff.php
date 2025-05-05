<?php
// Include database configuration
include 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];

    // Insert the new staff member into the database
    $sql = "INSERT INTO staff (name, email, phone, role, salary) 
            VALUES ('$name', '$email', '$phone', '$role', '$salary')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the staff management page after successful addition
        header("Location: staff.php?message=Staff%20member%20added%20successfully");
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
    <link rel="shortcut icon" type="image/x-icon" href="./img/fav-icon.svg">
    <title>Add New Staff Member</title>
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
    <a href="staff.php" class="close-btn">&times;</a>
    <div class="form-container">
        <h1>Add New Staff Member</h1>
        <form method="POST" action="add_staff.php">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter full name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter email address" required>

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" placeholder="Enter phone number" required>

            <label for="role">Role</label>
            <input type="text" id="role" name="role" placeholder="Enter role (e.g., Trainer, Manager)" required>

            <label for="salary">Salary</label>
            <input type="number" id="salary" name="salary" placeholder="Enter salary" required>

            <button type="submit" class="add-btn">Add Staff</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>
