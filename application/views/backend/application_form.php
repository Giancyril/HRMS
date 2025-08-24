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
                        <div id="form-messages"></div>
                        
                        <?php echo form_open('recruitment/apply_ajax/' . $job['job_id'], ['class' => 'form-horizontal', 'id' => 'application-form']); ?>
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
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="<?php echo site_url('recruitment'); ?>" class="btn btn-danger">Cancel</a>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('backend/footer'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('application-form');
    const formMessages = document.getElementById('form-messages');
    const submitBtn = form?.querySelector('button[type="submit"]');

    if (!form) return;

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        formMessages.innerHTML = '';

        const formData = new FormData(form);
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
        }

        fetch(form.action, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin', // ensure cookies/session/CSRF cookie are sent
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            redirect: 'follow'
        })
        .then(async (response) => {
            const contentType = response.headers.get('content-type') || '';
            if (!response.ok) {
                const text = await response.text();
                throw new Error(text || 'Request failed');
            }
            if (contentType.includes('application/json')) {
                return response.json();
            }
            const text = await response.text();
            throw new Error(text || 'Unexpected response from server');
        })
        .then((data) => {
            if (data.status === 'success') {
                formMessages.innerHTML = `<div class="alert alert-success">${data.message || 'Application submitted.'}</div>`;
                form.reset();
            } else {
                const msg = data.message || 'Please check the form and try again.';
                formMessages.innerHTML = `<div class="alert alert-danger">${msg}</div>`;
                if (data.errors && typeof data.errors === 'object') {
                    Object.entries(data.errors).forEach(([field, error]) => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            const help = document.createElement('div');
                            help.className = 'text-danger small mt-1';
                            help.textContent = error;
                            input.closest('.form-group')?.appendChild(help);
                        }
                    });
                }
            }
        })
        .catch((error) => {
            console.error('Form submission error:', error);
            formMessages.innerHTML = `<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>`;
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit';
            }
        });
    });
});
</script>