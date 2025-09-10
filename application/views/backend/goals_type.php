<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
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
           <div class="success-message" style="display: none;">
                <div class="alert alert-success text-center">
                    Successfully Added
                </div>
           </div>
           <div class="flash-message">
                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success text-center">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php elseif ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php endif; ?>
           </div>
           <div class="container-fluid">
                <div class="row m-b-10">
                    <div class="col-12">
                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addGoalTypeModal">
                         <i class="fa fa-plus"></i> Add Goal Type
                         </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                         <div class="card card-outline-info">
                              <div class="card-header">
                                   <h4 class="m-b-0 text-white">Goal Types List</h4>
                              </div>
                               <div class="card-body">
                                    <div class="table-responsive">
                                         <table id="goal_types_table" class="display nowrap table table-hover table-striped table-bordered">
                                              <thead>
                                                   <tr>
                                                        <th>Type ID</th>
                                                        <th>Goal Name</th>
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
                                                        <td><?php echo html_escape($type['id']); ?></td>
                                                        <td><?php echo html_escape($type['type_name']); ?></td>
                                                        <td class="jsgrid-align-center">
                                                             <button type="button" class="btn btn-sm btn-info edit-goal-type-btn"
                                                                  data-toggle="modal"
                                                                  data-target="#editGoalTypeModal"
                                                                  data-goal-type-id="<?php echo html_escape($type['id']); ?>">
                                                             <i class="fa fa-pencil"></i> Edit
                                                             </button>
                                                              <a href="<?php echo site_url('goals/delete_goal_type/' . $type['id']); ?>"
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
           </div>
           <div class="modal fade" id="addGoalTypeModal" tabindex="-1" role="dialog" aria-labelledby="addGoalTypeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                     <div class="modal-content">
                          <div class="modal-header">
                               <h5 id="addGoalTypeModalLabel" class="modal-title">Add New Goal Type</h5>
                               <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                          </div>
                          <div class="modal-body">
                               <div class="alert modal-message text-center" style="display:none;"></div>
                               <form id="addGoalTypeForm" action="<?php echo site_url('goals/save_goal_type'); ?>" method="post">
                                    <div class="form-body">
                                         <div class="form-group">
                                              <label>Goal Type Name</label>
                                              <input type="text" name="type_name" class="form-control" required>
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
           </div>
      </div>

      <?php $this->load->view('backend/footer'); ?>

      <script type="text/javascript">
    $(document).ready(function () {
        $(".goaltype").click(function (e) {
            e.preventDefault(e);
            var iid = $(this).attr('data-id');
            $('#goaltypeform').trigger("reset");
            $('#goaltypemodel').modal('show');
            $.ajax({
                url: 'GoalTypebyib?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).done(function (response) {
                console.log(response);
                $('#goaltypeform').find('[name="id"]').val(response.goaltypevalue.id).end();
                $('#goaltypeform').find('[name="typename"]').val(response.goaltypevalue.type_name).end();
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".goaltype_delete").click(function (e) {
            e.preventDefault(e);
            var iid = $(this).attr('data-id');
            $.ajax({
                url: 'GoalTypeDelet?id=' + iid,
                method: 'GET',
                data: 'data',
                dataType: 'json',
            }).done(function (response) {
                console.log(response);
                $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                window.setTimeout(function(){location.reload()},2000)
            });
        });
    });
</script>           
<?php $this->load->view('backend/footer'); ?>