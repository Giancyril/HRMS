<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR-ERP</title>

    <script src="tailwind.config.js"></script>

    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">

    <style>
    body {
        background-color: #f0f2f5;
        margin: 0;
        min-height: 100vh;
        display: flex;
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
        width: 80px;
        height: 80px;
        display: block;
        margin: 0 auto 30px auto;
    }

    .form-control {
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 15px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-check {
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .btn-login {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 12px;
        font-size: 16px;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .btn-login:hover {
        background-color: #0056b3;
    }

    .message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        background-color: rgba(225, 225, 225, 0.5);
    }

    .loader {
        /* Explicitly set position and centering */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 54px;
        height: 54px;
        border-radius: 10px;
        /* Temporary background to visualize the loader container */
        /* background-color: yellow; */
        display: flex; /* To potentially center the bars if needed */
        justify-content: center;
        align-items: center;
    }

    .loader div {
        width: 8%;
        height: 24%;
        background: rgb(11, 11, 104);
        position: absolute;
        left: 50%;
        top: 30%;
        opacity: 0;
        border-radius: 50px;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        animation: fade458 1s linear infinite;
    }

    @keyframes fade458 {
        from {
            opacity: 1;
        }

        to {
            opacity: 0.25;
        }
    }

        .loader .bar1 {
            transform: rotate(0deg) translate(0, -130%);
            animation-delay: 0s;
        }

        .loader .bar2 {
            transform: rotate(30deg) translate(0, -130%);
            animation-delay: -1.1s;
        }

        .loader .bar3 {
            transform: rotate(60deg) translate(0, -130%);
            animation-delay: -1s;
        }

        .loader .bar4 {
            transform: rotate(90deg) translate(0, -130%);
            animation-delay: -0.9s;
        }

        .loader .bar5 {
            transform: rotate(120deg) translate(0, -130%);
            animation-delay: -0.8s;
        }

        .loader .bar6 {
            transform: rotate(150deg) translate(0, -130%);
            animation-delay: -0.7s;
        }

        .loader .bar7 {
            transform: rotate(180deg) translate(0, -130%);
            animation-delay: -0.6s;
        }

        .loader .bar8 {
            transform: rotate(210deg) translate(0, -130%);
            animation-delay: -0.5s;
        }

        .loader .bar9 {
            transform: rotate(240deg) translate(0, -130%);
            animation-delay: -0.4s;
        }

        .loader .bar10 {
            transform: rotate(270deg) translate(0, -130%);
            animation-delay: -0.3s;
        }

        .loader .bar11 {
            transform: rotate(300deg) translate(0, -130%);
            animation-delay: -0.2s;
        }

        .loader .bar12 {
            transform: rotate(330deg) translate(0, -130%);
            animation-delay: -0.1s;
        }

        #otp-verification {
            display: none;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div id="loadingOverlay">
        <div class="loader">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div>
            <div class="bar6"></div>
            <div class="bar7"></div>
            <div class="bar8"></div>
            <div class="bar9"></div>
            <div class="bar10"></div>
            <div class="bar11"></div>
            <div class="bar12"></div>
        </div>
    </div>


    <div class="login-box card">
        <div class="card-body loginpage">
            <?php if (!empty($this->session->flashdata('feedback'))) { ?>
                <div class="message">
                    <strong>Danger! </strong><?php echo $this->session->flashdata('feedback') ?>
                </div>
            <?php } ?>

            <form class="form-horizontal form-material" method="post" id="loginform" action="login/Login_Auth">
                <a href="javascript:void(0)" class="text-center db" style="margin-bottom: 30px;">
                    <img src="<?php echo base_url(); ?>assets/images/logo-icon1.png" alt="Home" />
                </a>

                <div class="relative">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                    <div class="absolute right-0 mt-2">
                        <a href="#" id="sendLoginOtp" class="text-sm text-blue-500" style="padding-left: 250px;">Send OTP</a>
                    </div>
                </div>

                <div id="otp-div" class="form-group hidden">
                    <input type="text" name="otp" id="otp" class="form-control" placeholder="OTP Code" minlength="6" maxlength="6" pattern="\d{6}" required>
                </div>

                <div class="form-group">
                    <input class="form-control" name="email" value="<?php if (isset($_COOKIE['email'])) {
                                                                        echo $_COOKIE['email'];
                                                                    } ?>" type="text" required placeholder="Username">
                </div>

                <div class="form-group">
                    <input class="form-control" name="password" value="<?php if (isset($_COOKIE['password'])) {
                                                                            echo $_COOKIE['password'];
                                                                        } ?>" type="password" required placeholder="Password">
                </div>

                <div class="form-group text-center m-t-20" style="margin-top: 40px;">
                    <button class="btn btn-login btn-block text-uppercase waves-effect waves-light" type="submit">
                        Log In
                    </button>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#sendLoginOtp').click(function(e) {
                e.preventDefault();
                const email = $('#email').val();

                if (!email) {
                    return Swal.fire('Error', 'Please enter your email first.', 'warning');
                }

                $('#loadingOverlay').fadeIn(); // Show the loader

                $.post('send_login_otp.php', { email: email }, function(res) {
                    $('#loadingOverlay').fadeOut(); // Hide the loader
                    if (res === 'success') {
                        $('#otp-div').show();
                        Swal.fire('Success', 'OTP sent to your email.', 'success');
                    } else {
                        Swal.fire('Error', res, 'error');
                    }
                });
            });
        });
    </script>
    <script src="<?php echo base_url(); ?>assets/js/script.js"></script>

</body>

</html>