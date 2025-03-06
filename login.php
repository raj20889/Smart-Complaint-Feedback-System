<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashedPassword, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Store user info in session
            $_SESSION['user_id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            echo "<script>alert('Invalid password! Try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>
                let register = confirm('Email not found! Would you like to register?');
                if (register) {
                    window.location.href = 'register.php';
                } else {
                    window.history.back();
                }
              </script>";
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
    <title>Login</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; margin: 0;">
    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); width: 350px; text-align: center;">
        <h2 style="color: #333;">Login</h2>
        <form method="POST" style="display: flex; flex-direction: column;">
            <input type="email" name="email" placeholder="Email" required style="padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
            <input type="password" name="password" placeholder="Password" required style="padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" style="padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Login</button>
        </form>
        <p style="margin-top: 15px;">Not registered? <a href="register.php" style="color: #007BFF; text-decoration: none;">Create an account</a></p>
    </div>
</body>
</html>
