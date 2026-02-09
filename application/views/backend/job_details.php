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
                            <button type="button" class="btn btn-sm btn-info edit-job-btn m-r-5" data-job-id="<?php echo html_escape($job_details->job_id); ?>">
                                <i class="fa fa-pencil"></i> Edit Job
                            </button>
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

<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white border-bottom">
                <h5 class="modal-title text-dark font-weight-medium" id="editJobModalLabel">Edit Job Posting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="position-relative">
                <form id="editJobForm" action="<?php echo site_url('recruitment/update_job'); ?>" method="post">
                    <div class="modal-body">
                        <div id="edit-form-message" class="alert alert-info text-center" style="display:none;"></div>
                        <input type="hidden" name="job_id">
                        <div class="form-group">
                            <label class="control-label font-weight-medium">Job Title</label>
                            <select name="job_title" class="form-control form-control-lg" required>
                                <option value="">Select a Job Title</option>
                                <?php 
                                $this->load->model('recruitment_model');
                                $designations = $this->recruitment_model->get_designations();
                                foreach ($designations as $des): 
                                ?>
                                    <option value="<?php echo html_escape($des->des_name); ?>">
                                        <?php echo html_escape($des->des_name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label font-weight-medium">Job Description</label>
                            <textarea name="description" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label font-weight-medium">Requirements</label>
                            <textarea name="requirements" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast Notification -->
<div id="edit-success-toast" class="position-fixed" style="top: 20px; right: 20px; z-index: 2050; display: none;">
    <div class="alert alert-success mb-0" style="border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px;">
        <i class="fas fa-check-circle mr-2"></i> Successfully Updated
    </div>
</div>

<?php $this->load->view('backend/footer'); ?>

<script>
    $(document).ready(function() {
        // Handle Edit Job button
        $(document).on('click', '.edit-job-btn', function(e) {
            e.preventDefault();
            var jobId = $(this).data('job-id');
            $('#editJobForm').find('input[name="job_id"]').val(jobId);
            
            $.ajax({
                url: '<?php echo site_url('recruitment/JobByID'); ?>?id=' + jobId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.job) {
                        $('#editJobForm').find('[name="job_title"]').val(response.job.job_title || response.job.title);
                        $('#editJobForm').find('[name="description"]').val(response.job.description);
                        $('#editJobForm').find('[name="requirements"]').val(response.job.requirements);
                        $('#editJobModal').modal('show');
                    } else {
                        alert('Error loading job data.');
                    }
                },
                error: function() {
                    alert('Error fetching job data.');
                }
            });
        });

        // AJAX form submission for editing a job
        $('#editJobForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();
            var successToast = $('#edit-success-toast');
            var messageBox = $('#edit-form-message');

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        successToast.show();
                        
                        setTimeout(function() {
                            successToast.hide();
                            $('#editJobModal').modal('hide');
                            location.reload();
                        }, 2000);
                    } else {
                        messageBox.removeClass('alert-success').addClass('alert-danger').text('Error: ' + response.message).show();
                    }
                },
                error: function() {
                    messageBox.removeClass('alert-success').addClass('alert-danger').text('An error occurred. Please try again.').show();
                }
            });
        });
    });
</script>