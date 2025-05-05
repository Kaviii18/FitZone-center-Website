<?php
// Include database configuration
include 'config.php';

// Validate and fetch the staff ID
if (!isset($_GET['id']) || empty(trim($_GET['id'])) || !is_numeric($_GET['id'])) {
    echo "Invalid request. Staff ID is missing or invalid.";
    exit();
}

$id = intval($_GET['id']);

// Fetch the staff member's details
$staffQuery = "SELECT * FROM staff WHERE id = ?";
$stmt = $conn->prepare($staffQuery);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No staff member found with the specified ID.";
    exit();
}

$staff = $result->fetch_assoc();

// Handle form submission for updating the staff member
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];

    // Update the staff member in the database
    $updateQuery = "UPDATE staff SET name = ?, email = ?, phone = ?, role = ?, salary = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssdi", $name, $email, $phone, $role, $salary, $id);

    if ($stmt->execute()) {
        // Redirect to the staff management page after successful update
        header("Location: staff.php?message=Staff%20member%20updated%20successfully");
        exit();
    } else {
        echo "Something went wrong. Please try again.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Member</title>
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
        .form-container .update-btn {
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
        <h1>Edit Staff Member</h1>
        <form method="POST" action="edit_staff.php?id=<?php echo htmlspecialchars($id); ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($staff['name']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required>

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($staff['phone']); ?>" required>

            <label for="role">Role</label>
            <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($staff['role']); ?>" required>

            <label for="salary">Salary</label>
            <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($staff['salary']); ?>" required>

            <button type="submit" class="update-btn">Update</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>
