<?php
session_start();
include 'db.php'; // make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $otp = $_POST['otp'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email'])) {
        echo 'OTP expired or not sent.';
        exit;
    }

    if ($email === $_SESSION['otp_email'] && $otp == $_SESSION['otp']) {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);

        // Fetch user details
        $stmt = $conn->prepare("SELECT id, name, password FROM registered WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            // Verify password (assuming it's hashed)
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['loggedin'] = true;
                $_SESSION['user_email'] = $email;
                echo 'success';  // Send success only if login is successful
            } else {
                echo 'Incorrect password.';
            }
        } else {
            echo 'User not found.';
        }
    } else {
        echo 'Invalid OTP or email mismatch.';
    }
}

?>
