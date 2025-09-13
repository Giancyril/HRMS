<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
    <div class="message"></div> <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Designation</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Designation</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addDesignationModal">
                    <i class="fa fa-plus"></i> Add Designation
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Designation List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="designationTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Designation Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($designation as $value) { ?>
                                        <tr>
                                            <td><?php echo $value->des_name; ?></td>
                                            <td>
    <?php 
    // Get the full job description
    $job_description = $value->job_description;
    
    // Check if the description is longer than 60 characters
    if (strlen($job_description) > 60) {
        // If it's too long, display the first 60 characters followed by an ellipsis (...)
        echo substr($job_description, 0, 60) . '...';
    } else {
        // If it's short enough, display the full description
        echo $job_description;
    }
    ?>
</td>
                                            <td class="jsgrid-align-center">
                                                <button type="button" title="Edit" class="btn btn-sm btn-primary waves-effect waves-light edit-designation" data-id="<?php echo $value->id; ?>">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                <button type="button" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light delete-designation" data-id="<?php echo $value->id; ?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDesignationModal" tabindex="-1" role="dialog" aria-labelledby="addDesignationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDesignationModalLabel">Add New Designation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('organization/Save_des'); ?>" id="addDesignationForm" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="form-group">
                   <label class="control-label">Designation Name</label>
                   <input type="text" name="designation" id="newDesignationName" class="form-control" placeholder="Enter designation name" minlength="3" required>
                </div>
                <div class="form-group">
                   <label class="control-label">Job Description</label>
                 <textarea name="job_description" id="newJobDescription" class="form-control" placeholder="Enter job description"></textarea>
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

<div class="modal fade" id="editDesignationModal" tabindex="-1" role="dialog" aria-labelledby="editDesignationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDesignationModalLabel">Edit Designation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url(); ?>organization/Update_des" id="editDesignationForm">
                <div class="modal-body">
                <div class="form-group">
                   <label class="control-label">Designation Name</label>
                   <input type="text" name="designation" id="editDesignationNameModal" class="form-control" placeholder="" required>
                   <input type="hidden" name="id" id="editDesignationIdModal">
                </div>
                <div class="form-group">
                   <label class="control-label">Job Description</label>
                   <textarea name="job_description" id="editJobDescriptionModal" class="form-control" placeholder=""></textarea>
                </div>
                    <div id="designation-form-messages" class="mt-2"></div> </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('backend/footer'); ?>

<script>
    $(document).ready(function() {
        // --- DATA TABLES INITIALIZATION ---
        // Initialize DataTables for the Designation table
        $('#designationTable').DataTable({
            "aaSorting": [[0, 'asc']], // Sort by the first column by default
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
                // --- EDIT DESIGNATION MODAL LOGIC ---
        // Handles opening the edit modal and populating it with data
        $('.edit-designation').on('click', function() {
            var designationId = $(this).data('id');
            // Clear previous messages if any
            $('#designation-form-messages').empty();

            $.ajax({
                url: '<?php echo base_url("organization/getDesignationById/"); ?>' + designationId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.id && response.des_name) {
                        $('#editDesignationIdModal').val(response.id);
                        $('#editDesignationNameModal').val(response.des_name);
                        $('#editJobDescriptionModal').val(response.job_description);
                        $('#editDesignationModal').modal('show');
                    } else {
                        console.error("Error fetching designation data or invalid response.", response);
                        // Optionally show a user-friendly error message in the modal body or a temporary alert
                        alert('Could not load designation details. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error fetching designation: " + status + " - " + error);
                    alert('An error occurred while fetching designation details. Please try again.');
                }
            });
        });

        // --- EDIT DESIGNATION FORM SUBMISSION LOGIC ---
        $('#editDesignationForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $('#designation-form-messages').empty(); // Clear any previous messages

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log("Update response from server (Designation):", response);
                    $('#editDesignationModal').modal('hide');
                    // Reload the page after a short delay to see the updated list
                    setTimeout(function() {
                        location.reload();
                    }, 1000); // Changed delay to 1000ms for faster feedback
                },
                error: function(xhr, status, error) {
                    console.error("Form submission error (Designation): " + status + " - " + error);
                    $('#editDesignationModal').modal('hide');
                    // Reload even on error to ensure the list is updated or any server-side error message can be displayed
                    setTimeout(function() {
                        location.reload();
                    }, 1000); // Changed delay to 1000ms for faster feedback
                }
            });
        });


        // Logic for deleting a Designation via AJAX
                $('.delete-designation').on('click', function(e) {
                    e.preventDefault(); // Prevent the default button action
                    var designationId = $(this).data('id');
                    var confirmDelete = confirm('Are you sure to delete this data?');

                    if (confirmDelete) {
                        $.ajax({
                            url: '<?php echo base_url("organization/des_delete/"); ?>' + designationId,
                            type: 'POST', // Use POST for deletion as it's a modifying action
                            // dataType: 'json', // If your controller returns JSON after delete, uncomment this
                            success: function(response) {
                                console.log("Delete response from server:", response);
                                location.reload(); // Reload the page to show the flashdata message
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX error deleting designation: " + status + " - " + error);
                                location.reload(); // Reload even on error to update list and potentially show error flashdata
                            }
                        });
                    }
                });
            
            </script>