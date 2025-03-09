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

// Fetch complaints sorted by votes (highest first)
$result = $conn->query("SELECT complaints.*, COUNT(votes.id) AS vote_count FROM complaints 
                        LEFT JOIN votes ON complaints.id = votes.complaint_id 
                        GROUP BY complaints.id ORDER BY vote_count DESC, created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 text-center">

    <form method="POST" class="absolute top-4 right-6">
        <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
    </form>

    <h2 class="text-2xl font-bold text-gray-800">Admin Panel - Manage Complaints</h2>

    <div class="overflow-x-auto mt-6">
        <table class="w-full border-collapse border border-gray-300 bg-white shadow-lg">
            <tr class="bg-gray-200">
                <th class="p-3 border">ID</th>
                <th class="p-3 border">Category</th>
                <th class="p-3 border">Description</th>
                <th class="p-3 border">Image</th>
                <th class="p-3 border">Votes</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Action</th>
                <th class="p-3 border">View</th>
                <th class="p-3 border">Reviews</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr class="border">
                <td class="p-3 border"> <?php echo $row['id']; ?> </td>
                <td class="p-3 border"> <?php echo $row['category']; ?> </td>
                <td class="p-3 border"> <?php echo $row['description']; ?> </td>
                <td class="p-3 border">
                    <?php if (!empty($row['image_path'])) { ?>
                        <img src="<?php echo $row['image_path']; ?>" class="w-20 h-20 object-cover rounded cursor-pointer hover:scale-110 transition-transform" onclick="openModal('<?php echo $row['image_path']; ?>')">
                    <?php } else { echo "No Image"; } ?>
                </td>
                <td class="p-3 border font-bold <?php echo ($row['vote_count'] > 10) ? 'text-yellow-500' : ''; ?>"> <?php echo $row['vote_count']; ?> </td>
                <td class="p-3 border"> <?php echo $row['status']; ?> </td>
                <td class="p-3 border">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <select name="status" class="p-1 border rounded">
                            <option value="Pending" <?php if ($row['status'] == "Pending") echo "selected"; ?>>Pending</option>
                            <option value="In Progress" <?php if ($row['status'] == "In Progress") echo "selected"; ?>>In Progress</option>
                            <option value="Resolved" <?php if ($row['status'] == "Resolved") echo "selected"; ?>>Resolved</option>
                        </select>
                        <button type="submit" name="update" class="ml-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">Update</button>
                    </form>
                </td>
                <td class="p-3 border">
                    <a href="complaint_details.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">View</a>
                </td>
                <td class="p-3 border">
                    <a href="view_reviews.php?id=<?php echo $row['id']; ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700">Reviews</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden flex justify-center items-center">
        <span class="absolute top-6 right-10 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
        <img class="max-w-full max-h-full" id="modalImage">
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById("modalImage").src = imageSrc;
            document.getElementById("imageModal").classList.remove("hidden");
        }
        function closeModal() {
            document.getElementById("imageModal").classList.add("hidden");
        }
    </script>

</body>
</html>
