<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR-ERP</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <!-- Theme Colors -->
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
            margin: 0;
            height: 100vh;
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
            margin: 0 auto 20px auto;
        }

        .form-control {
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 15px;
        }

        .form-check {
            margin-top: 10px;
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
                    <img src="<?php echo base_url(); ?>assets/images/logo-icon1.png" alt="Home" />
                </a>

                <h1>Log in your Account</h1>

                <div class="form-group m-t-40">
                    <input class="form-control" name="email" value="<?php if (isset($_COOKIE['email'])) {
                        echo $_COOKIE['email'];
                    } ?>" type="text" required placeholder="Username">
                </div>

                <div class="form-group">
                    <input class="form-control" name="password" value="<?php if (isset($_COOKIE['password'])) {
                        echo $_COOKIE['password'];
                    } ?>" type="password" required placeholder="Password">
                </div>

                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember-me">
                    <label class="form-check-label" for="remember-me">Remember me</label>
                </div>

                <div class="form-group text-center m-t-20">
                    <button class="btn btn-login btn-block text-uppercase waves-effect waves-light" type="submit" style="border-radius: 5px;">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
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
</body>

</html>