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
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">

    <style>
    body {
        /* Using Montserrat as the base font */
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
        width: 210px;
        height: 210px;
        display: block;
        margin: 0 auto 2px auto;
    }

    .form-control {
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 15px;
        font-family: 'Montserrat', sans-serif; 
    }
    /* Add to your <style> block */
.form-control:focus {
    border-color: #007bff; /* Change border color on focus */
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Subtle blue glow */
    outline: none; /* Remove default outline */
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

    .message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .swal2-confirm.swal2-styled {
        background-color: #007bff !important;
        color: white !important;
        border: 1px solid #007bff !important;
    }
    </style>
</head>

<body>

    <div class="login-box card">
        <div class="card-body loginpage">
            <?php if (!empty($this->session->flashdata('feedback'))) { ?>
                <div class="message">
                    <strong>Danger! </strong><?php echo $this->session->flashdata('feedback') ?>
                </div>
            <?php } ?>

            <form class="form-horizontal form-material" method="post" id="loginform" action="login/Login_Auth">
                <a href="javascript:void(0)" class="text-center db">
                    <img src="<?php echo base_url(); ?>assets/images/optima-logo.png" alt="Home" />
                </a>

                <div class="form-group">
                    <input type="text" name="email" id="email" class="form-control" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <input class="form-control" name="password" value="<?php if (isset($_COOKIE['password'])) {
                                                                                echo $_COOKIE['password'];
                                                                            } ?>" type="password" required placeholder="Password">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="<?php echo base_url(); ?>assets/js/script.js"></script>

</body>

</html>