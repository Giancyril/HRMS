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
                                    <!-- This tbody is intentionally left empty. DataTables will populate it via AJAX. -->
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

<script>
    $(document).ready(function() {
        // Initialize your DataTables
        var applicationsTable = $('#applications_list').DataTable({
            "processing": false, // This line hides the "Processing..." message
            "serverSide": false,
            "ajax": {
                "url": "<?php echo site_url('recruitment/get_applications_data'); ?>",
                "type": "POST",
                "dataSrc": "data"
            },
            "columns": [
                { "data": "applicant_name" },
                { "data": "job_title" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "applied_at" }
                <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                , {
                    "data": "action",
                    "orderable": false,
                    "searchable": true
                }
                <?php endif; ?>
            ],
            
            "dom": 'Bfrtip',
            "buttons": [
                'csv',
                'excel',
                'pdf',
                'print'
            ],
            "lengthChange": false,
        });

        // Event delegation for delete links within the table
        $('#applications_list').on('click', '.delete-application', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('href');
            
            if (confirm("Are you sure you want to delete this application?")) {
                window.location.href = deleteUrl;
            }
        });
    });
</script>