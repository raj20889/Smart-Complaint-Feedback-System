<?php include 'db.php'; 
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        select, textarea, input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit a Complaint</h2>
        <form action="submit_complaint.php" method="POST" enctype="multipart/form-data">
            <label for="category">Category:</label>
            <select name="category" required>
                <option value="Hostel">Hostel</option>
                <option value="Classroom">Classroom</option>
                <option value="WiFi">WiFi</option>
                <option value="Food">Food</option>
            </select>

            <label for="description">Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="image">Upload Image (Optional):</label>
            <input type="file" name="image">

            <button type="submit" name="submit">Submit Complaint</button>
        </form>
    </div>
</body>
</html>
