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
                            <h4 class="m-b-0 text-white">Application Details for <?php echo html_escape($application['first_name'] . ' ' . $application['last_name']); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Applicant ID:</strong> <?php echo html_escape($application['id']); ?></p>
                                    <p><strong>Applicant Name:</strong> <?php echo html_escape($application['first_name'] . ' ' . $application['last_name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo html_escape($application['email']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo html_escape($application['phone']); ?></p>
                                    <p><strong>Applied At:</strong> <?php echo html_escape(date('F j, Y', strtotime($application['applied_at']))); ?></p>
                                    <p><strong>Job ID:</strong> <?php echo html_escape($application['job_id']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('backend/footer'); ?>