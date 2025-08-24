<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
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
                    <div class="round-img mr-3">
                        <img src="<?php echo $user_image_path; ?>" alt="user" width="60" height="60" class="img-circle">
                    </div>
                    <div class="m-l-4">
                        <h4 class="m-t-0 m-b-0">
                            Welcome Back, <?php echo $this->session->userdata('name'); ?>
                            <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($this->session->userdata('user_login_id')); ?>" class="text-muted">&nbsp;<i class="fa fa-pencil"></i></a>
                        </h4>
                        <h6 class="text-muted m-t-5 m-b-0"><?php echo $designation_name; ?></h6>
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
                            <div class="round align-self-center round-info"><i class="ti-file"></i></div>
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
                            <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
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

        

        <div class="row">
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-primary" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #5c4ac7;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Former Employees</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 400; color: #54667a;">
                        <?php
                        $this->db->where('status','INACTIVE');
                        $this->db->from("employee");
                        echo $this->db->count_all_results();
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.50em; color: #ccc;">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-info" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #1976d2;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Leave Applications</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 400; color: #54667a;">
                        <?php
                        $this->db->where('leave_status','Not Approve');
                        $this->db->from("emp_leave");
                        echo $this->db->count_all_results();
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.60em; color: #ccc;">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-success" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #ef5350;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Upcoming Project</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 400; color: #54667a;">
                        <?php
                        $this->db->where('pro_status','upcoming');
                        $this->db->from("project");
                        echo $this->db->count_all_results();
                        ?>
                    </h1>
                </div>
                <div class="icon-lg" style="font-size: 1.50em; color: #ccc;">
                    <i class="fas fa-project-diagram"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-custom card-border-danger" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: all 0.3s ease-in-out; border-left: 5px solid #ffb22b;">
            <div class="card-body d-flex flex-row align-items-center" style="display: flex; justify-content: space-between; align-items: center; padding: 1.25rem;">
                <div class="card-text flex-grow-1" style="flex-grow: 1;">
                    <h6 class="card-title" style="margin: 0; font-size: 0.78rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Payslips Pending</h6>
                    <h1 class="card-value" style="margin: 5px 0 0; font-size: 1.5rem; font-weight: 400; color: #54667a;">
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
                <div class="icon-lg" style="font-size: 1.60em; color: #ccc;">
                    <i class="fas fa-money-bill-alt"></i>
                </div>
            </div>
        </div>
    </div>
</div>
  

<div class="card">
 <div class="card-header">
  <h4 class="m-b-0 text-black">Latest Job Postings</h4>
 </div>
 <div class="card-body">
  <div class="table-responsive">
   <table class="table table-hover table-striped">
    <thead>
     <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Posted Date</th>
     </tr>
    </thead>
    <tbody>
     <?php if (!empty($jobs)): ?>
      <?php foreach ($jobs as $job): ?>
       <tr>
        <td><?php echo html_escape($job['title']); ?></td>
        <td><?php echo html_escape(substr($job['description'], 0, 75)) . '...'; ?></td>
        <td><?php echo html_escape(date('F j, Y', strtotime($job['posted_at']))); ?></td>
       </tr>
      <?php endforeach; ?>
     <?php else: ?>
      <tr>
       <td colspan="3" class="text-center">No jobs are currently posted.</td>
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Running Projects</h4>
                                <h6 class="card-subtitle">Projects currently in progress</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="height:600px;overflow-y:scroll">
                                    <table class="table table-bordered table-hover earning-box">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($running AS $value): ?>
                                            <tr style="vertical-align:top;">
                                                <td><a href="<?php echo base_url(); ?>Projects/view?P=<?php echo base64_encode($value->id); ?>"><?php echo substr("$value->pro_name",0,25).'...'; ?></a></td>
                                                <td><?php echo $value->pro_start_date; ?></td>
                                                <td><?php echo $value->pro_end_date; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">To Do list</h4>
                                <h6 class="card-subtitle">List of your task to complete</h6>
                                <div class="to-do-widget m-t-20" style="height:597px;overflow-y:scroll">
                                        <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                            <?php foreach($todolist as $value): ?>
                                            <li class="list-group-item" data-role="task">
                                                <?php if($value->value == '1'){ ?>
                                                <div class="checkbox checkbox-info">
                                                    <input class="to-do" data-id="<?php echo $value->id?>" data-value="0" type="checkbox" id="<?php echo $value->id?>" >
                                                    <label for="<?php echo $value->id?>"><span><?php echo $value->to_dodata; ?></span></label>
                                                </div>
                                                <?php } else { ?>
                                                <div class="checkbox checkbox-info">
                                                    <input class="to-do" data-id="<?php echo $value->id?>" data-value="1" type="checkbox" id="<?php echo $value->id?>" checked>
                                                    <label class="task-done" for="<?php echo $value->id?>"><span><?php echo $value->to_dodata; ?></span></label>
                                                </div>
                                                <?php } ?>
                                            </li>

                                            <?php endforeach; ?>
                                        </ul>
                                </div>
                                <div class="new-todo">
                                        <form method="post" action="add_todo" enctype="multipart/form-data" id="add_todo" >
                                         <div class="input-group">
                                                <input type="text" name="todo_data" class="form-control" style="border: 1px solid #fff !IMPORTANT;" placeholder="Add a new task...">
                                                <span class="input-group-btn">
                                                <input type="hidden" name="userid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
                                                <button type="submit" class="btn btn-info todo-submit"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                         </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Notice Board</h4>
                                <h6 class="card-subtitle">All important announcements and updates</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive slimScrollDiv" style="height:600px;overflow-y:scroll">
                                    <table class="table table-hover table-bordered earning-box ">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>File</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($notice AS $value): ?>
                                            <tr class="scrollbar" style="vertical-align:top">
                                                <td><?php echo $value->title ?></td>
                                                <td><mark><a href="<?php echo base_url(); ?>assets/images/notice/<?php echo $value->file_url ?>" target="_blank"><?php echo $value->file_url ?></a></mark>
                                                </td>
                                                <td style="width:100px"><?php echo $value->date ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    Upcoming Dates
                                </h4>
                                <h6 class="card-subtitle">Important dates and holidays</h6>                      
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="height:600px;overflow-y:scroll">
                                    <table class="table table-hover table-bordered earning-box">
                                       <thead>
                                            <tr>
                                                <th>Holiday Name</th>
                                                <th>Date</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                            <?php foreach($holiday as $value): ?>
                                                <tr>
                                                    <td><?php echo $value->holiday_name ?></td>
                                                    <td><?php echo $value->from_date; ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                       </tbody>
                                    </table>
                                </div>
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