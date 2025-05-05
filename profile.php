<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
include 'config.php';

// Fetch user data from database
$user_id = $_SESSION['user_id'];

try {
    $query = "SELECT first_name, last_name, username, email, role, profile_image FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name, $username, $email, $role, $profile_image);
    $stmt->fetch();
    $stmt->close();
} catch (Exception $e) {
    echo "<script>alert('Error fetching profile: " . $e->getMessage() . "');</script>";
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Gym Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #333;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav div {
            color: white;
            font-size: 20px;
            font-weight: bold;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        nav .user-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: #121212;
            padding: 20px;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            box-shadow: 0 0 20px 5px #4CAF50;
            text-align: center;
        }
        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 3px solid #4CAF50;
        }
        .profile-detail {
            margin-bottom: 20px;
        }
        .profile-detail span {
            font-weight: bold;
            color: #4CAF50;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div>Gym Management System</div>
        <div class="user-section">
            <!-- Profile Icon -->
            <a href="profile.php">
                <i class="fas fa-user" style="font-size: 18px;"></i> Profile
            </a>
            <!-- Logout Icon -->
            <a href="logout.php">
                <i class="fas fa-sign-out-alt" style="font-size: 18px;"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Profile Container -->
    <div class="container">
        <!-- Profile Image -->
        <?php if (!empty($profile_image)) : ?>
            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" class="profile-image">
        <?php else : ?>
            <img src="default-profile.png" alt="Default Profile" class="profile-image">
        <?php endif; ?>

        <h1><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h1>
        <div class="profile-detail"><span>Username:</span> <?php echo htmlspecialchars($username); ?></div>
        <div class="profile-detail"><span>Email:</span> <?php echo htmlspecialchars($email); ?></div>
        <div class="profile-detail"><span>Role:</span> <?php echo htmlspecialchars($role); ?></div>

        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>

