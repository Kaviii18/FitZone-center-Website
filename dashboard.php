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
$userQuery = "SELECT username, profile_photo FROM users WHERE id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
    $username = $user['username'];
    $profilePhoto = $user['profile_photo'] ? $user['profile_photo'] : 'default_profile.svg';
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
    <link rel="shortcut icon" type="image/x-icon" href="./img/fav-icon.svg">
    <title>Dashboard</title>
    <style>
   /* General Body Style */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
    overflow-x: hidden; /* Prevents horizontal scrolling if content overflows */
}

/* Header Styles */
.header {
    background-color: #333;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    box-sizing: border-box;
}

.header .logo {
    font-size: 24px;
    font-weight: bold;
    color: #4CAF50;
    white-space: nowrap; /* Prevents text wrapping for the logo */
    overflow: hidden;
    text-overflow: ellipsis; /* Ensures long text is truncated with an ellipsis */
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
    border: 2px solid #4CAF50;
}

.header .user-info span {
    font-size: 16px;
    color: white;
}

/* Logout Button Container */
.logout-container {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

/* Logout Button */
.header .btn-logout {
    background-color: #FF4C4C;
    color: white;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease-in-out;
    display: inline-block;
    height: auto; /* Adjusts height dynamically */
    line-height: normal; /* Ensures proper text alignment */
    white-space: nowrap; /* Prevents text wrapping */
}

.header .btn-logout:hover {
    background-color: #e84141;
    transform: scale(1.05);
    text-decoration: none;
}

/* Fix Header Overflow */
@media screen and (max-width: 768px) {
    .header {
        flex-wrap: wrap; /* Allows items to wrap to the next line on smaller screens */
        padding: 10px;
    }

    .header .user-info {
        justify-content: flex-start;
        gap: 10px;
        margin-top: 10px; /* Adds spacing between rows */
    }

    .header .btn-logout {
        font-size: 13px; /* Adjusts font size for smaller screens */
        padding: 6px 10px; /* Reduces padding */
    }

    .header .logo {
        font-size: 20px; /* Reduces logo font size for smaller screens */
    }
}


    /* Sidebar Styles */
    .sidebar {
        width: 250px;
        background-color: #333;
        color: white;
        height: 100vh;
        padding: 20px 0;
        position: fixed;
        top: 70px;
        overflow-y: auto;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #4CAF50;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        padding: 15px;
    }

    .sidebar ul li a {
        text-decoration: none;
        color: white;
        display: block;
        transition: background-color 0.3s ease-in-out, padding-left 0.3s ease;
    }

    .sidebar ul li a:hover {
        background-color: #4CAF50;
        padding-left: 20px;
        border-radius: 5px;
    }

    /* Main Layout */
    .main-container {
        display: flex;
        margin-top: 70px;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
        background-color: #f4f4f4;
        min-height: 100vh;
        flex-grow: 1;
    }

    /* Overview Cards */
    .overview {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .overview-card {
        flex: 1;
        text-align: center;
        background-color: white;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    }

    .overview-card h2 {
        margin: 0;
        color: #333;
    }

    .overview-card p {
        font-size: 24px;
        color: #4CAF50;
    }

    .overview-card:hover {
        border-color: #4CAF50;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: white;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    table th {
        background-color: #4CAF50;
        color: white;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #ddd;
    }

    /* Buttons */
    .btn {
        padding: 10px 15px;
        text-decoration: none;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-add {
        background-color: #4CAF50;
        display: inline-block;
        margin-bottom: 10px;
    }

    .btn-edit {
        background-color: #007BFF;
    }

    .btn-delete {
        background-color: #FF4C4C;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>

</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">FITZONE FITNESS CENTER</div>
        <div class="user-info">
            <img src="./img/default_profile.svg"<?php echo htmlspecialchars($profilePhoto); ?>" alt="Profile Photo">
            <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </header>

    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="inquire.php">Inquiries</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="payments.php">payments</a></li>
                <li><a href="gym_member_details.php">Gym Member Details</a></li>
                <li><a href="staff.php">Staff Management</a></li>
                <li><a href="class_schedule.php">Class Schedule</a></li>
                <li><a href="blog.php">Blogs</a></li>
                <li><a href="accountsettings.php">Account Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1> Dashboard</h1>
            <div class="overview">
                <div class="overview-card">
                    <h2>Members</h2>
                    <p><?php echo $members_count; ?></p>
                </div>
                <div class="overview-card">
                    <h2>Blogs</h2>
                    <p><?php echo $blogs_count; ?></p>
                </div>
                <div class="overview-card">
                    <h2>Admins</h2>
                    <p><?php echo $admins_count; ?></p>
                </div>
            </div>

            <a href="add_form.php" class="btn btn-add">Add New Member</a>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Mobile Number</th>
                        <th>Date of Birth</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['password']}</td>
                                <td>{$row['mnumber']}</td>
                                <td>{$row['dob']}</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                                    <a href='delete.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this member?\");'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>












