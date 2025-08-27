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
                <div class="card">
                    <div class="card-body">
                        
                       <div class="card mb-4">
    <div class="card-header">
        <h2 class="text-themecolor"><?php echo html_escape($job_details->job_title); ?></h2>
                            <p class="text-muted"><i class="fa fa-clock"></i> Posted: <?php echo html_escape(date('F j, Y', strtotime($job_details->posted_at))); ?></p>
    </div>
    <div class="card-body">
        <h5 class="m-0">Job Description</h5>
        <p><?php echo nl2br(html_escape($job_details->job_description)); ?></p>
        
        <hr class="my-4">
        
        <h5 class="m-0">Requirements</h5>
        <p><?php echo nl2br(html_escape($job_details->requirements)); ?></p>
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