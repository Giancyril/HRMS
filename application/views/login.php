<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optima HR</title>

    <script src="tailwind.config.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">

    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        background: linear-gradient(115deg, #62cff4,rgb(52, 109, 242));
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

    .form-control {
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 15px;
        font-family: 'Montserrat', sans-serif; 
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }

    .form-group {
        margin-bottom: 20px;
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

    /* Keep this visible for debugging purposes to check if flashdata is present */
    .message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
        /* Temporarily remove display: none; for debugging */
        /* display: none; */ 
    }

    /* Custom styles for Bootstrap Modal buttons to match your theme */
    .btn-secondary-custom {
        background-color: #6c757d; /* Bootstrap secondary color */
        border-color: #6c757d;
        color: white;
        padding: 8px 15px; /* Adjust padding as needed */
        font-size: 14px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .btn-secondary-custom:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .btn-primary-custom {
        background-color: #007bff; /* Bootstrap primary color */
        border-color: #007bff;
        color: white;
        padding: 8px 15px; /* Adjust padding as needed */
        font-size: 14px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .btn-primary-custom:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

  
    .modal-header {
        border-bottom: 1px solid #e9ecef;
        padding: 15px;
    }
    .modal-title {
        font-weight: 500;
        font-size: 1.25rem;
    }
    .modal-body {
        padding: 15px;
    }
    .modal-footer {
        padding: 15px;
        border-top: 1px solid #e9ecef;
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
                </div>

                <div class="form-group">
                    <input class="form-control" name="password" value="<?php if (isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>" type="password" required placeholder="Password">
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
    <script src="<?php echo base_url(); ?>assets/js/script.js"></script>

    <script>
        console.log("Document ready event fired."); // Check if jQuery's ready is working

        $(document).ready(function() {
            console.log("jQuery ready function entered.");

            var flashMessageContainer = $('#flashMessageContainer'); 
            console.log("Flash message container found:", flashMessageContainer.length > 0);

            if (flashMessageContainer.length) { 
                // Get the text content from PHP's flashdata (excluding the <strong> tag part)
                // Use .text() for the whole div, then trim or replace "Notice: " if it's there
                var fullMessageText = flashMessageContainer.text().trim();
                var feedbackContent = fullMessageText.replace(/^Notice: /, '').trim(); // Remove "Notice: " prefix

                console.log("Full message text from flashdata:", fullMessageText);
                console.log("Cleaned feedback content:", feedbackContent);
                
                var wrongPasswordMessage = "Wrong password, please try again."; 
                var validationErrorMessage = "Please enter a valid username and password (min 6 chars for password, 7 for email).";
                var invalidCredentialsMessage = "UserEmail or Password is Invalid";

                var $loginErrorModal = $('#loginErrorModal');
                var $loginErrorModalTitle = $loginErrorModal.find('.modal-title');
                var $loginErrorModalBody = $loginErrorModal.find('.modal-body');

                console.log("Is loginErrorModal present in DOM?", $loginErrorModal.length > 0);

                if (feedbackContent === wrongPasswordMessage) {
                    $loginErrorModalTitle.text('Login Failed');
                    $loginErrorModalBody.text('Wrong password, please try again.');
                    console.log("Attempting to show modal for: Wrong password");
                    $loginErrorModal.modal('show'); 
                } else if (feedbackContent === validationErrorMessage) {
                    $loginErrorModalTitle.text('Validation Error');
                    $loginErrorModalBody.text('Please ensure your email is at least 7 characters and password is at least 6 characters.');
                    console.log("Attempting to show modal for: Validation Error");
                    $loginErrorModal.modal('show'); 
                } else if (feedbackContent === invalidCredentialsMessage) { 
                    $loginErrorModalTitle.text('Login Failed');
                    $loginErrorModalBody.text('UserEmail or Password is Invalid');
                    console.log("Attempting to show modal for: Invalid Credentials");
                    $loginErrorModal.modal('show'); 
                } else {
                    console.log("Flash message not matching known patterns, showing original div.");
                    flashMessageContainer.show(); // Show original div if it's an unhandled message
                }

                // Hide the original flash message container AFTER processing (if it was visible for debug)
                // If you remove the 'display: none;' from .message CSS, this line will hide it again.
                // If you re-add 'display: none;' to .message, this line can be removed as it's already hidden.
                // flashMessageContainer.hide(); 
            } else {
                console.log("No flash message container found, or flashdata is empty.");
            }
        });
    </script>
   <div class="modal fade" id="loginErrorModal" tabindex="-1" role="dialog" aria-labelledby="loginErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginErrorModalLabel">Error</h5>
            </div>
            <div class="modal-body">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-custom" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

    </body>

</html>