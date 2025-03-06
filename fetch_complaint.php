<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Complaint ID missing."]);
    exit();
}

$complaint_id = $_GET['id'];
$query = "SELECT * FROM complaints WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["error" => "Complaint not found."]);
} else {
    $complaint = $result->fetch_assoc();
    echo json_encode($complaint);
}
?>
