<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.ico">
    <title>Optima HR</title>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
    
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #3D74B6;
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
            border-radius: 15px;
            background-color: #fff;
        }

        .card-body.loginpage {
            padding: 40px;
            border-radius: 10px;
        }

        .card-body img {
            width: 150px;
            height: 150px;
            display: block;
            margin: 0 auto 2px auto;
        }

        /* Adjust padding to accommodate icon on the right */
        .form-control {
            border-radius: 6px;
            padding: 10px 40px 10px 12px;
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
            position: relative;
        }
        
        /* SHAKE EFFECT CSS START */
        .form-group.shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-10px);
            }
            40% {
                transform: translateX(10px);
            }
            60% {
                transform: translateX(-10px);
            }
            80% {
                transform: translateX(10px);
            }
            100% {
                transform: translateX(0);
            }
        }
        /* SHAKE EFFECT CSS END */

        /* Icon Styling - Placed on the right */
        .form-group .form-control-feedback {
            position: absolute;
            top: 50%;
            right: 15px; 
            transform: translateY(-50%);
            color: #6c757d; 
            pointer-events: none; 
            z-index: 2;
        }

        .form-group .form-control-feedback i {
            font-size: 18px; 
            line-height: 1;
            vertical-align: middle;
        }

        .btn-login {
            background-color: #3D74B6;
            border: none;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 16px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background-color: #33A1E0 ;
        }

        /* New Social Login CSS */
        .divider {
            text-align: center;
            margin: 14px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e1e1;
        }

        .divider span {
            background: #ffffff;
            color: #727272;
            padding: 0 16px;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }

        .social-login {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 18px;
        }

        .social-btn {
            width: 100%;
            background: #ffffff;
            color: #191414;
            border: 1.5px solid #d9d9d9;
            border-radius: 8px;
            padding: 12px 20px;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.2s ease;
            min-height: 44px;
        }

        .social-btn:hover {
            border-color: #191414;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .social-btn:active {
            transform: translateY(0);
        }

        .signup-link {
            display: flex;
            justify-content: center;
            margin-bottom: -5px;
        }

        .signup-link p {
            color: #727272;
            font-size: 14px;
        }

        .signup-link a {
            color: #00a9e0;
            text-decoration: none;
            font-weight: 300;
            transition: color 0.2s ease;
        }

        .signup-link a:hover {
            color: #00a9e0;
            text-decoration: underline;
        }
        /* End of new CSS */

        /* The original flash message div - hide it by default now that SweetAlert handles display */
        .message {
            display: none;
        }

        /* SweetAlert2 Customizations */
        .swal2-popup.square-modal {
            width: 300px;
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
            border-bottom: 2px solid #e9ecef;
            
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

                <div class="form-group text-center m-t-20" style="margin-top: 35px; margin-bottom: 14px; border-radius: 8px;">
                        <button class="btn btn-login btn-block text-uppercase waves-effect waves-light" type="submit">
                            Login
                        </button>
                    </div>

                <!-- Added divider and social login buttons -->
                <div class="divider">
                    <span>or</span>
                </div>

                <div class="social-login">
                    <button type="button" class="social-btn google-btn">
                        <svg width="18" height="18" viewBox="0 0 18 18">
                            <path fill="#4285F4" d="M16.51 8H8.98v3h4.3c-.18 1-.74 1.48-1.6 2.04v2.01h2.6a7.8 7.8 0 002.38-5.88c0-.57-.05-.66-.15-1.18z"/>
                            <path fill="#34A853" d="M8.98 17c2.16 0 3.97-.72 5.3-1.94l-2.6-2.04a4.8 4.8 0 01-2.7.75 4.8 4.8 0 01-4.52-3.36H1.83v2.07A8 8 0 008.98 17z"/>
                            <path fill="#FBBC05" d="M4.46 10.41a4.8 4.8 0 010-2.82V5.52H1.83a8 8 0 000 7.16l2.63-2.07z"/>
                            <path fill="#EA4335" d="M8.98 3.58c1.32 0 2.5.45 3.44 1.35l2.54-2.59A8 8 0 001.83 5.52l2.63 2.07c.7-2.07 2.67-3.36 4.52-3.36z"/>
                        </svg>
                        Continue with Google
                    </button>
                </div>

                <div class="signup-link">
                        <p>For more information, <a href="<?php echo base_url('homepage.php'); ?>">visit our homepage</a></p>
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

            var emailField = $('#email').closest('.form-group');
            var passwordField = $('input[name="password"]').closest('.form-group');

            let title = 'Error';
            let text = 'An unexpected error occurred. Please try again.';
            let icon = 'error'; // Use a standard icon for better clarity in top-right alerts

            // --- SHAKE EFFECT LOGIC ---
            emailField.removeClass('shake');
            passwordField.removeClass('shake');

            if (feedbackContent === "Wrong password, please try again.") {
                title = 'Login Failed';
                text = 'Wrong password, please try again.';
                passwordField.addClass('shake');
            } else if (feedbackContent === "Invalid Username.") {
                title = 'Login Failed';
                text = 'The username you entered is not recognized.';
                emailField.addClass('shake');
            } else if (feedbackContent === "Please enter a valid username and password (min 6 chars for password, 7 for email).") {
                title = 'Validation Error';
                text = 'Please ensure your email is at least 7 characters and password is at least 6 characters.';
                emailField.addClass('shake');
                passwordField.addClass('shake');
            } else if (feedbackContent === "UserEmail or Password is Invalid") {
                title = 'Login Failed';
                text = 'The username or password you entered is incorrect.';
                emailField.addClass('shake');
                passwordField.addClass('shake');
            } else {
                title = 'Login Notice';
                text = feedbackContent || 'An unexpected login issue occurred. Please try again.';
            }

            // Show the SweetAlert2 modal at the top-right
            Swal.fire({
                position: 'top', // This positions the modal
                    // Using a standard icon
                title: title,
                text: text,
                showConfirmButton: false, // Hides the OK button
                timer: 2000, // Closes the modal after 2 seconds
                backdrop: false, // Makes the background transparent
                customClass: {
                    container: 'top-right-alert'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
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