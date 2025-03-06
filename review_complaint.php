<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if complaint ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request.'); window.location.href='complaints.php';</script>";
    exit();
}

$complaint_id = intval($_GET['id']);
$reviewer_id = $_SESSION['user_id'];

// Handle review submission
if (isset($_POST['submit_review'])) {
    $review_text = trim($_POST['review_text']);
    
    if (!empty($review_text)) {
        $stmt = $conn->prepare("INSERT INTO review (complaint_id, reviewer_id, review_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $complaint_id, $reviewer_id, $review_text);
        
        if ($stmt->execute()) {
            echo "<script>alert('Review submitted successfully!'); window.location.href='complaints.php';</script>";
        } else {
            echo "<script>alert('Error submitting review.');</script>";
        }
    } else {
        echo "<script>alert('Review cannot be empty.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Complaint</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
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
        textarea {
            width: 100%;
            height: 100px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
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
        <h2>Submit a Review</h2>
        <form method="POST">
            <textarea name="review_text" placeholder="Write your review here..." required></textarea>
            <button type="submit" name="submit_review">Submit Review</button>
        </form>
    </div>
</body>
</html>
