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
                                <button type="button" class="btn btn-info download-resume-btn" data-app-id="<?php echo html_escape($application['id']); ?>"><i class="fa fa-download"></i> Download Resume</button>
                                
                                <div class="btn-group m-l-10">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Update Status
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item update-status-btn" href="#" data-status="Reviewed" data-app-id="<?php echo html_escape($application['id']); ?>">Mark as Reviewed</a>
                                        <a class="dropdown-item update-status-btn" href="#" data-status="Interview" data-app-id="<?php echo html_escape($application['id']); ?>">Schedule Interview</a>
                                        <a class="dropdown-item update-status-btn" href="#" data-status="Offer" data-app-id="<?php echo html_escape($application['id']); ?>">Extend Offer</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-info update-status-btn" href="#" data-status="Hired" data-app-id="<?php echo html_escape($application['id']); ?>">Mark as Hired</a>
                                        <a class="dropdown-item text-danger update-status-btn" href="#" data-status="Rejected" data-app-id="<?php echo html_escape($application['id']); ?>">Mark as Rejected</a>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-danger m-l-10 delete-application-btn" data-app-id="<?php echo html_escape($application['id']); ?>" title="Delete Application">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
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

<script>
$(document).ready(function() {
    // Download Resume
    $('.download-resume-btn').on('click', function(e) {
        e.preventDefault();
        var appId = $(this).data('app-id');
        if (appId) {
            window.location.href = '<?php echo base_url('recruitment/download_resume/'); ?>' + appId;
        } else {
            alert('Invalid application ID.');
        }
    });

    // Update Status
    $('.update-status-btn').on('click', function(e) {
        e.preventDefault();
        var appId = $(this).data('app-id');
        var newStatus = $(this).data('status');
        var statusText = $(this).text();

        if (!appId || !newStatus) {
            alert('Missing required data. Please refresh the page and try again.');
            return;
        }

        if (confirm('Are you sure you want to ' + statusText.toLowerCase() + '?')) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('recruitment/update_application_status'); ?>',
                data: {
                    app_id: appId,
                    status: newStatus
                },
                dataType: 'json',
                timeout: 10000,
                success: function(response) {
                    console.log('Status update response:', response);
                    if (response && response.status === 'success') {
                        alert('Status updated successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + (response && response.message ? response.message : 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error, xhr);
                    var errorMsg = 'An error occurred while updating the status.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            errorMsg = resp.message || errorMsg;
                        } catch(e) {
                            errorMsg = xhr.responseText;
                        }
                    }
                    alert(errorMsg);
                }
            });
        }
    });

    // Delete Application
    $('.delete-application-btn').on('click', function(e) {
        e.preventDefault();
        var appId = $(this).data('app-id');

        if (!appId) {
            alert('Invalid application ID.');
            return;
        }

        if (confirm('Are you sure you want to delete this application? This action cannot be undone.')) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('recruitment/delete_application_ajax'); ?>',
                data: { app_id: appId },
                dataType: 'json',
                timeout: 10000,
                success: function(response) {
                    console.log('Delete response:', response);
                    if (response && response.status === 'success') {
                        alert('Application deleted successfully!');
                        window.location.href = '<?php echo base_url('recruitment/applications'); ?>';
                    } else {
                        alert('Error: ' + (response && response.message ? response.message : 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error, xhr);
                    var errorMsg = 'An error occurred while deleting the application.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            errorMsg = resp.message || errorMsg;
                        } catch(e) {
                            errorMsg = xhr.responseText;
                        }
                    }
                    alert(errorMsg);
                }
            });
        }
    });
});
</script>