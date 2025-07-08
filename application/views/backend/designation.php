<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
          <div class="page-wrapper">
            <div class="row page-titles">
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
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5">
                        <?php if (isset($editdesignation)) { ?>
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Edit Designation</h4>
                                </div>

                                <?php
                                echo validation_errors();
                                echo $this->upload->display_errors();
                                echo $this->session->flashdata('feedback');
                                ?>

                                <div class="card-body">
                                        <form method="post" action="<?php echo base_url();?>organization/Update_des" enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row ">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Designation Name</label>
                                                            <input type="text" name="designation" id="firstName" value="<?php  echo $editdesignation->des_name;?>" class="form-control" placeholder="">
                                                            <input type="hidden" name="id" value="<?php  echo $editdesignation->id;?>">
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                                    <a href="<?php echo base_url();?>organization/Designation" class="btn btn-danger">Cancel</a>
                                                </div>
                                        </form>
                                </div>
                            </div>
                        <?php } else { ?>

                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Add Designation</h4>
                                </div>

                                <?php
                                echo validation_errors();
                                echo $this->upload->display_errors();
                                echo $this->session->flashdata('feedback');
                                ?>

                                <div class="card-body">
                                        <form method="post" action="Save_des" enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row ">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Designation Name</label>
                                                            <input type="text" name="designation" id="firstName" value="" class="form-control" placeholder="" minlength="3" required>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                                    <a href="<?php echo base_url();?>organization/Designation" class="btn btn-danger">Cancel</a>
                                                </div>
                                        </form>
                                </div>
                            </div>
                        <?php }?>
                    </div>

                    <div class="col-7">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Designation List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Designation </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($designation as $value) {?>
                                            <tr>
                                                <td><?php echo $value->des_name;?></td>
                                                <td class="jsgrid-align-center ">
                                                    <button type="button" title="Edit" class="btn btn-sm btn-primary waves-effect waves-light edit-designation" data-id="<?php echo $value->id?>"><i class="fa fa-pencil-square-o"></i></button>
                                                    <button type="button" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light delete-designation" data-id="<?php echo $value->id;?>"><i class="fa fa-trash-o"></i></button>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                            <form method="post" action="<?php echo base_url();?>organization/Update_des" id="editDesignationForm">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label">Designation Name</label>
                                        <input type="text" name="designation" id="designationNameModal" class="form-control" placeholder="" required>
                                        <input type="hidden" name="id" id="designationIdModal">
                                    </div>
                                    <div id="designation-form-messages" class="mt-2"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php $this->load->view('backend/footer'); ?>

            <script>
            $(document).ready(function() {
                // Logic to open and populate the modal for Designation
                $('.edit-designation').on('click', function() {
                    var designationId = $(this).data('id');
                    // $('#designation-form-messages').empty(); // Removed as we no longer display messages inside modal

                    $.ajax({
                        url: '<?php echo base_url("organization/getDesignationById/"); ?>' + designationId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response && response.id && response.des_name) {
                                $('#designationIdModal').val(response.id);
                                $('#designationNameModal').val(response.des_name);
                                $('#editDesignationModal').modal('show');
                            } else {
                                console.error("Error fetching designation data or invalid response.", response);
                                // No alert or message shown to user in the modal
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error fetching designation: " + status + " - " + error);
                            // No alert or message shown to user in the modal
                        }
                    });
                });

                // Handle form submission for the Designation modal
                $('#editDesignationForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    var formData = $(this).serialize();
                    // $('#designation-form-messages').empty(); // Removed as we no longer display messages inside modal

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            console.log("Update response from server (Designation):", response); // Log response for debugging

                            setTimeout(function() {
                                $('#editDesignationModal').modal('hide');
                                location.reload(); // Reload the page to show updated list and trigger main flashdata
                            }, 700); // Adjust this delay (milliseconds) as desired before closing and reloading
                        },
                        error: function(xhr, status, error) {
                            console.error("Form submission error (Designation): " + status + " - " + error);
                            // No "Failed to update designation" message shown in the modal
                            setTimeout(function() {
                                $('#editDesignationModal').modal('hide');
                                location.reload();
                            }, 700); // Adjust this delay (milliseconds) for error case as desired
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
            });
            </script>