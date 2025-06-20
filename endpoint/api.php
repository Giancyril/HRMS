<?php
session_start();
include 'config.php';

// Function to generate a random OTP
function generateOTP() {
    return rand(100000, 999999);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = isset($_POST['action']) ? $_POST['action'] : null;

    switch ($action) {
        case "sendotp":
            $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400); // Bad Request
                echo "Invalid email address";
                exit;
            }

            // Generate OTP
            $otp = generateOTP();
            $_SESSION['otp_email'] = $email;
            $_SESSION['otp'] = $otp;

            // Email subject and message
            $subject = "Your OTP for Registration";
            $message = "Your OTP is: <b>" . $otp . "</b><br>Please do not share the OTP!";
            $message .= "<br>This OTP is valid for 5 minutes only.";

            // Email headers
            $header = "From: Password Team <youremail@gmail.com>" . "\r\n";
            $header .= "Reply-To: youremail@gmail.com" . "\r\n";
            $header .= "MIME-Version: 1.0" . "\r\n";
            $header .= "Content-Type: text/html; charset=iso-8859-1\r\n";

            // Send email
            $mailSent = mail($email, $subject, $message, $header);

            if ($mailSent) {
                $_SESSION['otp_timestamp'] = time();
                echo "OTP Sent Successfully";
            } else {
                http_response_code(500); // Internal Server Error
                echo "Failed to send OTP";
            }
            break;

        case "verifyotp":
            $enteredOTP = isset($_POST['otp']) ? $_POST['otp'] : '';
            $savedOTP = isset($_SESSION['otp']) ? $_SESSION['otp'] : '';
            $savedEmail = isset($_SESSION['otp_email']) ? $_SESSION['otp_email'] : '';
            $savedTimestamp = isset($_SESSION['otp_timestamp']) ? $_SESSION['otp_timestamp'] : 0;
            $enteredEmail = isset($_POST['otp_email']) ? $_POST['otp_email'] : '';

            if ($enteredOTP == $savedOTP && $enteredEmail == $savedEmail) {
                // Check if the timestamp is within 5 minutes (300 seconds)
                if (time() <= ($savedTimestamp + 300)) {
                    echo "OTP Verified";
                } else {
                    unset($_SESSION['otp']);
                    unset($_SESSION['otp_email']);
                    unset($_SESSION['otp_timestamp']);
                    echo "OTP Expired";
                }
            } else {
                echo "Invalid OTP or Email";
            }
            break;

        case "registration":
            $savedOTP = isset($_SESSION['otp']) ? $_SESSION['otp'] : '';
            $savedEmail = isset($_SESSION['otp_email']) ? $_SESSION['otp_email'] : '';
            $savedTimestamp = isset($_SESSION['otp_timestamp']) ? $_SESSION['otp_timestamp'] : 0;

            $enteredEmail = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
            $enteredOTP = isset($_POST['otp']) ? $_POST['otp'] : '';
            $password = isset($_POST["password"]) ? $_POST["password"] : '';
            $name = isset($_POST["name"]) ? mysqli_real_escape_string($conn, $_POST["name"]) : '';

            if ($enteredOTP == $savedOTP && $enteredEmail == $savedEmail) {
                // Check if the timestamp is within 5 minutes
                if (time() <= ($savedTimestamp + 300)) {

                    if (empty($name) || !filter_var($enteredEmail, FILTER_VALIDATE_EMAIL) || empty($password)) {
                        echo "Please fill in all the required fields for registration.";
                        http_response_code(400);
                        exit;
                    }

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO registered (name, email, password)
                            VALUES ('$name', '$enteredEmail', '$hashedPassword')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        unset($_SESSION['otp']);
                        unset($_SESSION['otp_email']);
                        unset($_SESSION['otp_timestamp']);
                        echo "reg_success";
                    } else {
                        echo "Registration failed: " . mysqli_error($conn);
                        http_response_code(500);
                    }

                } else {
                    unset($_SESSION['otp']);
                    unset($_SESSION['otp_email']);
                    unset($_SESSION['otp_timestamp']);
                    echo "OTP Expired";
                    http_response_code(400);
                }
            } else {
                echo "Error while registration: Invalid OTP or Email";
                http_response_code(400);
            }
            break;

        case "login":
            $email = isset($_POST["email"]) ? mysqli_real_escape_string($conn, $_POST["email"]) : '';
            $password = isset($_POST["password"]) ? $_POST["password"] : '';

            if (empty($email) || empty($password)) {
                echo "Please enter both email and password.";
                http_response_code(400);
                exit;
            }

            $sql = "SELECT * FROM registered WHERE email = ?";

            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);

                if ($row && password_verify($password, $row['password'])) {
                    echo "login_success";
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_email'] = $row['email'];
                    $_SESSION['user_name'] = $row['name'];
                } else {
                    echo "login_failed";
                    http_response_code(401); // Unauthorized
                }
            } else {
                echo "Database error during login.";
                http_response_code(500);
            }
            break;

        case "logout":
            session_unset();
            session_destroy();
            echo "logout_success";
            break;

        default:
            http_response_code(400); // Bad Request
            echo "Invalid Action";
            break;
    }

} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid Request Method";
}
?>