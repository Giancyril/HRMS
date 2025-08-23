<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
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
                                                <th>Action</th>
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
                                                    <td><?php echo html_escape($application['job_title']); ?></td>
                                                    <td><?php echo html_escape($application['email']); ?></td>
                                                    <td><?php echo html_escape($application['phone']); ?></td>
                                                    <td><?php echo html_escape(date('F j, Y', strtotime($application['applied_at']))); ?></td>
                                                    <td class="jsgrid-align-center">
                                                        <a href="<?php echo base_url('uploads/resumes/' . basename($application['resume_path'])); ?>" title="View Resume" class="btn btn-sm btn-primary waves-effect waves-light" target="_blank"><i class="fa fa-file-text-o"></i> View Resume</a>
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
<?php $this->load->view('backend/footer'); ?>
