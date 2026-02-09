<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Job Postings</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Recruitment</li>
            </ol>
        </div>
    </div>

    <div class="success-message" style="display: none;">
        <div class="alert alert-success text-center">
            Successfully Added
        </div>
    </div>

    <div class="flash-message">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success text-center">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger text-center">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addJobModal">
                        <i class="fa fa-plus"></i> Add Job
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Job Postings List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="job_postings" class="display nowrap table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Posted Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($jobs)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No jobs are currently available.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($jobs as $job): ?>
                                            <tr>
                                                <td><?php echo html_escape($job['job_title']); ?></td>
                                                <td><?php echo html_escape(substr($job['description'], 0, 60)) . '...'; ?></td>
                                                <td><?php echo html_escape(date('F j, Y', strtotime($job['posted_at']))); ?></td>
                                                <td class="jsgrid-align-center">
                                                    <a href="<?php echo site_url('recruitment/job_details/' . $job['job_id']); ?>" class="btn btn-sm btn-primary">View</a>
                                                    <button type="button" class="btn btn-sm btn-info apply-job-btn" data-toggle="modal" data-target="#applyModal" data-job-id="<?php echo html_escape($job['job_id']); ?>" data-job-title="<?php echo html_escape($job['job_title']); ?>">
                                                        Apply
                                                    </button>
                                                    <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                                        <button type="button" class="btn btn-sm btn-info edit-job-btn" data-job-id="<?php echo html_escape($job['job_id']); ?>" title="Edit"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-job-btn" data-job-id="<?php echo html_escape($job['job_id']); ?>" title="Delete"><i class="fa fa-trash"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="addJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-white border-bottom">
                    <h5 class="modal-title text-dark font-weight-medium" id="addJobModalLabel">Add New Job Posting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="position-relative">
                    <form id="addJobForm" action="<?php echo site_url('recruitment/save_job'); ?>" method="post">
                        <div class="modal-body">
                            <div id="job-form-message" class="alert alert-info text-center" style="display:none;"></div>
                            <div class="form-group">
                                <label class="control-label font-weight-medium">Job Title</label>
                                <select name="job_title" class="form-control form-control-md" required>
                                    <option value="">Select a Job Title</option>
                                    <?php foreach ($designations as $des): ?>
                                        <option value="<?php echo html_escape($des->des_name); ?>">
                                            <?php echo html_escape($des->des_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label font-weight-medium">Job Description</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Detailed description..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label font-weight-medium">Requirements</label>
                                <textarea name="requirements" class="form-control" rows="5" placeholder="Skills, qualifications..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-white border-bottom">
                    <h5 class="modal-title text-dark font-weight-medium" id="applyModalLabel">Job Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="position-relative">
                    <form id="applyForm" action="<?php echo site_url('recruitment/apply_ajax/'); ?>" method="post">
                        <input type="hidden" name="job_id" id="apply-job-id">
                        <div class="modal-body">
                            <div id="apply-form-message" class="alert alert-info text-center" style="display:none;"></div>
                            <div class="form-group">
                                <label class="control-label font-weight-medium">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label font-weight-medium">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label font-weight-medium">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label font-weight-medium">Phone</label>
                                <input type="text" name="phone" class="form-control form-control-lg" required>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                                <select name="job_title" class="form-control form-control-md" required>
                                    <option value="">Select a Job Title</option>
                                    <?php foreach ($designations as $des): ?>
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
</div>

<!-- Success Toast Notifications (Page-level, fixed positioning) -->
<div id="job-success-toast" class="position-fixed" style="top: 20px; right: 20px; z-index: 2050; display: none;">
    <div class="alert alert-success mb-0" style="border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px;">
        <i class="fas fa-check-circle mr-2"></i> Successfully Added
    </div>
</div>

<div id="edit-success-toast" class="position-fixed" style="top: 20px; right: 20px; z-index: 2050; display: none;">
    <div class="alert alert-success mb-0" style="border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px;">
        <i class="fas fa-check-circle mr-2"></i> Successfully Updated
    </div>
</div>

<div id="apply-success-toast" class="position-fixed" style="top: 20px; right: 20px; z-index: 2050; display: none;">
    <div class="alert alert-success mb-0" style="border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px;">
        <i class="fas fa-check-circle mr-2"></i> Application Submitted
    </div>
</div>

<script>
    $(document).ready(function () {
        let jobsTable = $('#job_postings').DataTable({
            "aaSorting": [[2, 'desc']], // Sort by posted date descending (latest first)
            "order": [[2, 'desc']],
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print'],
            "columnDefs": [{
                "targets": [3],
                "orderable": false
            }]
        });

        // Event listener for when the 'Apply' button is clicked
        $('.apply-job-btn').on('click', function() {
            var jobId = $(this).data('job-id');
            var jobTitle = $(this).data('job-title');
            $('#apply-job-id').val(jobId);
            $('#applyModalLabel').text('Apply for: ' + jobTitle);
        });

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

        // Handle Delete Job button
        $(document).on('click', '.delete-job-btn', function(e) {
            e.preventDefault();
            var jobId = $(this).data('job-id');
            if (confirm('Are you sure you want to delete this job posting?')) {
                $.ajax({
                    url: '<?php echo site_url('recruitment/delete_job'); ?>',
                    method: 'POST',
                    data: { job_id: jobId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Job deleted successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the job.');
                    }
                });
            }
        });

        // AJAX form submission for adding a new job
        $('#addJobForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();
            var successToast = $('#job-success-toast');
            var messageBox = $('#job-form-message');

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        successToast.show();
                        form[0].reset();
                        
                        setTimeout(function() {
                            successToast.hide();
                            $('#addJobModal').modal('hide');
                            // Reload the page to show the new job at the top
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

        // AJAX form submission for the application form
        $('#applyForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();
            var successToast = $('#apply-success-toast');
            var messageBox = $('#apply-form-message');

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        successToast.show();
                        form[0].reset();
                        
                        setTimeout(function() {
                            successToast.hide();
                            $('#applyModal').modal('hide');
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

<?php $this->load->view('backend/footer'); ?>