<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $description = $_POST['description'];
    $imagePath = "";

    // Handle Image Upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        $target = "uploads/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = $target;
        }
    }

    // Insert complaint into database
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, category, description, image_path) VALUES (?, ?, ?, ?)");
    $user_id = 1; // Replace with actual logged-in user ID
    $stmt->bind_param("isss", $user_id, $category, $description, $imagePath);

    if ($stmt->execute()) {
        echo "Complaint submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
