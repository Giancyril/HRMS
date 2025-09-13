<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Promotions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Promotions</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <?php if ($this->session->userdata('user_type') == 'EMPLOYEE') { ?>
                <?php } else { ?>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addPromotionModal">
                        <i class="fa fa-plus"></i> Add Promotion
                    </button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Promotions List </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="promotionsTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Previous Designation</th>
                                        <th>New Designation</th>
                                        <th>Promotion Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($promotions as $promo) : ?>
                                        <tr>
                                            <td><?php echo $promo['first_name'] . ' ' . $promo['last_name']; ?></td>
                                            <td><?php echo $promo['dep_name']; ?></td>
                                            <td><?php echo $promo['old_des_name']; ?></td>
                                            <td><?php echo $promo['new_des_name']; ?></td>
                                            <td><?php echo $promo['promotion_date']; ?></td>
                                            <td class="jsgrid-align-center">
                                                <a href="#" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light promotion_delete" data-id="<?php echo $promo['promotion_id']; ?>">
                                                    <i class="fa fa-trash"></i> </a>
                                                </a>
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

<div class="modal fade" id="addPromotionModal" tabindex="-1" role="dialog" aria-labelledby="addPromotionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPromotionModalLabel">Add New Promotion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url('promotion/add_promotion'); ?>" id="promotionForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                 <label class="m-t-20">Employee</label>
                                    <select class="form-control custom-select" data-placeholder="Choose a Employee" tabindex="1" name="em_id" id="em_id" required>
                                    <option value="">Select Here</option>
                                    <?php foreach ($employees as $employee) : ?>
                                    <option value="<?php echo $employee->id ?>"><?php echo $employee->first_name . ' ' . $employee->last_name ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="m-t-20">Current Designation</label>
                                <input type="text" class="form-control" id="current_des" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="m-t-20">New Designation</label>
                                <select class="form-control custom-select" data-placeholder="Choose New Designation" tabindex="1" name="new_des_id" required>
                                    <option value="">Select Here</option>
                                    <?php foreach ($designations as $designation) : ?>
                                        <option value="<?php echo $designation->id; ?>"><?php echo $designation->des_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="m-t-20">Promotion Date </label>
                                <div id="" class="input-group date">
                                    <input name="attdate" class="form-control mydatetimepickerFull" required>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
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


<?php $this->load->view('backend/footer'); ?>

<script>
    $(document).ready(function() {
        $('#promotionsTable').DataTable({
            "aaSorting": [[3, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });

        // AJAX form submission
$('#promotionForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(response) {
            if (response.includes("Successfully Added.")) {
                // The green modal will show here
                $('#successMessage').text(response);
                $('#addPromotionModal').modal('hide');
                $('#successModal').modal('show');
                
                // Reload the page after a short delay
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                
            }
        },
        error: function() {
            
        }
    });
});

        // Fetch current designation for the selected employee
        $('#em_id').change(function() {
            var employeeId = $(this).val();
            if (employeeId) {
                $.ajax({
                    url: '<?php echo base_url(); ?>promotion/get_employee_details',
                    type: 'POST',
                    data: {
                        em_id: employeeId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#current_des').val(response.current_des_name);
                        } else {
                            $('#current_des').val('N/A');
                        }
                    },
                    error: function() {
                        $('#current_des').val('Error fetching data.');
                    }
                });
            } else {
                $('#current_des').val('');
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".promotion_delete").click(function(e) {
            e.preventDefault();
            var iid = $(this).attr('data-id');
            $.ajax({
                url: '<?php echo base_url(); ?>promotion/delete_promotion?id=' + iid,
                method: 'GET',
                data: 'data',
            }).done(function(response) {
                console.log(response);
                $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            });
        });
    });
</script>