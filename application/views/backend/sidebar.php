<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <?php
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
        ?>
        
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li> <a href="<?php echo base_url(); ?>" ><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard </span></a></li>
                <?php if($this->session->userdata('user_type') == 'EMPLOYEE'){ ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Employee </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfo->em_id); ?>" aria-expanded="false"><span class="hide-menu">View Profile </span></a> </li>
                </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-off"></i><span class="hide-menu">Leave </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>
                        <li><a href="<?php echo base_url(); ?>leave/EmApplication"> Leave Application </a></li>
                        <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-briefcase-check"></i><span class="hide-menu">Projects </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Projects </a></li>
                        <li><a href="<?php echo base_url(); ?>Projects/All_Tasks"> Task List </a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-credit-card"></i><span class="hide-menu">Payroll </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>Payroll/Payslip_Report"> Payslip Report</a></li>
                    </ul>
                </li>


<?php } else if($this->session->userdata('user_type') == 'HR-MANAGER'){ ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-domain"></i><span class="hide-menu">Organization </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url();?>organization/Department">Department </a></li>
                        <li><a href="<?php echo base_url();?>organization/Designation">Designation</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employee </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
                        <li><a href="<?php echo base_url(); ?>employee/Disciplinary">Disciplinary </a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu">Attendance </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>attendance/Attendance">Attendance List </a></li>
                        <li><a href="<?php echo base_url(); ?>attendance/Save_Attendance">Add Attendance </a></li>
                        <li><a href="<?php echo base_url(); ?>attendance/Attendance_Report">Attendance Report </a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-off"></i><span class="hide-menu">Leave </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>
                        <li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
                        <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                        <li><a href="<?php echo base_url(); ?>leave/Leave_report"> Leave Report </a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-briefcase-check"></i><span class="hide-menu">Project </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Projects </a></li>
                        <li><a href="<?php echo base_url(); ?>Projects/All_Tasks"> Task List </a></li>
                        <li><a href="<?php echo base_url(); ?>Projects/Field_visit"> Field Visit</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-credit-card"></i><span class="hide-menu">Payroll </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Payroll List </a></li>
                        <li><a href="<?php echo base_url(); ?>Payroll/Generate_salary"> Generate Payslip</a></li>
                        <li><a href="<?php echo base_url(); ?>Payroll/Payslip_Report"> Payslip Report</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bank"></i><span class="hide-menu">Loan </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>Loan/View"> Grand Loan </a></li>
                                <li><a href="<?php echo base_url(); ?>Loan/installment"> Loan Installment</a></li>
                            </ul>
                        </li>
                <li> <a href="<?php echo base_url()?>notice/All_notice" ><i class="mdi mdi-clipboard"></i><span class="hide-menu">Notice <span class="hide-menu"></a></li>
                <li> <a href="<?php echo base_url(); ?>dashboard/analytics_view" ><i class="mdi mdi-poll"></i><span class="hide-menu">Analytics <span class="hide-menu"></a></li>
                <li> <a href="<?php echo base_url(); ?>settings/Settings" ><i class="mdi mdi-settings"></i><span class="hide-menu">Settings <span class="hide-menu"></a></li>


<?php } else { ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-domain"></i><span class="hide-menu">Organization </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url();?>organization/Department">Department </a></li>
                        <li><a href="<?php echo base_url();?>organization/Designation">Designation</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employee </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
                        <li><a href="<?php echo base_url(); ?>employee/Disciplinary">Disciplinary </a></li>
                        <li><a href="<?php echo base_url(); ?>employee/Inactive_Employee">Inactive User </a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu">Attendance </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>attendance/Attendance">Attendance List </a></li>
                        <li><a href="<?php echo base_url(); ?>attendance/Attendance_Report">Attendance Report </a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-off"></i><span class="hide-menu">Leave </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>
                        <li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
                        <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                        <li><a href="<?php echo base_url(); ?>leave/Earnedleave"> Earned Leave </a></li>
                        <li><a href="<?php echo base_url(); ?>leave/Leave_report"> Leave Report </a></li>
                    </ul>
                </li>
               
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-briefcase-check"></i><span class="hide-menu">Project </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Projects </a></li>
                        <li><a href="<?php echo base_url(); ?>Projects/All_Tasks"> Task List </a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-credit-card"></i><span class="hide-menu">Payroll </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Payroll List </a></li>
                        <li><a href="<?php echo base_url(); ?>Payroll/Salary_type"> Salary Type</a></li>
                        
                        <li><a href="<?php echo base_url(); ?>Payroll/Payslip_Report"> Payslip Report</a></li>
                    </ul>
                </li>
                
<li>
    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
        <i class="mdi mdi-account-card-details"></i><span class="hide-menu">Recruitment</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="<?php echo base_url(); ?>Recruitment">Job Postings</a></li>
        <li><a href="<?php echo base_url(); ?>Recruitment/Applications">View Applications</a></li>
    </ul>
</li>

                 <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cube"></i><span class="hide-menu">Assets </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>Logistice/All_Assets"> Asset List </a></li>
                                <li><a href="<?php echo base_url(); ?>Logistice/Assets_Category"> Assets Category </a></li>
                                <!--<li><a href="<?php #echo base_url(); ?>Logistice/View"> Logistic Support List </a></li>-->
                                <li><a href="<?php echo base_url(); ?>Logistice/logistic_support"> Logistic Support </a></li>
                            </ul>
                        </li>
                        
                <li> <a href="<?php echo base_url(); ?>dashboard/analytics_view" ><i class="mdi mdi-poll"></i><span class="hide-menu">Analytics <span class="hide-menu"></a></li>
                <li> <a href="<?php echo base_url(); ?>settings/Settings" ><i class="mdi mdi-settings"></i><span class="hide-menu">Settings <span class="hide-menu"></a></li>
                
                <?php } ?>
            </ul>
        </nav>
        </div>
    </aside>