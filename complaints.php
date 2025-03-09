<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch complaints sorted by votes
$result = $conn->query("
    SELECT c.*, 
           (SELECT COUNT(*) FROM votes v WHERE v.complaint_id = c.id) AS vote_count 
    FROM complaints c 
    ORDER BY vote_count DESC, created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-5">

    <!-- Logout Button -->
    <form method="POST" class="absolute top-5 right-5">
        <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md shadow hover:bg-red-700 transition">
            Logout
        </button>
    </form>

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">Complaint List</h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-4 border border-gray-300">Complaint No.</th>
                        <th class="p-4 border border-gray-300">Category</th>
                        <th class="p-4 border border-gray-300">Description</th>
                        <th class="p-4 border border-gray-300">Image</th>
                        <th class="p-4 border border-gray-300">Status</th>
                        <th class="p-4 border border-gray-300">Votes</th>
                        <th class="p-4 border border-gray-300">Vote</th>
                        <th class="p-4 border border-gray-300">Review</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $first_complaint = true;
                    while ($row = $result->fetch_assoc()) { 
                        $complaint_id = $row['id'];

                        // Check if user has already voted
                        $userVoted = $conn->query("SELECT * FROM votes WHERE user_id = $user_id AND complaint_id = $complaint_id")->num_rows > 0;
                    ?>
                    <tr class="border-b hover:bg-gray-100 transition">
                        <td class="p-4 border border-gray-300 text-center"><?php echo $row['id']; ?></td>
                        <td class="p-4 border border-gray-300 text-center"><?php echo $row['category']; ?></td>
                        <td class="p-4 border border-gray-300 text-center">
                            <?php echo $row['description']; ?>
                            <?php if ($first_complaint) { ?>
                                <span class="ml-2 px-2 py-1 text-xs bg-green-500 text-white rounded-full">Recommended</span>
                            <?php } ?>
                        </td>
                        <td class="p-4 border border-gray-300 text-center">
                            <?php if (!empty($row['image_path'])) { ?>
                                <div class="w-28 h-28 flex items-center justify-center">
                                    <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-cover rounded-md cursor-pointer hover:scale-105 transition" 
                                        onclick="openModal('<?php echo $row['image_path']; ?>')">
                                </div>
                            <?php } else { echo "No Image"; } ?>
                        </td>
                        <td class="p-4 border border-gray-300 text-center"><?php echo $row['status']; ?></td>
                        <td class="p-4 border border-gray-300 text-center" id="vote-count-<?php echo $row['id']; ?>"><?php echo $row['vote_count']; ?></td>
                        <td class="p-4 border border-gray-300 text-center">
                            <button class="px-4 py-2 rounded-md text-white 
                                <?php echo $userVoted ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-700'; ?>" 
                                <?php echo $userVoted ? 'disabled' : ''; ?> 
                                onclick="vote(<?php echo $row['id']; ?>)">
                                <?php echo $userVoted ? "Voted" : "Vote"; ?>
                            </button>
                        </td>
                        <td class="p-4 border border-gray-300 text-center">
                            <a href="review_complaint.php?id=<?php echo $row['id']; ?>" class="bg-yellow-500 text-black px-4 py-2 rounded-md hover:bg-yellow-600 transition">
                                Review
                            </a>
                        </td>
                    </tr>
                    <?php 
                        $first_complaint = false; 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 hidden bg-black bg-opacity-80 flex items-center justify-center p-4">
        <span class="absolute top-5 right-5 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
        <img class="max-w-full max-h-screen rounded-md shadow-lg" id="modalImage">
    </div>

    <!-- JavaScript for Modal and Voting -->
    <script>
        function openModal(imageSrc) {
            document.getElementById("modalImage").src = imageSrc;
            document.getElementById("imageModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("imageModal").classList.add("hidden");
        }

        function vote(complaintId) {
            let formData = new FormData();
            formData.append("complaint_id", complaintId);

            fetch("vote.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById("vote-count-" + complaintId).innerText = data.vote_count;
                    location.reload(); // Refresh to update UI
                }
            })
            .catch(error => console.error("Error:", error));
        }
    </script>

</body>
</html>
