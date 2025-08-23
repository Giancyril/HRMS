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
                        <li class="breadcrumb-item active"><?php echo html_escape($job['title']); ?></li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><?php echo html_escape($job['title']); ?></h4>
                            </div>
                            <div class="card-body">
                                <h2>Job Description</h2>
                                <p><?php echo nl2br(html_escape($job['description'])); ?></p>

                                <h2>Requirements</h2>
                                <p><?php echo nl2br(html_escape($job['requirements'])); ?></p>

                                <p><strong>Posted:</strong> <?php echo html_escape(date('F j, Y', strtotime($job['posted_at']))); ?></p>
                                <br>
                                <a href="<?php echo site_url('recruitment/apply/' . $job['job_id']); ?>" class="btn btn-success"><i class="fa fa-paper-plane"></i> Apply for this Job</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->load->view('backend/footer'); ?>