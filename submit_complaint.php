<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Unauthorized access!'); window.location.href='login.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id']; // Use the logged-in user's ID
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $imagePath = "";

    // Handle Image Upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $target = "uploads/" . $imageName;

        // Ensure "uploads" directory exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = $target;
        } else {
            echo "<script>alert('Error uploading image!'); window.history.back();</script>";
            exit;
        }
    }

    // Insert complaint into database
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, category, description, image_path, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isss", $user_id, $category, $description, $imagePath);

    if ($stmt->execute()) {
        echo "<script>alert('Complaint submitted successfully!'); window.location.href='complaints.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
