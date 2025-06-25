<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optima HR</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfmgb/xmNOfQVZkgEoXZrRe8JGYaKcMHT7kcdSTFqNFF5wocNrUoVsEaOB+fbKhtKl8JqazQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(115deg, #62cff4, rgb(52, 109, 242));
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #fff;
        }

        .card-body.loginpage {
            padding: 40px;
            border-radius: 10px;
        }

        .card-body img {
            width: 180px;
            height: 180px;
            display: block;
            margin: 0 auto 2px auto;
        }

        /* Adjust padding to accommodate icon on the right */
        .form-control {
            border-radius: 6px;
            padding: 10px 40px 10px 12px; /* Top, Right (for icon), Bottom, Left (original padding) */
            font-size: 15px;
            font-family: 'Montserrat', sans-serif;
            position: relative;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative; /* Essential for positioning icons inside */
        }

        /* Icon Styling - Placed on the right */
        .form-group .form-control-feedback {
            position: absolute;
            top: 50%;
            right: 15px; 
            transform: translateY(-50%);
            color: #007bff; 
            pointer-events: none; 
            z-index: 2;
        }

        .form-group .form-control-feedback i {
            font-size: 20px; 
            line-height: 1;
            vertical-align: middle;
        }

        .btn-login {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        /* The original flash message div - hide it by default now that SweetAlert handles display */
        .message {
            display: none;
        }

        /* SweetAlert2 Customizations */
        .swal2-popup.square-modal {
            width: 320px;
            height: auto;
            border-radius: 8px;
        }

        .swal2-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 1.25rem;
            color: #333;
            text-align: center;
            padding-bottom: 1em;
            margin-bottom: 1em;
            border-bottom: 3px solid #e9ecef;
        }

        .swal2-html-container {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            color: #555;
            text-align: center;
            padding-top: 1em;
            padding-bottom: 1.5em;
        }

        .swal2-actions {
            margin-top: 0;
            padding-bottom: 0.5em;
        }

        .swal2-confirm.swal2-styled {
            background-color: #007bff !important;
            border: none !important;
            color: white !important;
            font-size: 0.9em !important;
            padding: 8px 20px !important;
            border-radius: 5px !important;
            min-width: unset !important;
        }

        .swal2-confirm.swal2-styled:hover {
            background-color: #0056b3 !important;
        }
    </style>
</head>

<body>

    <div class="login-box card">
        <div class="card-body loginpage">
            <?php if (!empty($this->session->flashdata('feedback'))) { ?>
                <div class="message" id="flashMessageContainer">
                    <strong>Notice: </strong><?php echo $this->session->flashdata('feedback') ?>
                </div>
            <?php } ?>

            <form class="form-horizontal form-material" method="post" id="loginform" action="<?php echo base_url(); ?>login/Login_Auth">
                <a href="javascript:void(0)" class="text-center db">
                    <img src="<?php echo base_url(); ?>assets/images/optima-logo.png" alt="Home" />
                </a>

                <div class="form-group">
                    <input type="text" name="email" id="email" class="form-control" placeholder="Username" required>
                    <span class="form-control-feedback"><i class="fa fa-user"></i></span>
                </div>

                <div class="form-group">
                    <input class="form-control" name="password" value="<?php if (isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>" type="password" required placeholder="Password">
                    <span class="form-control-feedback"><i class="fa fa-lock"></i></span>
                </div>

                <div class="form-group text-center m-t-20" style="margin-top: 30px;border-radius: 5px;">
                    <button class="btn btn-login btn-block text-uppercase waves-effect waves-light" type="submit">
                        Log In
                    </button>
                </div>
                <div class="text-center mt-3">
                    <a href="<?php echo base_url('homepage.php'); ?>" style="color: #3b82f6; font-weight: 500; text-decoration: none;">Visit Homepage</a>
                </div>
            </form>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sidebarmenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        console.log("Document ready event fired.");

        $(document).ready(function() {
            console.log("jQuery ready function entered.");

            var flashMessageContainer = $('#flashMessageContainer');
            console.log("Flash message container found:", flashMessageContainer.length > 0);

            if (flashMessageContainer.length) {
                var fullMessageText = flashMessageContainer.text().trim();
                var feedbackContent = fullMessageText.replace(/^Notice: /, '').trim();

                console.log("Full message text from flashdata:", fullMessageText);
                console.log("Cleaned feedback content:", feedbackContent);

                // Define expected messages from your PHP backend
                var wrongPasswordMessage = "Wrong password, please try again.";
                var invalidUsernameMessage = "Invalid Username.";
                var validationErrorMessage = "Please enter a valid username and password (min 6 chars for password, 7 for email).";
                var invalidCredentialsMessage = "UserEmail or Password is Invalid";

                let title = 'Error';
                let text = 'An unexpected error occurred. Please try again.';
                let icon = false; // Set to false to remove the icon

                if (feedbackContent === wrongPasswordMessage) {
                    title = 'Login Failed';
                    text = 'Wrong password, please try again.';
                } else if (feedbackContent === invalidUsernameMessage) {
                    title = 'Login Failed';
                    text = 'The username you entered is not recognized.';
                } else if (feedbackContent === validationErrorMessage) {
                    title = 'Validation Error';
                    text = 'Please ensure your email is at least 7 characters and password is at least 6 characters.';
                } else if (feedbackContent === invalidCredentialsMessage) {
                    title = 'Login Failed';
                    text = 'The username or password you entered is incorrect.';
                } else {
                    title = 'Login Notice';
                    text = feedbackContent || 'An unexpected login issue occurred. Please try again.';
                }

                // Show the SweetAlert2 modal
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon, // This is key to remove the icon
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#007bff', // Set button color directly
                    customClass: {
                        popup: 'square-modal', // Apply the custom class for square size
                    },
                    allowOutsideClick: false, // Prevents closing by clicking outside
                    allowEscapeKey: false,   // Prevents closing by pressing Escape key
                    allowEnterKey: true,     // Allows closing by pressing Enter key on the button
                });

                // Hide the original flash message container AFTER processing
                flashMessageContainer.hide();

            } else {
                console.log("No flash message container found, or flashdata is empty.");
            }
        });
    </script>

</body>

</html>