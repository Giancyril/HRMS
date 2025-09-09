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
            <div class="row">
                <div class="col-6">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"> Add New Promotion </h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?php echo base_url('promotion/add_promotion'); ?>" id="promotionForm" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="m-t-20">Employee</label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Employee" tabindex="1" name="em_id" id="em_id" required>
                                                    <option value="">Select Here</option>
                                                    <?php foreach($employees as $employee): ?>
                                                    <option value="<?php echo $employee->id ?>"><?php echo $employee->first_name.' '.$employee->last_name ?></option>
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
                                                    <?php foreach($designations as $designation): ?>
                                                    <option value="<?php echo $designation->id ?>"><?php echo $designation->des_name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                         <div class="form-group">    
                                            <label class="m-t-20">Promotion Date </label>
                                            <div id="" class="input-group date" >
                                                <input name="attdate" class="form-control mydatetimepickerFull" value="<?php if(!empty($attval->atten_date)) { 
                                                $old_date_timestamp = strtotime($attval->atten_date);
                                                $new_date = date('Y-m-d', $old_date_timestamp);    
                                                echo $new_date; } ?>" required>
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                             </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('backend/footer'); ?>
<script>
    $(document).ready(function() {
        $('#em_id').change(function() {
            var em_id = $(this).val();
            if (em_id) {
                $.ajax({
                    url: '<?php echo base_url("promotion/get_employee_details"); ?>',
                    type: 'POST',
                    data: {
                        'em_id': em_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#current_des').val(response.current_des_name);
                        } else {
                            $('#current_des').val('Designation not found');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#current_des').val('Error fetching designation');
                    }
                });
            } else {
                $('#current_des').val('');
            }
        });
    });
</script>
