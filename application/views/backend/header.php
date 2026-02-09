<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set('Asia/Manila');

$id = $this->session->userdata('user_login_id');
$basicinfo = $this->employee_model->GetBasic($id); 
$settingsvalue = $this->settings_model->GetSettingsValue();

$current_date = date('m/d/y');
$leavetoday = $this->leave_model->GetLeaveToday($current_date); 
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="GenIT">
    <?php $settingsvalue = $this->settings_model->GetSettingsValue(); ?>
    <link rel="icon" type="image/ico" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon/favicon-1.ico">
    <title><?php echo $settingsvalue->sitetitle; ?></title>
    
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <style>
    :root {
        --first-color: #1976d2; 
        --title-color: hsla(220, 7%, 8%, 1.00);
        --text-color-light: hsl(222, 8%, 65%);
        --white-color: #fff;
        --body-color: hsl(222, 100%, 99%);
        --body-font: "Poppins", sans-serif;
        --small-font-size: .813rem;
    }
    
    @media screen and (min-width: 968px) {
        :root {
            --small-font-size: .875rem;
        }
    }
    
    .navbar-nav.mr-auto.mt-md-0 {
        display: flex;
        align-items: center; 
    }

    .nav-item.search-container {
        display: flex;
        align-items: center; 
    }

    .header-search-form {
        position: relative;
        width: 40px; 
        height: 40px; 
        background-color: var(--first-color); 
        border-radius: 20px; 
        padding: 0; 
        overflow: visible;
        display: flex;
        align-items: center;
        transition: width 0.5s cubic-bezier(0.9, 0, 0.3, 0.9), background-color 0.5s;
        max-width: 400px; 
    }
    
    .header-search-form.show-search {
        background-color: var(--white-color);
        width: 250px; 
    }

    .header-search-input {
        border: none;
        outline: none;
        width: calc(100% - 40px); 
        height: 100%;
        border-radius: 20px; 
        padding-left: 10px; 
        font-family: var(--body-font);
        font-size: var(--small-font-size);
        font-weight: 500;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s 0.2s; 
        background-color: transparent;
        color: var(--title-color); 
    }
    
    .header-search-form.show-search .header-search-input {
        opacity: 1;
        pointer-events: initial;
        background-color: var(--white-color); 
    }

    .header-search-input::placeholder {
        color: var(--text-color-light); 
    }

    .header-search-button {
        width: 30px;
        height: 30px;
        background-color: var(--first-color);
        border-radius: 50%;
        position: absolute;
        top: 5px; 
        right: 5px; 
        margin: auto;
        display: grid;
        place-items: center;
        cursor: pointer;
        border: none; 
        transition: transform 0.6s cubic-bezier(0.9, 0, 0.3, 0.9);
        z-index: 10;
    }
    
    .header-search-button:focus {
        outline: none; 
        box-shadow: none; 
    }

    .search__icon, .search__close {
        color: var(--white-color);
        font-size: 1rem; 
        position: absolute;
        transition: opacity 0.3s cubic-bezier(0.9, 0, 0.3, 0.9);
    }

    .search__close {
        opacity: 0;
    }

    .header-search-form.show-search .header-search-button {
        transform: rotate(90deg);
    }

    .header-search-form.show-search .search__icon {
        opacity: 0;
    }
    
    .header-search-form.show-search .search__close {
        opacity: 1;
    }

    @media screen and (max-width: 575px) {
        .header-search-form.show-search {
            width: 90%; 
        }
    }
    
    .dropdown-menu.calendar-dropdown {
        padding: 10px;
        width: 320px; 
        max-width: 90vw; 
        height: auto;
        overflow: visible; 
    }
    .calendar-container {
        font-size: 12px; 
    }

    /* FIX 1: Remove top/bottom list padding */
    .calendar-dropdown ul li {
        padding-top: 0;
        padding-bottom: 0;
    }
    
    /* FIX 2: TIGHTENED title padding to remove space above and below the date text */
    .calendar-dropdown .drop-title {
        padding: 3px 20px 3px 20px; /* Reduced all padding to tighten it up */
        margin: 0; /* Ensure no external margin */
    }
    
    /* FIX 3: Remove FullCalendar internal header bottom margin */
    .calendar-container .fc-toolbar.fc-header-toolbar {
        margin-bottom: 0 !important; /* Forces the month text closer to the days */
        padding-bottom: 0;
    }
    .calendar-container .fc-day-header {
        font-size: 10px;
    }

    /* Advanced Search Bar Styles */
    .search-results-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        margin-top: 5px;
    }

    .search-results-dropdown ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .search-results-dropdown li {
        padding: 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .search-results-dropdown li:last-child {
        border-bottom: none;
    }

    .search-result-item {
        padding: 12px 15px;
        cursor: pointer;
        transition: background-color 0.2s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-result-item:hover {
        background-color: #f5f5f5;
    }

    .search-result-item a {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        text-decoration: none;
        color: inherit;
    }

    .search-status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-active {
        background-color: #4caf50;
    }

    .status-leave {
        background-color: #ff9800;
    }

    .status-inactive {
        background-color: #ccc;
    }

    .search-result-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
        flex: 1;
    }

    .search-result-name {
        font-weight: 500;
        font-size: 13px;
        color: #333;
    }

    .search-result-meta {
        font-size: 12px;
        color: #666;
    }

    .search-no-results {
        padding: 20px;
        text-align: center;
        color: #999;
        font-size: 13px;
    }

    #search-bar {
        position: relative;
    }

