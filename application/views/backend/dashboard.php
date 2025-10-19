<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard <span class="badge badge-pill badge-info ml-2">HR Management</span></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Start of combined card -->
        <div class="card card-outline-info">
            <div class="card-body">
                <?php
                // --- START OF OPTIMIZED DATA FETCHING (unchanged) ---
                $session_user_identifier = $this->session->userdata('user_login_id');
                $employee_data = null;

                if (!empty($session_user_identifier)) {
                    $this->db->select('em_joining_date, first_name, last_name, em_image, des_name, dep_name'); // Ensure em_joining_date is selected
                    $this->db->join('designation', 'designation.id = employee.des_id', 'left');
                    $this->db->join('department', 'department.id = employee.dep_id', 'left');

                    if (is_numeric($session_user_identifier) && (int)$session_user_identifier > 0) {
                        $this->db->where('employee.id', $session_user_identifier);
                        
                    } else {
                        $this->db->where('employee.em_id', $session_user_identifier);
                    }

                    $employee_query_result = $this->db->get('employee');

                    if ($employee_query_result->num_rows() > 0) {
                        $employee_data = $employee_query_result->row();
                    }
                }

                $user_image_path = base_url() . 'assets/images/users/default_user.png';
                $designation_name = 'N/A';
                if ($employee_data) {
                    if (!empty($employee_data->em_image)) {
                        if (file_exists('./assets/images/users/' . $employee_data->em_image)) {
                            $user_image_path = base_url() . 'assets/images/users/' . $employee_data->em_image;
                        }
                    }
                    if (isset($employee_data->des_name) && !empty($employee_data->des_name)) {
                        $designation_name = $employee_data->des_name;
                    }
                }
                // --- END OF OPTIMIZED DATA FETCHING ---
                ?>

<div class="d-flex flex-row align-items-center mb-4">
    <div class="round-img mr-4" style="flex-shrink: 0;">
        <img src="<?php echo $user_image_path; ?>" alt="user" width="65" height="65" class="img-circle">
    </div>
    <div class="m-l-10">
        <h3 class="m-t-0 m-b-0 font-weight-medium text-dark">
            Welcome Back, <?php echo $this->session->userdata('name'); ?>
        </h3>
        
        <div class="d-flex align-items-center text-muted m-t-5 m-b-0">
            <span class="mr-3 font-weight-medium"><i class="fa fa-briefcase m-r-5"></i> <?php echo $designation_name; ?></span>
            
            <?php if ($employee_data && !empty($employee_data->em_joining_date)): ?>
                <span class="mr-3 tex-black">|</span>
                <span class="text-black small"><i class="fa fa-calendar-alt m-r-5"></i> Started at: <?php echo date('F j, Y', strtotime($employee_data->em_joining_date)); ?></span>
            <?php endif; ?>
            
            <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($this->session->userdata('user_login_id')); ?>" class="text-primary ml-4 small font-weight-medium">
                <i class="fa fa-edit m-r-5"></i> Update Profile
            </a>
        </div>
    </div>
</div>

<hr class="thicker-hr mt-4 mb-4" />

                <!-- Start of the new row with four combined cards -->
                <div class="row">
                    <!-- Combined Employees Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-primary"><i class="ti-user"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->where('status','ACTIVE');
                                    $this->db->from("employee");
                                    echo $this->db->count_all_results();
                                    ?> Employees
                                </h3>
                                <a href="<?php echo base_url(); ?>employee/Employees" class="text-muted m-b-0">View Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Combined Leaves Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-info"><i class="ti-calendar"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->where('leave_status','Approve');
                                    $this->db->from("emp_leave");
                                    echo $this->db->count_all_results();
                                    ?> Leaves
                                </h3>
                                <a href="<?php echo base_url(); ?>leave/Application" class="text-muted m-b-0">View Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Combined Projects Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-danger"><i class="ti-clipboard"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->where('pro_status','running');
                                    $this->db->from("project");
                                    echo $this->db->count_all_results();
                                    ?> Projects
                                </h3>
                                <a href="<?php echo base_url(); ?>Projects/All_Projects" class="text-muted m-b-0">View Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Combined Payslips Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-warning"><i class="ti-money"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->from("pay_salary");
                                    echo $this->db->count_all_results();
                                    ?> Payslips
                                </h3>
                                <a href="<?php echo base_url('payroll/salary_list'); ?>" class="text-muted m-b-0">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of the new row with four combined cards -->
            </div>
        </div>
        <!-- End of combined card -->

        

        <?php 
