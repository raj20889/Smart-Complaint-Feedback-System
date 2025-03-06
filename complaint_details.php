<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get complaint ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location='admin_panel.php';</script>";
    exit();
}

$complaint_id = $_GET['id'];

// Fetch complaint details from the database
$query = "SELECT complaints.*, users.name AS username, users.email 
          FROM complaints 
          JOIN users ON complaints.user_id = users.id 
          WHERE complaints.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Complaint not found!'); window.location='admin_panel.php';</script>";
    exit();
}

$complaint = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .complaint-info {
            text-align: left;
            margin-bottom: 20px;
        }
        img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 5px;
        }
        .back-btn {
            display: inline-block;
            padding: 8px 15px;
            background: blue;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background: darkblue;
        }
    </style>
</head>
<body>

    <h2>Complaint Details</h2>

    <div class="container">
        <div class="complaint-info">
            <p><strong>Complaint ID:</strong> <?php echo $complaint['id']; ?></p>
            <p><strong>User Name:</strong> <?php echo $complaint['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $complaint['email']; ?></p>
            <p><strong>Category:</strong> <?php echo $complaint['category']; ?></p>
            <p><strong>Description:</strong> <?php echo $complaint['description']; ?></p>
            <p><strong>Status:</strong> <?php echo $complaint['status']; ?></p>
            <?php if (!empty($complaint['image_path'])) { ?>
                <p><strong>Image:</strong></p>
                <img src="<?php echo $complaint['image_path']; ?>" alt="Complaint Image">
            <?php } else { echo "<p><strong>Image:</strong> No Image Provided</p>"; } ?>
        </div>
        <a href="admin.php" class="back-btn">Back to Admin Panel</a>
    </div>

</body>
</html>
