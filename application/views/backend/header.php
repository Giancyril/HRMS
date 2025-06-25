<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set('Asia/Dhaka');
// Assuming $this->settings_model->GetSettingsValue() and $this->employee_model->GetBasic() are accessible here
$settingsvalue = $this->settings_model->GetSettingsValue();
$id = $this->session->userdata('user_login_id');
$basicinfo = $this->employee_model->GetBasic($id);
$year = date('y');
$y = substr($year, -2);
$date = date("m/d/$y");
$leavetoday = $this->leave_model->GetLeaveToday($date);
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="GenIT">
    <link rel="icon" type="image/ico" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <title><?php echo $settingsvalue->sitetitle; ?></title>

    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/2.0.46/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/css/print.css" rel="stylesheet" media='print'>
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

    <style>
        /* Adjust dropdown width for better calendar display */
        .dropdown-menu.mailbox {
            min-width: 300px; /* Make sure it's wide enough for the calendar */
        }
        /* Ensure datepicker itself fits and doesn't cause overflow */
        #datepicker-container .datepicker {
            width: 100%;
            padding: 0; /* Remove default padding that might affect layout */
        }
        /* Hide the default input field for datepicker if it's just for display */
        #datepicker-container input[type="text"] {
            display: none;
        }
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url(); ?>"><b>
                            <img src="<?php echo base_url();?>assets/images/hricn.png" alt="DRI" class="DRI-logo" style="width:55px;margin-top: 10px;"/>
                            </b>
                            <span>
                             <img src="<?php echo base_url(); ?>assets/images/<?php echo $settingsvalue->sitelogo; ?>" alt="homepage" class="dark-logo" height="105px" width="105px" style="margin-top: 22px;" />
                            </span> </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-calendar"></i>
                            </a>
                            <div class="dropdown-menu mailbox scale-up-left" style="padding: 10px;">
                                <div id="datepicker-container" style="display: block;"></div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox scale-up-left">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <?php foreach($leavetoday as $value): ?>
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5><?php echo $value->first_name; ?></h5> <span class="mail-desc"><?php echo $value->reason; ?></span> <span class="time"><?php echo $value->start_date; ?></span> </div>
                                            </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basicinfo->em_image; ?>" alt="Genit" class="profile-pic" style="height:40px;width:40px;border-radius:50px;" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basicinfo->em_image; ?>" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?php echo $basicinfo->first_name.' '.$basicinfo->last_name; ?></h4>
                                                <p class="text-muted"><?php echo $basicinfo->em_email ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfo->em_id); ?>"><i class="ti-user"></i> My Profile</a></li>
                                    <?php if($this->session->userdata('user_type')!='EMPLOYEE'){ ?>

                                    <li><a href="<?php echo base_url(); ?>settings/Settings"><i class="ti-settings"></i> Settings</a></li>
                                    <?php } ?>
                                    <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>login/logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize the datepicker inside the dropdown when the dropdown is shown
            $('.nav-item.dropdown').on('shown.bs.dropdown', function () {
                // Check if this is the dropdown containing our datepicker
                if ($(this).find('#datepicker-container').length) {
                    $('#datepicker-container').datepicker({
                        format: "yyyy-mm-dd", // You can change this to "MM dd, yyyy" if preferred
                        todayHighlight: true,
                        autoclose: false, // Keep it open so user can interact, or set to true if you want it to close on selection
                        container: '#datepicker-container', // Render inside this div
                        // If you want to highlight specific dates (e.g., from your notifications)
                        // This would require fetching those dates from PHP and passing them
                        // beforeShowDay: function(date){
                        //     // Example: highlight weekends
                        //     if (date.getDay() == 0 || date.getDay() == 6) {
                        //         return { classes: 'weekend', tooltip: 'Weekend' };
                        //     }
                        //     return;
                        // }
                    }).on('changeDate', function(e) {
                        // Optional: You can do something when a date is selected
                        console.log('Date selected:', e.format('yyyy-mm-dd'));
                        // If you want to update a hidden input or trigger an action:
                        // $('#selectedDateInput').val(e.format('yyyy-mm-dd'));
                        // Example: You could redirect or load data for the selected date
                        // window.location.href = '<?php echo base_url(); ?>dashboard/view_by_date/' + e.format('yyyy-mm-dd');
                    });
                }
            });

            // Prevent dropdown from closing when clicking inside datepicker
            $(document).on('click', '#datepicker-container', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>