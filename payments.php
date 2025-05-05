<?php
// Include database configuration
include 'config.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch user data for profile picture and username
$userQuery = "SELECT username, profile_photo FROM users WHERE id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userResult = $stmt->get_result();

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
    $username = htmlspecialchars($user['username']);
    $profilePhoto = htmlspecialchars($user['profile_photo'] ?: 'default_profile.svg');
} else {
    $username = 'Guest';
    $profilePhoto = 'default_profile.svg';
}

$stmt->close();

// Initialize the status filter variable
$status_filter = isset($_GET['status']) && $_GET['status'] !== "" ? $_GET['status'] : null;

try {
    // Prepare query to fetch payments along with username based on the filter
    if ($status_filter) {
        $sql = "SELECT payments.*, users.username AS payer_username 
                FROM payments 
                INNER JOIN users ON payments.user_id = users.id 
                WHERE payments.user_id = ? AND payments.status = ? 
                ORDER BY payments.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $status_filter);
    } else {
        $sql = "SELECT payments.*, users.username AS payer_username 
                FROM payments 
                INNER JOIN users ON payments.user_id = users.id 
                WHERE payments.user_id = ? 
                ORDER BY payments.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    die("Error fetching payments: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="./img/fav-icon.svg">
    <title>Payments</title>
    <style>
        /* General Body Style */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
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

        .header .btn-logout {
            background-color: #FF4C4C;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .header .btn-logout:hover {
            background-color: #e84141;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            height: 100vh;
            padding: 20px 0;
            position: fixed;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #4CAF50;
            border-radius: 5px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        /* Main Content Styles */
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f4f4f4;
            margin-top: 70px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Filters and Buttons */
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }

        .actions .filter {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .actions .filter select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .actions .btn-add {
            background-color: #4CAF50;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .actions .btn-add:hover {
            opacity: 0.9;
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
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">FITZONE FITNESS CENTER</div>
        <div class="user-info">
            <img src="./img/<?php echo $profilePhoto; ?>" alt="Profile Photo">
            <span>Welcome, <?php echo $username; ?>!</span>
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
                <li><a href="payments.php">Payments</a></li>
                <li><a href="gym_member_details.php">Gym Member Details</a></li>
                <li><a href="staff.php">Staff Management</a></li>
                <li><a href="class_schedule.php">Class Schedule</a></li>
                <li><a href="blog.php">Blogs</a></li>
                <li><a href="accountsettings.php">Account Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1>Payments</h1>

            <div class="actions">
                <a href="add_payment.php" class="btn-add">Add New Payment</a>
                <div class="filter">
                    <form method="GET" action="payments.php">
                        <label for="status">Filter by Status:</label>
                        <select name="status" id="status">
                            <option value="">All</option>
                            <option value="Completed" <?= $status_filter === 'Completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="Pending" <?= $status_filter === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Failed" <?= $status_filter === 'Failed' ? 'selected' : '' ?>>Failed</option>
                        </select>
                        <button type="submit" class="btn-add">Apply</button>
                    </form>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Username</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['payer_username']}</td>
                                <td>{$row['amount']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No payments found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
if (isset($conn)) {
    $conn->close();
}
?>
