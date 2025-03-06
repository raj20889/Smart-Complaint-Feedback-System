<?php
include 'db.php';
include 'mail_config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Get user email from database
    $query = "SELECT users.email FROM complaints 
              JOIN users ON complaints.user_id = users.id 
              WHERE complaints.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $email = $user['email'];

        // Update complaint status
        $updateQuery = "UPDATE complaints SET status=? WHERE id=?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $status, $id);
        $updateStmt->execute();

        // Send email notification
        $subject = "Complaint Status Updated";
        $message = "Dear User,<br>Your complaint (ID: $id) status has been updated to <b>$status</b>.<br>Thank you!";
        
        if (sendEmail($email, $subject, $message)) {
            echo "<script>alert('Complaint status updated & Email sent successfully!');</script>";
        } else {
            echo "<script>alert('Complaint status updated but email sending failed.');</script>";
        }
    } else {
        echo "<script>alert('User email not found.');</script>";
    }
}

$result = $conn->query("SELECT * FROM complaints");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Admin Panel - Manage Complaints</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <select name="status">
                        <option value="Pending" <?php if ($row['status'] == "Pending") echo "selected"; ?>>Pending</option>
                        <option value="In Progress" <?php if ($row['status'] == "In Progress") echo "selected"; ?>>In Progress</option>
                        <option value="Resolved" <?php if ($row['status'] == "Resolved") echo "selected"; ?>>Resolved</option>
                    </select>
                    <button type="submit" name="update">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
