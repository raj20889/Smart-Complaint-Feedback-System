<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $role = $_POST['role']; // Role selected by the user

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already registered! Please login.'); window.location.href='login.php';</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; margin: 0;">
    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); width: 350px; text-align: center;">
        <h2 style="color: #333;">Register</h2>
        <form method="POST" style="display: flex; flex-direction: column;">
            <input type="text" name="name" placeholder="Full Name" required style="padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
            <input type="email" name="email" placeholder="Email" required style="padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
            <input type="password" name="password" placeholder="Password" required style="padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
            <label for="role" style="text-align: left; margin-top: 10px;">Select Role:</label>
            <select name="role" required style="padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" style="padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Register</button>
        </form>
        <p style="margin-top: 15px;">Already have an account? <a href="login.php" style="color: #007BFF; text-decoration: none;">Login here</a></p>
    </div>
</body>
</html>
