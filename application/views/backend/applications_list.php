<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Job Applications</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Applications</li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Job Applications List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="applications_list" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Applicant Name</th>
                                        <th>Job Title</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Applied At</th>
                                        <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                        <th>Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($applications)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No applications have been submitted yet.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($applications as $application): ?>
                                        <tr>
                                            <td><?php echo html_escape($application['first_name'] . ' ' . $application['last_name']); ?></td>
                                            <td><?php echo isset($application['job_title']) ? html_escape($application['job_title']) : 'N/A'; ?></td>
                                            <td><?php echo html_escape($application['email']); ?></td>
                                            <td><?php echo html_escape($application['phone']); ?></td>
                                            <td><?php echo html_escape(date('F j, Y', strtotime($application['applied_at']))); ?></td>
                                            <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                            <td class="jsgrid-align-center">
                                                <a href="<?php echo site_url('recruitment/view_application/' . $application['id']); ?>" class="btn btn-sm btn-info" title="View Details"> View</a>
                                                <a href="<?php echo site_url('recruitment/delete_application/' . $application['id']); ?>" class="btn btn-sm btn-danger waves-effect waves-light delete-application" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                            <?php endif; ?>
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
</div>
<?php $this->load->view('backend/footer'); ?>

<style>
    /* Basic modal styling */
    .confirm-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none; /* Hidden by default */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .confirm-modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 300px;
    }
    .confirm-modal-content h4 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
    }
    .confirm-modal-content button {
        margin: 0 10px;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 4px;
        border: none;
    }
    .confirm-modal-content .btn-yes {
        background-color: #d9534f;
        color: white;
    }
    .confirm-modal-content .btn-no {
        background-color: #f0f0f0;
        color: #333;
    }
</style>

<div class="confirm-modal-overlay">
    <div class="confirm-modal-content">
        <h4>Are you sure you want to delete this application?</h4>
        <button class="btn-yes">Yes</button>
        <button class="btn-no">No</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Ensure this ID matches the <table> ID in your HTML
        $('#applications_list').DataTable({
            "aaSorting": [[4, 'desc']], // This sorts the "Applied At" column
            dom: 'Bfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print']
        });

        // Custom modal logic
        const modalOverlay = $('.confirm-modal-overlay');
        const btnYes = modalOverlay.find('.btn-yes');
        const btnNo = modalOverlay.find('.btn-no');
        let deleteUrl = '';

        // Handle delete button clicks
        $('#applications_list').on('click', '.delete-application', function(e) {
            e.preventDefault();
            deleteUrl = $(this).attr('href');
            modalOverlay.css('display', 'flex');
        });

        // Handle 'Yes' click in the modal
        btnYes.on('click', function() {
            window.location.href = deleteUrl;
        });

        // Handle 'No' click in the modal
        btnNo.on('click', function() {
            modalOverlay.css('display', 'none');
            deleteUrl = ''; // Clear the URL
        });
    });
</script>
