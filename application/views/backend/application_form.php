<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Application Form</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo site_url('recruitment'); ?>">Recruitment</a></li>
                        <li class="breadcrumb-item active">Apply</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Apply for: <?php echo html_escape($job['title']); ?></h4>
                            </div>
                            <div class="card-body">
                                <p>Please fill out the form below to apply for this position.</p>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                                <?php echo form_open_multipart('recruitment/apply/' . $job['job_id'], ['class' => 'form-horizontal']); ?>
                                    <div class="form-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" name="first_name" class="form-control" value="<?php echo set_value('first_name'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" name="last_name" class="form-control" value="<?php echo set_value('last_name'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Phone</label>
                                                    <input type="tel" name="phone" class="form-control" value="<?php echo set_value('phone'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Upload Resume</label>
                                                    <input type="file" name="resume" class="form-control-file">
                                                    <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX. Max size: 2MB.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit Application</button>
                                        <a href="<?php echo site_url('recruitment'); ?>" class="btn btn-inverse">Cancel</a>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->load->view('backend/footer'); ?>