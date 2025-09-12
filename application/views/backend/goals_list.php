    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Goals</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Goals</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addGoalModal">
                        <i class="fa fa-plus"></i> Add Goal
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Goals List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="goals_table" class="display nowrap table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Goal Type</th>
                                            <th>Subject</th>
                                            <th>Target Achievement</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($goals)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No goals are currently available.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($goals as $goal): ?>
                                                <tr>
                                                    <td><?php echo html_escape($goal->type_name); ?></td>
                                                    <td><?php echo html_escape($goal->subject); ?></td>
                                                    <td><?php echo html_escape($goal->target_achievement); ?></td>
                                                    <td><?php echo html_escape(date('F j, Y', strtotime($goal->start_date))); ?></td>
                                                    <td><?php echo html_escape(date('F j, Y', strtotime($goal->end_date))); ?></td>
                                                    <td><?php echo html_escape($goal->status); ?></td>
                                                    <td class="jsgrid-align-center">
                                                        <a href="<?php echo site_url('goals/view/' . $goal->id); ?>" 
                                                                class="btn btn-sm btn-primary">View</a>
                                                        <button type="button" class="btn btn-sm btn-info edit-goal-btn"
                                                                data-toggle="modal"
                                                                data-target="#editGoalModal"
                                                                data-goal-id="<?php echo html_escape($goal->id); ?>">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                        <a href="<?php echo site_url('goals/delete_goal/' . $goal->id); ?>"
                                                        class="btn btn-sm btn-danger delete-goal-btn"
                                                        data-goal-id="<?php echo html_escape($goal->id); ?>">
                                                            <i class="fa fa-trash"></i>
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
        </div>
    </div>

    <div class="modal fade" id="addGoalModal" tabindex="-1" role="dialog" aria-labelledby="addGoalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGoalModalLabel">Add New Goal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addGoalForm" action="<?php echo site_url('goals/add_goal'); ?>" method="post">
                    <div class="modal-body">
                        <div class="alert modal-message" style="display: none;"></div>
                        <div class="form-group">
                            <label for="goal-type">Goal Type</label>
                            <select name="goal_type_id" id="goal-type" class="form-control" required>
                                <option value="">Select Goal Type</option>
                                <?php if (!empty($goal_types)): ?>
                                    <?php foreach ($goal_types as $type): ?>
                                        <option value="<?php echo $type->id; ?>"><?php echo html_escape($type->type_name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="target-achievement">Target Achievement</label>
                            <input type="text" name="target_achievement" id="target-achievement" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="add-start-date">Start Date</label>
                            <div class="input-group date">
                                <input type="text" name="start_date" class="form-control mydatetimepickerFull" id="add-start-date" required>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add-end-date">End Date</label>
                            <div class="input-group date">
                                <input type="text" name="end_date" class="form-control mydatetimepickerFull" id="add-end-date" required>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Not Started">Not Started</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="On Hold">On Hold</option>
                            </select>
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

    <div class="modal fade" id="editGoalModal" tabindex="-1" role="dialog" aria-labelledby="editGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGoalModalLabel">Edit Goal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editGoalForm" action="<?php echo site_url('goals/update_goal'); ?>" method="post">
                    <div class="modal-body">
                        <div class="alert modal-message" style="display: none;"></div>
                        <input type="hidden" name="id" id="edit-goal-id">
                        <div class="form-group">
                            <label for="edit-goal-type">Goal Type</label>
                            <select name="goal_type_id" id="edit-goal-type" class="form-control" required>
                                <option value="">Select Goal Type</option>
                                <?php if (!empty($goal_types)): ?>
                                    <?php foreach ($goal_types as $type): ?>
                                        <option value="<?php echo $type->id; ?>"><?php echo html_escape($type->type_name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-subject">Subject</label>
                            <input type="text" name="subject" id="edit-subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-target-achievement">Target Achievement</label>
                            <input type="text" name="target_achievement" id="edit-target-achievement" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-start-date">Start Date</label>
                            <div class="input-group date">
                                <input type="text" name="start_date" class="form-control mydatetimepickerFull" id="edit-start-date" required>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit-end-date">End Date</label>
                            <div class="input-group date">
                                <input type="text" name="end_date" class="form-control mydatetimepickerFull" id="edit-end-date" required>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit-status">Status</label>
                            <select name="status" id="edit-status" class="form-control">
                                <option value="Not Started">Not Started</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="On Hold">On Hold</option>
                            </select>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#goals_table').DataTable({
                "aaSorting": [[1, 'desc']],
                dom: 'Bfrtip',
                buttons: ['csv', 'excel', 'pdf', 'print']
            });       

            // Handle form submission for both Add and Update
        $('#addgoalForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        // Keep the dataType setting if your PHP always returns JSON, otherwise remove it to handle plain text.
        // dataType: 'json', 
        success: function(response) {
            // In this case, 'response' will be the plain text string.
            if (response.trim() === 'Successfully Added!') {
                $('#successMessage').text(response);
                $('#addgoalModal').modal('hide');
                $('#successModal').modal('show');
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                // This block would handle any other plain text as an error
                console.log("Error: " + response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus, errorThrown);
        }
    });
});

            // Handle Edit Goal Button Click (AJAX)
            $(document).on('click', '.edit-goal-btn', function() {
                var goalId = $(this).data('goal-id');
                var messageBox = $('#editGoalModal').find('.modal-message');
                messageBox.hide();

                $.ajax({
                    url: '<?php echo site_url('goals/get_goal_by_id/'); ?>' + goalId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(goal) {
                        $('#edit-goal-id').val(goal.id);
                        $('#edit-goal-type').val(goal.goal_type_id);
                        $('#edit-subject').val(goal.subject);
                        $('#edit-target-achievement').val(goal.target_achievement);
                        $('#edit-description').val(goal.description);
                        $('#edit-start-date').val(goal.start_date);
                        $('#edit-end-date').val(goal.end_date);
                        $('#edit-status').val(goal.status);
                        $('#editGoalModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching goal data:", error);
                        messageBox.removeClass('alert-success').addClass('alert-danger').text('Failed to retrieve goal data. Please try again.').show();
                    }
                });
            });

            // Handle Edit Goal Form Submission (AJAX)
            $('#editGoalForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                var messageBox = form.closest('.modal-content').find('.modal-message');
                
                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            messageBox.removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                            setTimeout(function() {
                                $('#editGoalModal').modal('hide');
                                location.reload(); 
                            }, 2000); 
                        } else {
                            messageBox.removeClass('alert-success').addClass('alert-danger').text(response.message).show();
                        }
                    },
                    error: function() {
                        messageBox.removeClass('alert-success').addClass('alert-danger').text('An error occurred. Please try again.').show();
                    }
                });
            });

            // Handle Delete Goal Button Click
            $(document).on('click', '.delete-goal-btn', function(e) {
                e.preventDefault();
                var deleteUrl = $(this).attr('href');
                var goalId = $(this).data('goal-id');

                if (confirm("Are you sure you want to delete this goal?")) {
                    window.location.href = deleteUrl;
                }
            });
        });
    </script>

    <?php $this->load->view('backend/footer'); ?>