<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$complaint_id = $_POST['complaint_id'];

// Check if the user has already voted
$checkVote = $conn->query("SELECT * FROM votes WHERE user_id = $user_id AND complaint_id = $complaint_id");

if ($checkVote->num_rows == 0) {
    // Insert vote
    $conn->query("INSERT INTO votes (complaint_id, user_id) VALUES ($complaint_id, $user_id)");
} else {
    // Remove vote (unvote)
    $conn->query("DELETE FROM votes WHERE user_id = $user_id AND complaint_id = $complaint_id");
}

// Return updated vote count
$result = $conn->query("SELECT COUNT(*) AS vote_count FROM votes WHERE complaint_id = $complaint_id");
$row = $result->fetch_assoc();
echo json_encode(["vote_count" => $row['vote_count']]);
?>
