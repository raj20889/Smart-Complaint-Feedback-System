<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Submit a Complaint</h2>
    <form action="submit_complaint.php" method="POST" enctype="multipart/form-data">
        <label for="category">Category:</label>
        <select name="category" required>
            <option value="Hostel">Hostel</option>
            <option value="Classroom">Classroom</option>
            <option value="WiFi">WiFi</option>
            <option value="Food">Food</option>
        </select><br>

        <label for="description">Description:</label><br>
        <textarea name="description" rows="4" required></textarea><br>

        <label for="image">Upload Image (Optional):</label>
        <input type="file" name="image"><br>

        <button type="submit" name="submit">Submit Complaint</button>
    </form>
</body>
</html>