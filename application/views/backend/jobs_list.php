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
                                                <td><?php echo html_escape($job['title']); ?></td>
                                                <td><?php echo html_escape(substr($job['description'], 0, 100)) . '...'; ?></td>
                                                <td><?php echo html_escape(date('F j, Y', strtotime($job['posted_at']))); ?></td>
                                                <td class="jsgrid-align-center">
                                                    <a href="<?php echo site_url('recruitment/job_details/' . $job['job_id']); ?>"
                                                        class="btn btn-sm btn-primary">View</a>
                                                    <button type="button" class="btn btn-sm btn-info apply-job-btn"
                                                            data-toggle="modal"
                                                            data-target="#applyModal"
                                                            data-job-id="<?php echo html_escape($job['job_id']); ?>"
                                                            data-job-title="<?php echo html_escape($job['title']); ?>">
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
                    <form id="applyForm" action="<?php echo site_url('recruitment/apply_ajax/'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="job_id" id="apply-job-id">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" id="apply-job-title" class="form-control" readonly>
                            </div>
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
                            <div class="form-group">
                                <label>Resume</label>
                                <input type="file" name="resume" class="form-control" required>
                                <small class="form-text text-muted">Please upload your resume in PDF or DOCX format.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('backend/footer'); ?>

<script>
    $(function () {
        // Initialize DataTable
        $('#job_postings').DataTable({
            "aaSorting": [[2, 'desc']],
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print']
        });

        // ------------------
        // AJAX for Add Job Form
        // ------------------
        $('#addJobForm').on('submit', function (e) {
            e.preventDefault();
            const $form = $(this);
            const $modal = $($form.data('modal-id'));
            const $modalMsg = $modal.find('.modal-message');

            // Hide any message inside the modal
            $modalMsg.hide();

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json',
            }).done(function (response) {
                if (response.status === 'success') {
                    // Show the top-right success message
                    const $topMsg = $('.success-message');
                    const $topMsgAlert = $topMsg.find('.alert-success');

                    // Apply styles directly using .css()
                    $topMsg.css({
                        'background-color': '#4CAF50',
                        'color': 'white',
                        'border': 'none',
                        'borderRadius': 'none',
                        'z-index': '1060',
                        'text-align': 'center'
                    });
                    
                    // The inner alert div should also have transparent background and no border
                    $topMsgAlert.css({
                        'background-color': 'transparent',
                        'border': 'none',
                        'borderRadius': 'none',
                        'color': 'white'
                    });

                    // Set the message text
                    $topMsgAlert.text('Successfully Added');
                    $topMsg.fadeIn();

                    // Hide the message and modal after a delay
                    setTimeout(function () {
                        $topMsg.fadeOut();
                        $modal.modal('hide');
                    }, 2000);

                    // Clear the form and refresh the table
                    $form[0].reset();
                    refreshJobsTable();

                } else {
                    $modalMsg.removeClass('alert-info').addClass('alert-danger').html(response.message).fadeIn().delay(3000).fadeOut();
                }
            }).fail(function () {
                $modalMsg.removeClass('alert-info alert-success').addClass('alert-danger').html('Something went wrong. Please try again.').fadeIn().delay(3000).fadeOut();
            });
        });

        // ------------------
        // Function to dynamically refresh the job postings table
        // ------------------
        function refreshJobsTable() {
            $.ajax({
                url: '<?php echo site_url('recruitment/get_jobs_data'); ?>',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const table = $('#job_postings').DataTable();
                    
                    // Clear existing data and redraw
                    table.clear().draw();
                    
                    // Add the new data row by row
                    $.each(data, function(index, job) {
                        table.row.add([
                            job.title,
                            job.description,
                            job.posted_date,
                            job.action_buttons
                        ]).draw(false);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Failed to fetch job data: " + error);
                }
            });
        }

        // ------------------
        // Setup for Apply Modal
        // ------------------
        $('#applyModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const jobId = button.data('job-id');
            const jobTitle = button.data('job-title');
            const modal = $(this);

            modal.find('.modal-title').text('Apply for ' + jobTitle);
            modal.find('#apply-job-id').val(jobId);
            modal.find('#apply-job-title').val(jobTitle);
            modal.find('#applyForm')[0].reset();
            modal.find('.modal-message').hide().text('');
        });

        // ------------------
        // AJAX for Apply Form
        // ------------------
        $('#applyForm').on('submit', function (e) {
            e.preventDefault();
            const $form = $(this);
            const $msg = $form.closest('.modal-content').find('.modal-message');

            // Show a temporary "loading" message
            $msg.removeClass('alert-success alert-danger').addClass('alert-info').text('Submitting your application...').fadeIn();

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: new FormData(this),
                dataType: 'json',
                processData: false,
                contentType: false,
            }).done(function (response) {
                $msg.removeClass('alert-info alert-success alert-danger');
                if (response.status === 'success') {
                    $msg.addClass('alert-success').html(response.message).fadeIn();
                    setTimeout(function () {
                        $('#applyModal').modal('hide');
                    }, 3000);
                } else {
                    $msg.addClass('alert-danger').html(response.message).fadeIn().delay(3000).fadeOut();
                }
            }).fail(function () {
                $msg.removeClass('alert-info alert-success').addClass('alert-danger').html('An error occurred. Please try again.').fadeIn().delay(3000).fadeOut();
            });
        });
    });
</script>