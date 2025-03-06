<?php
session_start();
include 'db.php';

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get the complaint ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid request.";
    exit();
}
$complaint_id = intval($_GET['id']); // Sanitize input

// Fetch complaint details
$complaint_query = $conn->prepare("SELECT * FROM complaints WHERE id = ?");
$complaint_query->bind_param("i", $complaint_id);
$complaint_query->execute();
$complaint_result = $complaint_query->get_result();
$complaint = $complaint_result->fetch_assoc();

if (!$complaint) {
    echo "Complaint not found.";
    exit();
}

// Fetch reviews for this complaint
$reviews_query = $conn->prepare("SELECT r.*, u.name FROM review r JOIN users u ON r.reviewer_id = u.id WHERE r.complaint_id = ? ORDER BY r.reviewed_at DESC");
$reviews_query->bind_param("i", $complaint_id);
$reviews_query->execute();
$reviews = $reviews_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .back-btn {
            background-color: red;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

    <h2>Reviews for Complaint #<?php echo htmlspecialchars($complaint['id']); ?></h2>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($complaint['category']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($complaint['description']); ?></p>

    <table>
        <tr>
            <th>Reviewer</th>
            <th>Review</th>
            <th>Reviewed At</th>
        </tr>
        <?php while ($row = $reviews->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['review_text']); ?></td>
            <td><?php echo htmlspecialchars($row['reviewed_at']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <button class="back-btn" onclick="window.location.href='admin.php'">Back</button>

</body>
</html>
