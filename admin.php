<?php
session_start();
include 'db.php';
include 'mail_config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

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

$result = $conn->query("SELECT * FROM complaints ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            width: 100px;
            height: 100px;
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.2s;
        }
        img:hover {
            transform: scale(1.1);
        }
        select, button {
            padding: 5px;
            font-size: 14px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            text-align: center;
        }
        .modal-content {
            display: block;
            margin: auto;
            max-width: 90%;
            max-height: 90%;
        }
        .close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            background: red;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

    <form method="POST" style="position: absolute; top: 10px; right: 20px;">
        <button type="submit" name="logout" class="logout-btn">Logout</button>
    </form>

    <h2>Admin Panel - Manage Complaints</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>
                <?php if (!empty($row['image_path'])) { ?>
                    <img src="<?php echo $row['image_path']; ?>" onclick="openModal('<?php echo $row['image_path']; ?>')">
                <?php } else { echo "No Image"; } ?>
            </td>
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

    <!-- Modal for Image Preview -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById("modalImage").src = imageSrc;
            document.getElementById("imageModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("imageModal").style.display = "none";
        }
    </script>

</body>
</html>