</style>

</head>

<body class="fix-header fix-sidebar card-no-border">
    <?php 
        // Variables defined at the top of the file
        // $id, $basicinfo, $settingsvalue, $current_date, $leavetoday are now available
    ?>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
   <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url(); ?>"><b>
                                <img src="<?php echo base_url();?>assets/images/hricn-1.png" alt="DRI" class="DRI-logo" style="width:55px;margin-top: 25px;"/>
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
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell"></i>
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

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Calendar"> 
                                <i class="fas fa-calendar-alt"></i>
                            </a>
                            <div class="dropdown-menu mailbox scale-up-left calendar-dropdown">
                                <ul>
                                    <li>
                                        <div class="calendar-container">
                                            <div id="header-calendar"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php if ($this->session->userdata('user_type') === 'ADMIN' || $this->session->userdata('user_type') === 'HR'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Quick Actions">
                                    <i class="fas fa-plus-circle"></i> <span class="hidden-xs-down"></span>
                                </a>
                                <div class="dropdown-menu mailbox scale-up-left" style="width: 250px;">
                                    <a class="dropdown-item" href="<?php echo base_url('employee/Add_employee'); ?>">
                                        <i class="fas fa-user-plus" style="width: 25px;"></i> Add Employee
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('Projects/All_Projects'); ?>">
                                         <i class="fas fa-rocket" style="width: 25px;"></i> Manage Projects
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('Recruitment'); ?>">
                                        <i class="fas fa-bullhorn" style="width: 25px;"></i> Job Postings
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('dashboard/analytics_view'); ?>">
                                        <i class="fas fa-chart-bar" style="width: 25px;"></i> Analytics Reports
                                    </a>
                                </div>
                            </li>
                        <?php elseif ($this->session->userdata('user_type') === 'HR-MANAGER'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="My Actions">
                                    <i class="fas fa-plus-circle"></i> <span class="hidden-xs-down"></span>
                                </a>
                                <div class="dropdown-menu mailbox scale-up-left" style="width: 250px;">
                                    <a class="dropdown-item" href="<?php echo base_url('attendance/Save_Attendance'); ?>">
                                        <i class="fas fa-calendar-check" style="width: 25px;"></i> Add Attendance
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('leave/Application'); ?>">
                                        <i class="fa fa-calendar-alt" style="width: 25px;"></i> Leave Application
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('Payroll/Generate_salary'); ?>">
                                        <i class="fas fa-money-check-alt" style="width: 25px;"></i> Generate Payslip
                                    </a>
                                </div>
                            </li>
                        <?php elseif ($this->session->userdata('user_type') === 'EMPLOYEE'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Employee Actions">
                                    <i class="fas fa-plus-circle"></i> <span class="hidden-xs-down"></span>
                                </a>
                                <div class="dropdown-menu mailbox scale-up-left" style="width: 250px;">
                                    <a class="dropdown-item" href="<?php echo base_url('payroll/Payslip_Report'); ?>">
                                        <i class="fas fa-file-invoice" style="width: 25px;"></i> View Payslips
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('leave/EmApplication'); ?>">
                                        <i class="fas fa-calendar-plus" style="width: 25px;"></i> Request Leave
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url('Recruitment'); ?>">
                                        <i class="fas fa-bullhorn" style="width: 25px;"></i> Job Postings
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    

                        <li class="nav-item hidden-sm-down search-container">
                            <div class="header-search-form" id="search-bar"> 
                               <input type="text" class="header-search-input" id="global-search-input" placeholder="Search" value="" autocomplete="off">      
                            <button type="button" class="header-search-button" id="search-button" aria-label="Toggle Search">
                                <i class="fas fa-search search__icon"></i> 
                                <i class="fas fa-times search__close"></i> 
                            </button>
                            <!-- AJAX Search Results Dropdown -->
                            <div id="search-results-dropdown" class="search-results-dropdown" style="display: none;">
                                <ul id="search-results-list"></ul>
                            </div>
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
                                    <li><a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfo->em_id); ?>"><i class="ti-user"></i>&nbsp; My Profile</a></li>
                                    <?php if($this->session->userdata('user_type')!='EMPLOYEE'){ ?>
                                    
                                    <li><a href="<?php echo base_url(); ?>settings/Settings"><i class="ti-settings"></i>&nbsp; Settings</a></li>
                                    <?php } ?>
                                    <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="ti-power-off"></i>&nbsp; Logout</a></li>
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
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Sign Out</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you sure you want to end your session? Confirm to securely end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="<?php echo base_url(); ?>login/logout">Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
    
    <script>
    // Existing Search Toggle Logic
    const toggleSearch = (search, button) => {
        const searchBar = document.getElementById(search); 
        const searchButton = document.getElementById(button);
        const searchInput = searchBar.querySelector('input'); 

        if (!searchBar || !searchButton) {
            console.error('Search bar elements not found. Check your IDs.');
            return;
        }

        searchButton.addEventListener('click', () => {
            searchBar.classList.toggle('show-search');
            
            if (searchBar.classList.contains('show-search')) {
                setTimeout(() => {
                    searchInput.focus(); 
                }, 500); 
            } else {
                searchInput.blur();
                // Clear input and hide results when closing the search
                try {
                    searchInput.value = '';
                    const resultsDropdownEl = document.getElementById('search-results-dropdown');
                    const resultsListEl = document.getElementById('search-results-list');
                    if (resultsListEl) resultsListEl.innerHTML = '';
                    if (resultsDropdownEl) resultsDropdownEl.style.display = 'none';
                    if (window.globalSearchTimeout) {
                        clearTimeout(window.globalSearchTimeout);
                        window.globalSearchTimeout = null;
                    }
                } catch (e) {
                    // ignore
                }
            }
        });
    };

    // Initialize the toggle function
    toggleSearch('search-bar', 'search-button');

    // AJAX Global Search Functionality
    $(document).ready(function() {
        const searchInput = $('#global-search-input');
        const resultsDropdown = $('#search-results-dropdown');
        const resultsList = $('#search-results-list');
        // make timeout globally accessible so toggleSearch can cancel it
        window.globalSearchTimeout = null;

        // Perform search on input
        searchInput.on('keyup', function() {
            const searchTerm = $(this).val().trim();

            // Clear previous timeout
            if (window.globalSearchTimeout) {
                clearTimeout(window.globalSearchTimeout);
                window.globalSearchTimeout = null;
            }

            // Hide dropdown if search is empty
            if (searchTerm.length < 2) {
                resultsDropdown.hide();
                resultsList.html('');
                return;
            }

            // Debounce the search request (wait 300ms after user stops typing)
            window.globalSearchTimeout = setTimeout(function() {
                performGlobalSearch(searchTerm);
                window.globalSearchTimeout = null;
            }, 300);
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#search-bar').length) {
                resultsDropdown.hide();
            }
        });

        // Perform AJAX search
        function performGlobalSearch(searchTerm) {
            $.ajax({
                url: '<?php echo base_url("employee/global_search"); ?>',
                type: 'GET',
                data: { search: searchTerm },
                dataType: 'json',
                success: function(response) {
                    displaySearchResults(response);
                },
                error: function(xhr, status, error) {
                    console.error('Search error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    resultsList.html('<li class="search-no-results">Error performing search. Please try again.</li>');
                    resultsDropdown.show();
                }
            });
        }

        // Display search results in dropdown
        function displaySearchResults(results) {
            resultsList.html('');

            if (!results || results.length === 0) {
                resultsList.html('<li class="search-no-results">No data found</li>');
                resultsDropdown.show();
                return;
            }

            results.forEach(function(employee) {
                const statusClass = getStatusClass(employee.status);
                const resultHtml = `
                    <li>
                        <a href="<?php echo base_url('employee/view'); ?>?I=${btoa(employee.em_id)}" class="search-result-item">
                            <div class="search-status-indicator ${statusClass}" title="${employee.status}"></div>
                            <div class="search-result-info">
                                <div class="search-result-name">${employee.first_name} ${employee.last_name}</div>
                                <div class="search-result-meta">
                                    ID: ${employee.em_code} | ${employee.des_name} | ${employee.dep_name}
                                </div>
                            </div>
                        </a>
                    </li>
                `;
                resultsList.append(resultHtml);
            });

            resultsDropdown.show();
        }

        // Determine status class based on employee status
        function getStatusClass(status) {
            if (status === 'ACTIVE') return 'search-status-indicator status-active';
            if (status === 'LEAVE') return 'search-status-indicator status-leave';
            return 'search-status-indicator status-inactive';
        }
    });

    // ⭐️ FIX: Stop clicks inside the calendar dropdown from closing it ⭐️
    $(document).ready(function() {
        // Target the specific dropdown menu for the calendar
        $('.dropdown-menu.calendar-dropdown').on('click', function(e) {
            // This stops the click from propagating up and prevents the dropdown from closing
            e.stopPropagation();
        });

        // FullCalendar Initialization Logic 
        // Initialize FullCalendar when the calendar dropdown is opened
        $('.nav-item.dropdown').on('show.bs.dropdown', function(e) {
            // Check if the calendar icon triggered the dropdown
            if ($(e.target).find('.fas.fa-calendar-alt').length > 0) {
                // Check if the calendar has already been initialized (prevents re-initialization)
                if ($('#header-calendar').hasClass('fc')) {
                    // If initialized, just force it to re-render to show correctly
                    $('#header-calendar').fullCalendar('render');
                } else {
                    // Initialize FullCalendar
                    $('#header-calendar').fullCalendar({
                        header: {
                            left: 'prev',
                            center: 'title',
                            right: 'next'
                        },
                        defaultView: 'month', 
                        editable: false,
                        eventLimit: true, // allow "more" link when too many events
                        
                        // Adjust size for dropdown view
                        height: 300,
                        contentHeight: 'auto',
                        aspectRatio: 1.5,
                        
                        // Small customization for compact view
                        dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                        // Optional: load events if needed, e.g., from an API
                        // events: '<?php //echo base_url("calendar/getEvents"); ?>',
                    });
                }
            }
        });
        
        // Ensure the calendar re-renders correctly when the dropdown becomes visible
        $('.nav-item.dropdown').on('shown.bs.dropdown', function(e) {
            if ($(e.target).find('.fas.fa-calendar-alt').length > 0) {
                $('#header-calendar').fullCalendar('render');
            }
        });
    });
    // ⭐️ END FIX: Stop clicks inside the calendar dropdown from closing it ⭐️
    </script>
    </body>
</html>