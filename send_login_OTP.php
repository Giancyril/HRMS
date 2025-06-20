<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $otp = rand(100000, 999999);

    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;

    $subject = "Your Login OTP";
    $message = "Your one-time password (OTP) is: $otp";
    $headers = "From: no-reply@yourdomain.com\r\n" .
               "Reply-To: no-reply@yourdomain.com\r\n" .
               "X-Mailer: PHP/" . phpversion();

    if (mail($email, $subject, $message, $headers)) {
        echo 'success';
    } else {
        echo 'Failed to send OTP. Try again later.';
    }
}
?>