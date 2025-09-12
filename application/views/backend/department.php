<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Department</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Department</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addDepartmentModal">
                    <i class="fa fa-plus"></i> Add Department
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Department List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($department as $value) : ?>
                                        <tr>
                                            <td><?php echo $value->dep_name; ?></td>
                                            <td class="jsgrid-align-center">
                                                <button type="button" title="Edit" class="btn btn-sm btn-primary waves-effect waves-light edit-department" data-id="<?php echo $value->id; ?>"><i class="fa fa-pencil-square-o"></i></button>
                                                <a onclick="return confirm('Are you sure to delete this data?')" href="<?php echo base_url(); ?>organization/Delete_dep/<?php echo $value->id; ?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">Add New Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('organization/Save_dep'); ?>" id="addDepartmentForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Department Name</label>
                        <input type="text" name="department" id="departmentName" class="form-control" placeholder="Enter department name" minlength="3" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url(); ?>organization/Update_dep" id="editDepartmentForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Department Name</label>
                        <input type="text" name="department" id="departmentNameModal" class="form-control" placeholder="" required>
                        <input type="hidden" name="id" id="departmentIdModal">
                    </div>
                    <div id="department-form-messages" class="mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('backend/footer'); ?>

            <script>

                $(document).ready(function() {
                    $('#departmentTable').DataTable({
                      "aaSorting": [[0, 'asc']], // Sort by the first column by default
                      dom: 'Bfrtip',
                      buttons: [
                     'csv', 'excel', 'pdf', 'print'
                  ]
               });
            });


            $(document).ready(function() {
                // Logic to open and populate the modal for Department
                $('.edit-department').on('click', function() {
                    var departmentId = $(this).data('id');
                    $('#department-form-messages').empty(); // Clear any previous messages

                    $.ajax({
                        url: '<?php echo base_url("organization/getDepartmentById/"); ?>' + departmentId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response && response.id && response.dep_name) {
                                $('#departmentIdModal').val(response.id);
                                $('#departmentNameModal').val(response.dep_name);
                                $('#editDepartmentModal').modal('show');
                            } else {
                                console.error("Error fetching department data or invalid response.", response);
                                // No message shown to user in the modal
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error fetching department: " + status + " - " + error);
                            // No message shown to user in the modal
                        }
                    });
                });

                // Handle form submission for the Department modal
                $('#editDepartmentForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    var formData = $(this).serialize();
                    $('#department-form-messages').empty(); // Ensure no messages are displayed

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log("Update response from server (Department):", response); // Log response for debugging

                            setTimeout(function() {
                                $('#editDepartmentModal').modal('hide');
                                location.reload(); // Reload the page to show updated list and trigger main flashdata
                            }, 1000); // Adjust this delay (milliseconds) as desired before closing and reloading
                        },
                        error: function(xhr, status, error) {
                            console.error("Form submission error (Department): " + status + " - " + error);
                            setTimeout(function() {
                                $('#editDepartmentModal').modal('hide');
                                location.reload();
                            }, 1000); // Adjust this delay (milliseconds) for error case as desired
                        }
                    });
                });
            });
            </script>