<?php
// Include database configuration file
include 'config.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data for profile picture and username
$userId = $_SESSION['user_id'];

// Fallback if `profile_photo` column does not exist
$profilePhotoQuery = "
    SELECT username, 
           IFNULL(profile_photo, 'default_profile.svg') AS profile_photo 
    FROM users 
    WHERE id = ?";
$stmt = $conn->prepare($profilePhotoQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
    $username = $user['username'];
    $profilePhoto = $user['profile_photo'];
} else {
    $username = 'Guest';
    $profilePhoto = 'default_profile.svg';
}

$stmt->close();

// Fetch counts for Members, Blogs, and Admins
$sql_members_count = "SELECT COUNT(*) AS count FROM members";
$members_count = $conn->query($sql_members_count)->fetch_assoc()['count'];

$sql_blogs_count = "SELECT COUNT(*) AS count FROM blogs";
$blogs_count = $conn->query($sql_blogs_count)->fetch_assoc()['count'];

$sql_admins_count = "SELECT COUNT(*) AS count FROM users WHERE role = 'admin'";
$admins_count = $conn->query($sql_admins_count)->fetch_assoc()['count'];

// Fetch members from the database
$sql = "SELECT id, username, email, password, mnumber, dob FROM members";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Header and Profile Photo Styling */
        .header {
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Rest of the styling */
        /* Add the rest of your styling here */
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">FITZONE FITNESS CENTER</div>
        <div class="user-info">
            <img src="uploads/<?php echo htmlspecialchars($profilePhoto); ?>" alt="Profile Photo">
            <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Sidebar -->
        <!-- Add sidebar content here -->

        <!-- Content -->
        <div class="content">
            <h1>Gym Member Dashboard</h1>
            <!-- Overview Section -->
            <!-- Add your overview cards and other content here -->
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
