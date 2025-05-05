<?php
// Include database configuration
include 'config.php';

// Validate the `id` parameter
if (!isset($_GET['id']) || empty(trim($_GET['id'])) || !is_numeric($_GET['id'])) {
    echo "Invalid request. ID is missing or invalid.";
    exit();
}

// Fetch the member details
$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No member found with the specified ID.";
    exit();
}

$member = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the member
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mnumber = $_POST['mnumber'];
    $dob = $_POST['dob'];

    $stmt = $conn->prepare("UPDATE members SET username = ?, email = ?, password = ?, mnumber = ?, dob = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $username, $email, $password, $mnumber, $dob, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Something went wrong. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
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
    <div class="form-container">
        <h1>Edit Member</h1>
        <form method="POST" action="edit.php?id=<?php echo htmlspecialchars($id); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <label for="username">User Name</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($member['username']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($member['password']); ?>" required>

            <label for="mnumber">Mobile Number</label>
            <input type="text" id="mnumber" name="mnumber" value="<?php echo htmlspecialchars($member['mnumber']); ?>" required>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($member['dob']); ?>" required>

            <button type="submit" class="update-btn">Update</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>


