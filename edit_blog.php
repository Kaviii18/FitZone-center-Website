<?php
// Include database configuration
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch blog details
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $content = $_POST['content'];
        $status = $_POST['status'];

        // Update blog details
        $sql = "UPDATE blogs SET title = ?, category = ?, content = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $category, $content, $status, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Blog updated successfully!'); window.location.href='blog.php';</script>";
        } else {
            echo "<script>alert('Error updating blog.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "<script>alert('Invalid blog ID.'); window.location.href='blog.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #121212;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px 5px #4CAF50;
            position: relative;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin: 15px 0 5px;
            color: white;
        }

        form input, form textarea, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }

        form button {
            padding: 10px 20px;
            margin: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        form button:hover {
            background: #45a049;
        }

        .reset-btn {
            background: #e74c3c;
        }

        .reset-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Blog</h1>
        <form method="POST">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>

            <label for="category">Category</label>
            <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($blog['category']); ?>" required>

            <label for="content">Content</label>
            <textarea name="content" id="content" rows="5" required><?php echo htmlspecialchars($blog['content']); ?></textarea>

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="Published" <?php echo $blog['status'] == 'Published' ? 'selected' : ''; ?>>Published</option>
                <option value="Draft" <?php echo $blog['status'] == 'Draft' ? 'selected' : ''; ?>>Draft</option>
            </select>

            <button type="submit">Update Blog</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>

