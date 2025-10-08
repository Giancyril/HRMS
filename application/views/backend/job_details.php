<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Job Details</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo site_url('recruitment'); ?>">Recruitment</a></li>
                <li class="breadcrumb-item active"><?php echo html_escape($job_details->job_title); ?></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    
                    <div class="card-header">
                        <h4 class="m-t-0 m-b-0 text-white" style="float: left; line-height: 30px;">
                            <?php echo html_escape($job_details->job_title); ?>
                        </h4>

                        <div class="pull-right">
                            <a href="<?php echo site_url('recruitment/applications?job_id=' . $job_details->job_id); ?>" class="btn btn-sm btn-info m-r-5">
                                View Applications
                            </a>
                            <a href="#" class="btn btn-sm btn-info m-r-5">
                                <i class="fa fa-pencil"></i> Edit Job
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="card-body">
                        
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <p class="text-muted">
                                    <i class="fa fa-tag m-r-5"></i> Job ID: <strong><?php echo html_escape($job_details->job_id); ?></strong>
                                    <span class="m-l-20">|</span>
                                    <i class="fa fa-calendar m-r-5"></i> Posted Date: 
                                    <strong><?php echo html_escape(date('F j, Y', strtotime($job_details->posted_at))); ?></strong>
                                    <span class="m-l-20">|</span> 
                                    <i class="fa fa-check-circle m-r-5"></i> Status: 
                                    <span class="badge badge-success">Active</span> 
                                </p>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="card card-hover">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="m-b-0"><i class="fa fa-info-circle m-r-5"></i> Job Description</h5>
                                    </div>
                                    <div class="card-body">
                                        <p style="white-space: pre-wrap;"><?php echo html_escape($job_details->job_description); ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-5">
                                <div class="card card-hover">
                                    <div class="card-header bg-warning text-white">
                                        <h5 class="m-b-0"><i class="fa fa-list m-r-5"></i> Key Requirements</h5>
                                    </div>
                                    <div class="card-body">
                                        <p style="white-space: pre-wrap;"><?php echo html_escape($job_details->requirements); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('backend/footer'); ?>

<script>
    // This script ensures the apply button works with the modal
    $('.apply-job-btn').on('click', function() {
        var jobId = $(this).data('job-id');
        var jobTitle = $(this).data('job-title');
        $('#apply-job-id').val(jobId);
        $('#applyModalLabel').text('Apply for: ' + jobTitle);
    });
</script>