<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Application Details</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('recruitment/applications'); ?>">Applications</a></li>
                <li class="breadcrumb-item active">Details</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">
                            Application Details for: <?php echo html_escape($application['first_name'] . ' ' . $application['last_name']); ?>
                            <span class="badge badge-info pull-right">
                                Application ID: <?php echo html_escape($application['id']); ?>
                            </span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                            $status = html_escape($application['status']);
                            $badge_class = 'badge-secondary'; // Default
                            if ($status == 'Pending') { $badge_class = 'badge-warning'; }
                            else if ($status == 'Reviewed') { $badge_class = 'badge-info'; }
                            else if ($status == 'Interview') { $badge_class = 'badge-primary'; }
                            else if ($status == 'Hired') { $badge_class = 'badge-success'; }
                            else if ($status == 'Rejected') { $badge_class = 'badge-danger'; }

                            // Determine Applicant Type
                            $is_internal = !empty($application['applicant_em_code']);
                            $applicant_type = $is_internal ? 'Internal Employee' : 'External Applicant';
                        ?>

                        <div class="row">
                            <div class="col-md-6 border-right">
                                <h5><i class="fa fa-user"></i> Applicant Information</h5>
                                <hr>
                                <p><strong>Name:</strong> <?php echo html_escape($application['first_name'] . ' ' . $application['last_name']); ?></p>
                                <p><strong>Email:</strong> <?php echo html_escape($application['email']); ?></p>
                                <p><strong>Phone:</strong> <?php echo html_escape($application['phone']); ?></p>
                                <p>
                                    <strong>Applicant Type:</strong> 
                                    <span class="badge <?php echo $is_internal ? 'badge-success' : 'badge-info'; ?>">
                                        <?php echo $applicant_type; ?>
                                    </span>
                                </p>
                                
                                <?php if ($is_internal): ?>
                                    <p><strong>Employee PIN/Code:</strong> <?php echo html_escape($application['applicant_em_code']); ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <h5><i class="fa fa-briefcase"></i> Job & Status Details</h5>
                                <hr>
                                <p><strong>Position Applied For:</strong> <?php echo html_escape($application['job_title']); ?></p>
                                <p><strong>Job Posting ID:</strong> <?php echo html_escape($application['job_id']); ?></p>
                                <p><strong>Date Applied:</strong> <?php echo html_escape(date('F j, Y h:i A', strtotime($application['applied_at']))); ?></p>
                                <p>
                                    <strong>Current Status:</strong> 
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="clearfix m-t-20"></div>

                        <div class="row m-t-20">
                            <div class="col-md-6">
                                <h5><i class="fa fa-cogs"></i> Application Actions</h5>
                                <hr>
                                <button type="button" class="btn btn-info"><i class="fa fa-download"></i> Download Resume</button>
                                
                                <div class="btn-group m-l-10">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Update Status
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Mark as Reviewed</a>
                                        <a class="dropdown-item" href="#">Schedule Interview</a>
                                        <a class="dropdown-item" href="#">Extend Offer</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-success" href="#">Mark as Hired</a>
                                        <a class="dropdown-item text-danger" href="#">Mark as Rejected</a>
                                    </div>
                                </div>
                                
                                <a href="<?php echo base_url('recruitment/delete_application/' . $application['id']); ?>" 
                                    class="btn btn-danger m-l-10 delete-application" 
                                    title="Delete Application">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </div>

                            <div class="col-md-6 border-left">
                                <h5><i class="fa fa-paperclip"></i> Notes & Attachments</h5>
                                <hr>
                                <p class="text-muted">
                                    * File upload/notes section can be added here. (e.g., Cyril Naig's Resume.pdf)
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('backend/footer'); ?>