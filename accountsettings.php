<?php
// Include database configuration
include 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found.'); window.location.href='dashboard.php';</script>";
    exit();
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $mobile_number = $_POST['mobile_number'];

    $update_sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, address = ?, dob = ?, mobile_number = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $first_name, $last_name, $email, $address, $dob, $mobile_number, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='accountsettings.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
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
    <title>Account Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #121212;
            padding: 20px;
            border: 2px solid #2ecc71;
            border-radius: 10px;
            box-shadow: 0 0 20px 5px #2ecc71;
            text-align: center;
        }
        .container h1 {
            color: #2ecc71;
            margin-bottom: 20px;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
        }
        .btn:hover {
            background-color: #27ae60;
        }
        form {
            text-align: left;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }
        form input:focus, form textarea:focus {
            outline: none;
            border: 1px solid #2ecc71;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-actions {
            text-align: center;
        }
    </style>
      
</head>
<body>
    <div class="container">
        <h1>Account Settings</h1>
        <img src="profile_placeholder.svg" alt="Profile Picture" class="profile-pic">
        <button class="btn">Update Profile Image</button>

        <form method="POST" action="accountsettings.php">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input 
                    type="text" 
                    id="first_name" 
                    name="first_name" 
                    value="<?php echo isset($user['first_name']) ? htmlspecialchars($user['first_name']) : ''; ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input 
                    type="text" 
                    id="last_name" 
                    name="last_name" 
                    value="<?php echo isset($user['last_name']) ? htmlspecialchars($user['last_name']) : ''; ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="3"
                ><?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input 
                    type="date" 
                    id="dob" 
                    name="dob" 
                    value="<?php echo isset($user['dob']) ? htmlspecialchars($user['dob']) : ''; ?>"
                >
            </div>

            <div class="form-group">
                <label for="mobile_number">Mobile Number:</label>
                <input 
                    type="text" 
                    id="mobile_number" 
                    name="mobile_number" 
                    value="<?php echo isset($user['mobile_number']) ? htmlspecialchars($user['mobile_number']) : ''; ?>"
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Update Profile</button>
            </div>
        </form>
    </div>
</body>


</html>