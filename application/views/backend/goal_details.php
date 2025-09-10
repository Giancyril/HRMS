<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Goal Details</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo site_url('goals'); ?>">Goals</a></li>
                <li class="breadcrumb-item active"><?php echo html_escape($goal_details->subject); ?></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-themecolor mb-0"><?php echo html_escape($goal_details->subject); ?></h2>
                                    <p class="text-muted mb-0"><i class="fa fa-tag"></i> <?php echo html_escape($goal_details->type_name); ?></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="mb-2"> Start Date: <?php echo html_escape(date('F j, Y', strtotime($goal_details->start_date))); ?></p>
                                        <p class="mb-2"> End Date: <?php echo html_escape(date('F j, Y', strtotime($goal_details->end_date))); ?></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="mb-2"> Status: <span class="badge badge-info"><?php echo html_escape($goal_details->status); ?></span></p>
                                        <p class="mb-2"> Target Achievement: <?php echo html_escape($goal_details->target_achievement); ?></p>
                                    </div>
                                </div>
</br>
                                <h5 class="m-0 text-themecolor">Description</h5>
                                <p><?php echo nl2br(html_escape($goal_details->description)); ?></p>

                            </div>
                        </div>
                                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('backend/footer'); ?>