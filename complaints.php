<?php
include 'db.php';
$result = $conn->query("SELECT * FROM complaints ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Complaint List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>
                <?php if ($row['image_path']) { ?>
                    <img src="<?php echo $row['image_path']; ?>" width="50">
                <?php } ?>
            </td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>