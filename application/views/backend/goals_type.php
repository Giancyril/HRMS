<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Goal Types</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Goal Types</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <?php if ($this->session->userdata('user_type') == 'EMPLOYEE') { ?>
                    <?php } else { ?>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#goaltypemodel" id="addGoalTypeBtn">
                        <i class="fa fa-plus"></i> Add Goal Type
                    </button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Goal Types List </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($goal_types)): ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No goal types found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($goal_types as $type): ?>
                                            <tr>
                                                <td><?php echo html_escape($type->id); ?></td>
                                                <td><?php echo html_escape($type->type_name); ?></td>
                                                <td class="jsgrid-align-center">
                                                    <button type="button" class="btn btn-sm btn-info edit-goal-type-btn"
                                                            data-toggle="modal"
                                                            data-target="#goaltypemodel"
                                                            data-goal-type-id="<?php echo html_escape($type->id); ?>">
                                                        <i class="fa fa-pencil"></i> Edit
                                                    </button>
                                                    <a href="<?php echo site_url('goals/delete_goal_type/' . $type->id); ?>"
                                                       class="btn btn-sm btn-danger delete-goal-type-btn"
                                                       onclick="return confirm('Are you sure you want to delete this goal type?');">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="goaltypemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Goal Type</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="" id="goaltypeform" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">Name of Goal Type</label>
                                <input type="text" name="type_name" class="form-control" id="recipient-name1" minlength="4" maxlength="25" value="" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="" class="form-control" id="recipient-name1">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Handle "Add Goal Type" button click
        $("#addGoalTypeBtn").click(function () {
            $('#goaltypeform')[0].reset();
            $('#goaltypeform').find('[name="id"]').val('');
            $('#goaltypeform').attr('action', '<?php echo site_url("goals/save_goal_type"); ?>');
            $('#goaltypemodel').modal('show');
        });

        // Handle "Edit" button click
        $(".edit-goal-type-btn").click(function (e) {
            e.preventDefault();
            var goalTypeId = $(this).attr('data-goal-type-id');
            $('#goaltypeform')[0].reset();
            $('#goaltypeform').attr('action', '<?php echo site_url("goals/update_goal_type"); ?>');
            $('#goaltypemodel').modal('show');
            $.ajax({
                url: '<?php echo site_url("goals/get_goal_type_by_id"); ?>/' + goalTypeId,
                method: 'GET',
                dataType: 'json',
            }).done(function (response) {
                if (response.goaltypevalue) {
                    $('#goaltypeform').find('[name="id"]').val(response.goaltypevalue.id);
                    $('#goaltypeform').find('[name="type_name"]').val(response.goaltypevalue.type_name);
                } else {
                    console.error("Goal type data not found in response.");
                    alert("Failed to retrieve goal type data.");
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed: " + textStatus, errorThrown);
                alert("Failed to retrieve goal type data.");
            });
        });

        // Handle form submission for both Add and Update
        $('#goaltypeForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        dataType: 'json', // Specify that the server will return JSON
        success: function(response) {
            // Check the status from the JSON response
            if (response.status === 'success') {
                // Set the success message from the response
                $('#successMessage').text(response.message);
                
                // Hide the form modal and show the success modal
                $('#addPromotionModal').modal('hide');
                $('#successModal').modal('show');
                
                // Reload the page after a short delay
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                // Handle error case, if the server sends back an error status
                // You can display the error message in the form modal
                console.log("Error: " + response.message);
                // Optionally display an error message to the user here
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle AJAX request errors
            console.error("AJAX Error: " + textStatus, errorThrown);
            // Optionally display a generic error message
        }
    });
});

        // Delete Goal Type (client-side confirmation)
        $(".delete-goal-type-btn").click(function (e) {
            var confirmation = confirm('Are you sure you want to delete this goal type?');
            if (!confirmation) {
                e.preventDefault();
            }
        });
    });
</script>

<?php $this->load->view('backend/footer'); ?>