<?php
// Include database configuration
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $status = $_POST['status'];

    // Insert blog into the database
    $sql = "INSERT INTO blogs (title, category, content, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $category, $content, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Blog added successfully!'); window.location.href='blog.php';</script>";
    } else {
        echo "<script>alert('Error adding blog.');</script>";
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
    <title>Add Blog</title>
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

        form .reset-btn {
            background: #e74c3c;
        }

        form .reset-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Blog</h1>
        <form method="POST">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Enter blog title" required>

            <label for="category">Category</label>
            <input type="text" name="category" id="category" placeholder="Enter category (e.g., Fitness, Health)" required>

            <label for="content">Content</label>
            <textarea name="content" id="content" rows="5" placeholder="Write your blog content here..." required></textarea>

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="Published">Published</option>
                <option value="Draft">Draft</option>
            </select>

            <button type="submit">Add Blog</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </div>
</body>
</html>

