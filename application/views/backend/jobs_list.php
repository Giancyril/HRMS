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
        <div class="message"></div>
        <div class="container-fluid">
            <div class="row m-b-10">
                <div class="col-12">
                    <?php if ($this->session->userdata('user_type') != 'EMPLOYEE') { ?>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addJobModal">
                            <i class="fa fa-plus"></i><i class="" aria-hidden="true"></i> Add Job
                        </button>
                    <?php } ?>
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
                                <table id="job_postings" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                                    <a href="<?php echo site_url('recruitment/job_details/' . $job['job_id']); ?>" title="View" class="btn btn-sm btn-primary waves-effect waves-light">View</a>
                                                    <a href="<?php echo site_url('recruitment/apply/' . $job['job_id']); ?>" title="Apply" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Apply</a>
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
                        <h5 class="modal-title" id="addJobModalLabel">Add New Job Posting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addJobForm" data-modal-id="#addJobModal" action="<?php echo site_url('recruitment/save_job'); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Job Title</label>
                                            <select name="title" class="form-control" required>
                                                <option value="">Select a Job Title</option>
                                                <?php if (isset($designations) && is_array($designations)): ?>
                                                    <?php foreach ($designations as $designation): ?>
                                                        <option value="<?php echo html_escape($designation->des_name); ?>">
                                                            <?php echo html_escape($designation->des_name); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Job Description</label>
                                            <textarea name="description" class="form-control" rows="5" placeholder="Detailed description of the role..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Requirements</label>
                                            <textarea name="requirements" class="form-control" rows="5" placeholder="Key skills, qualifications, and experience..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info"> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php $this->load->view('backend/footer'); ?>
<script>
    $('#job_postings').DataTable({
        "aaSorting": [[2, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>