// This checks if the logged-in user's type is NOT 'EMPLOYEE'
if($this->session->userdata('user_type') != 'EMPLOYEE'){ 
?>
        
        <div class="row">
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-primary" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #5c4ac7;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Former Employees</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                        <?php
                        $this->db->where('status','INACTIVE');
                        $this->db->from("employee");
                        echo $this->db->count_all_results();
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.50em; color: #5c4ac7;">
                    <i class="fas fa-sign-out"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-info" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #1976d2;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Leave Applications</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                        <?php
                        $this->db->where('leave_status','Not Approve');
                        $this->db->from("emp_leave");
                        echo $this->db->count_all_results();
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.60em; color: #1976d2;">
                    <i class="fas fa-calendar-check-o"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-danger" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #ef5350;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Upcoming Project</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                        <?php
                        $this->db->where('pro_status','upcoming');
                        $this->db->from("project");
                        echo $this->db->count_all_results();
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.50em; color: #ef5350;">
                    <i class="fas fa-project-diagram"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-warning" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #ffb22b;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Payslips Pending</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                        <?php
                        $this->db->from("employee");
                        $total_employees = $this->db->count_all_results();
                        $this->db->from("pay_salary");
                        $generated_payslips = $this->db->count_all_results();
                        $payslips_pending = $total_employees - $generated_payslips;
                        echo $payslips_pending;
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.60em; color: #ffb22b;">
                    <i class="fas fa-money-bill-alt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
    <div class="card card-custom card-border-cyan" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #C562AF;">
        <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
            <div class="card-text flex-grow-1" style="flex-grow: 1;">
                <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Active Goals</h6>
                <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                    <?php
                    $this->db->from("goals"); 
                    $this->db->where('Status', 'In Progress');
                    echo $this->db->count_all_results();
                    ?>
                </h1>
            </div>
            <div class="icon-lg" style="font-size: 1.50em; color: #C562AF;">
                <i class="fas fa-bullseye"></i>
            </div>
        </div>
    </div>
</div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
    <div class="card card-custom card-border-info" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #EF7722;">
        <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
            <div class="card-text flex-grow-1" style="flex-grow: 1;">
                <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;"> Total Departments</h6>
                <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                    <?php
                    $this->db->from("department");
                    echo $this->db->count_all_results();
                    ?>
                </h1>
            </div>
            <div class="icon-lg" style="font-size: 1.50em; color: #EF7722;">
                <i class="fas fa-layer-group"></i>
            </div>
        </div>
    </div>
</div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
    <div class="card card-custom card-border-dark" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #7ADAA5;">
        <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
            <div class="card-text flex-grow-1" style="flex-grow: 1;">
                <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Job Vacancies</h6>
                <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                    <?php
                    $this->db->from("jobs"); 
                    $this->db->where('is_active', 1);
                    echo $this->db->count_all_results();
                    ?>
                </h1>
            </div>
            <div class="icon-lg" style="font-size: 1.50em; color: #7ADAA5;">
                <i class="fas fa-bullhorn"></i>
            </div>
        </div>
    </div>
</div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-success" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #17a2b8;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Granted Loans</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 500; color: #54667a;">
                        <?php
                        $this->db->where('status', 'Granted');
                        $this->db->from("loan");
                        echo $this->db->count_all_results();
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.60em; color: #17a2b8;">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// This closes the IF condition
} 
?>
  

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 text-black font-weight-medium">
            <i class="fas fa-briefcase mr-2"></i> Latest Job Postings
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 25%;">Title</th>
                        <th style="width: 60%;">Description</th>
                        <th style="width: 15%;">Posted Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($latest_jobs)): ?>
                        <?php foreach ($latest_jobs as $job): ?>
                            <tr>
                                <td class="text-dark font-weight-semibold"><?= html_escape($job->job_title); ?></td>
                                <td class="text-muted"><?= html_escape(substr($job->description, 0, 60)) . '...'; ?></td>
                                <td class="text-secondary"><?= html_escape(date('M d, Y', strtotime($job->posted_at))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle mr-1"></i> No jobs are currently posted.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



    


                <?php $notice = $this->notice_model->GetNoticelimit();
                $running = $this->dashboard_model->GetRunningProject();
                $userid = $this->session->userdata('user_login_id');
                $todolist = $this->dashboard_model->GettodoInfo($userid);
                // Modified to only get upcoming holidays (today or later)
                $this->db->select('*');
                $this->db->from('holiday');
                $this->db->where('from_date >=', date('Y-m-d'));
                $holiday = $this->db->get()->result();
                ?>
                <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-b-0 text-black"> <i class="fas fa-rocket mr-2"></i>Running Projects</h5>
                        <a href="<?php echo base_url(); ?>Projects/All_Projects" class="text-primary small">View All &rarr;</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height:400px;overflow-y:auto">
                            <table class="table table-hover table-sm mb-0">
                    <thead class="thead-light">
                                    <tr>
                                        <th>Title</th>
                                        <th style="width: 20%;">Start Date</th>
                                        <th style="width: 20%;">End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $running = $this->dashboard_model->GetRunningProject(); ?>
                                    <?php if ($running): ?>
                                        <?php foreach($running as $value): ?>
                                        <tr>
                                            <td><a href="<?php echo base_url(); ?>Projects/view?P=<?php echo base64_encode($value->id); ?>" class="text-dark font-weight-semibold"><?php echo html_escape(substr($value->pro_name, 0, 35)).(strlen($value->pro_name) > 35 ? '...' : ''); ?></a></td>
                                            <td><?php echo date('M j, Y', strtotime($value->pro_start_date)); ?></td>
                                            <td><?php echo date('M j, Y', strtotime($value->pro_end_date)); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center text-muted">No running projects found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Task Tracker -->
    <div class="col-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-header py-3">
            <h5 class="m-b-0 text-black"> <i class="fas fa-check-square mr-2"></i> Task Tracker</h5>
        </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
                    <ul class="list-group list-task todo-list m-0" data-role="tasklist">
                        <?php foreach($todolist as $value): ?>
                            <li class="list-group-item d-flex align-items-center" data-role="task">
                                <div class="form-check">
                                    <input class="form-check-input to-do" type="checkbox"
                                           data-id="<?= $value->id ?>"
                                           data-value="<?= $value->value == '1' ? '0' : '1' ?>"
                                           id="task_<?= $value->id ?>"
                                           <?= $value->value != '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label <?= $value->value != '1' ? 'task-done text-muted' : '' ?>"
                                           for="task_<?= $value->id ?>">
                                        <?= $value->to_dodata; ?>
                                    </label>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Add New Task -->
                <div class="new-todo pt-3 border-top">
                    <form method="post" action="add_todo" enctype="multipart/form-data" id="add_todo">
                        <div class="input-group">
                            <input type="text" name="todo_data" class="form-control" placeholder="Add a new task">
                            <input type="hidden" name="userid" value="<?= $this->session->userdata('user_login_id'); ?>">
                            <button type="submit" class="btn btn-info todo-submit">
                                Add</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


                <div class="row">

                    <div class="col-lg-7 mb-4">
    <div class="card h-100">
        <div class="card-header py-3">
            <h5 class="m-b-0 text-black"> <i class="fas fa-bullhorn mr-2"></i> Notice Board <span class="badge badge-secondary badge-pill ml-2"><?php echo count($this->notice_model->GetNoticelimit() ?? []); ?></span></h5>
        </div>
        <div class="card-body">
            <?php $notice = $this->notice_model->GetNoticelimit(); ?>
            <div class="table-responsive slimScrollDiv" style="height:400px;overflow-y:auto"> 
                <table class="table table-hover table-md mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th style="width: 50%;">Title</th>
                            <th style="width: 25%;">File</th>
                            <th style="width: 25%;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($notice): ?>
                            <?php foreach($notice as $value): ?>
                            <tr>
                                <td><?php echo html_escape($value->title) ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>assets/images/notice/<?php echo $value->file_url ?>" target="_blank" class="text-info small"><i class="fas fa-file-alt"></i> View File</a>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($value->date)); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted">No recent announcements.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-5 mb-4">
    <div class="card h-100">
        <div class="card-header py-3">
            <h5 class="m-b-0 text-black"> <i class="fas fa-calendar-day mr-2"></i>  Upcoming Holidays</h5>
        </div>
        <div class="card-body">
            <?php 
            $this->db->select('*');
            $this->db->from('holiday');
            $this->db->where('from_date >=', date('Y-m-d'));
            $this->db->order_by('from_date', 'ASC');
            $this->db->limit(10); // Limit to top 10
            $holiday = $this->db->get()->result();
            ?>
            <div class="table-responsive" style="height:400px;overflow-y:auto">
                <table class="table table-hover table-md mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th>Holiday Name</th>
                            <th style="width: 40%;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($holiday): ?>
                            <?php foreach($holiday as $value): ?>
                                <tr>
                                    <td><span class="font-weight-bold"><?php echo html_escape($value->holiday_name); ?></span></td>
                                    <td><span class="badge badge-info"><?php echo date('l, M j', strtotime($value->from_date)); ?></span></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center text-muted">No upcoming holidays scheduled.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

               
<script>
 $(".to-do").on("click", function(){
    //console.log($(this).attr('data-value'));
    $.ajax({
        url: "Update_Todo",
        type:"POST",
        data:
        {
        'toid': $(this).attr('data-id'),        
        'tovalue': $(this).attr('data-value'),
        },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
           console.error();
        }
    });
 });           
</script>                        
<?php $this->load->view('backend/footer'); ?>