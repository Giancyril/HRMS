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
                                                    <td><?php echo html_escape($application['job_title']); ?></td>
                                                    <td><?php echo html_escape($application['email']); ?></td>
                                                    <td><?php echo html_escape($application['phone']); ?></td>
                                                    <td><?php echo html_escape(date('F j, Y', strtotime($application['applied_at']))); ?></td>
                                                    <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                                    <td class="jsgrid-align-center">
                                                        <a href="<?php echo site_url('recruitment/view_application/' . $application['id']); ?>" class="btn btn-sm btn-info" title="View Details"> View</a>
                                                        <a href="<?php echo site_url('recruitment/delete_application/' . $application['id']); ?>" class="btn btn-sm btn-danger waves-effect waves-light" title="Delete" onclick="return confirm('Are you sure to delete this application?');"><i class="fa fa-trash-o"></i></a>
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
<?php $this->load->view('backend/footer'); ?>