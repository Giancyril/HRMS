<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<style>
    /* Custom CSS to style the floating success message */
.success-message {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1060; /* Higher than typical modal z-indices */
    width: 200px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    /* New styles to match the image */
    background-color: #4CAF50; /* Green background */
    border: none;
    padding: 15px;
    text-align: center;
    color: white; /* White text */
}
.success-message .alert {
    background-color: #4CAF50;
    border: none;
    padding: 0;
    margin-bottom: 0;
    color: white; /* Ensure alert text is also white */
}
</style>

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
                                                <td><?php echo html_escape(substr($job['description'], 0, 70)) . '...'; ?></td>
                                                <td><?php echo html_escape(date('F j, Y', strtotime($job['posted_at']))); ?></td>
                                                <td class="jsgrid-align-center">
                                                    <a href="<?php echo site_url('recruitment/job_details/' . $job['job_id']); ?>"
                                                       class="btn btn-sm btn-primary">View</a>
                                                    <button type="button" class="btn btn-sm btn-info apply-job-btn"
                                                            data-toggle="modal"
                                                            data-target="#applyModal"
                                                            data-job-id="<?php echo html_escape($job['job_id']); ?>"
                                                            data-job-title="<?php echo html_escape($job['job_title']); ?>">
                                                        <i class="fa fa-paper-plane"></i> Apply
                                                    </button>
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
                <div class="modal-header">
                    <h5 id="addJobModalLabel" class="modal-title">Add New Job Posting</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert modal-message text-center" style="display:none;"></div>
                    <form id="addJobForm" data-modal-id="#addJobModal"
                            action="<?php echo site_url('recruitment/save_job'); ?>"
                            method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Job Title</label>
                                <select name="job_title" class="form-control" required>
                                    <option value="">Select a Job Title</option>
                                    <?php foreach ($designations as $des): ?>
                                        <option value="<?php echo html_escape($des->des_name); ?>">
                                            <?php echo html_escape($des->des_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Job Description</label>
                                <textarea name="description" class="form-control" rows="5"
                                                placeholder="Detailed description..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Requirements</label>
                                <textarea name="requirements" class="form-control" rows="5"
                                                placeholder="Skills, qualifications..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
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
                <div class="modal-header">
                    <h5 id="applyModalLabel" class="modal-title">Job Application</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert modal-message text-center" style="display:none;"></div>
                    <form id="applyForm" action="<?php echo site_url('recruitment/apply_ajax/'); ?>" method="post">
                        <input type="hidden" name="job_id" id="apply-job-id">
                        <div class="form-body">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Initialize DataTable
        $('#job_postings').DataTable({
            "aaSorting": [[2, 'desc']],
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print']
        });

        // Event listener for when the 'Apply' button is clicked
        $('.apply-job-btn').on('click', function() {
            var jobId = $(this).data('job-id');
            var jobTitle = $(this).data('job-title');

            // Set the value of the hidden input field in the modal form
            $('#apply-job-id').val(jobId);
            
            // Update the modal title to show the specific job
            $('#applyModalLabel').text('Apply for: ' + jobTitle);
        });

        // AJAX form submission for the application form
$('#applyForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize();
    var messageBox = form.closest('.modal-content').find('.modal-message');

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        dataType: "json",
        success: function(response) {
            if (response.status === 'success') {
                // The following two lines were removed to prevent the success message and modal from being handled
                // messageBox.removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                // setTimeout(function() {
                //     $('#applyModal').modal('hide');
                //     messageBox.hide();
                // }, 2000); 
                
                // You can add other actions here if needed
                // For example, if you want the form to clear after submission, you can add:
                // form[0].reset();
                
                // The form will remain open, so you might want to show a message or just keep it as is.
                
            } else {
                messageBox.removeClass('alert-success').addClass('alert-danger').text(response.message).show();
            }
        },
        error: function() {
            messageBox.removeClass('alert-success').addClass('alert-danger').text('An error occurred. Please try again.').show();
        }
    });
});

        // This section for job editing is from your original code and can be left as is.
        $(".edit-job-btn").click(function (e) {
            e.preventDefault();
            var jobId = $(this).attr('data-job-id');
            $('#jobEditForm').find('input, textarea, select').val('');
            $('#editJobModal').modal('show');
            $.ajax({
                url: 'JobByID?id=' + jobId,
                method: 'GET',
                dataType: 'json',
            }).done(function (response) {
                console.log(response);
                if (response && response.job) {
                    $('#jobEditForm').find('[name="job_id"]').val(response.job.job_id);
                    $('#jobEditForm').find('[name="job_title"]').val(response.job.title);
                    $('#jobEditForm').find('[name="description"]').val(response.job.description);
                    $('#jobEditForm').find('[name="requirements"]').val(response.job.requirements);
                } else {
                    console.error("No job data returned from the server.");
                }
            }).fail(function() {
                console.error("Error fetching job data.");
            });
        });

    });
</script>

<?php $this->load->view('backend/footer'); ?>