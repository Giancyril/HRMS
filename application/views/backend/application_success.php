<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Application Submitted</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo site_url('recruitment'); ?>">Recruitment</a></li>
                        <li class="breadcrumb-item active">Success</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-success">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Application Submitted Successfully! 🎉</h4>
                            </div>
                            <div class="card-body">
                                <p>Thank you for your interest. Your application has been received and will be reviewed shortly.</p>
                                <a href="<?php echo site_url('recruitment'); ?>" class="btn btn-primary">Return to Job Listings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->load->view('backend/footer'); ?>