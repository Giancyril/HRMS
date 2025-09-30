<?php
$this->load->view('backend/header');
?>
<?php
$this->load->view('backend/sidebar');
?>
<div class="page-wrapper">
  <div class="message">
  </div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Payroll View
      </h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">Home
          </a>
        </li>
        <li class="breadcrumb-item active">Payroll View
        </li>
      </ol>
    </div>
  </div>
  <div class="container-fluid">
   
    <div class="row">
      <div class="col-12">
        <div class="card card-outline-info">
          <div class="card-header">
            <h4 class="m-b-0 text-white"> Monthly Payroll List
            </h4>
          </div>
          <div class="card-body">
            <!--Savd vdgff gdfg dfg dfgdfg df  gd gdd gfd-->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="" id="salaryform" class="form-material row">
                                    <div class="form-group col-md-3">
    <select class="form-control custom-select" tabindex="1" name="emid" id="emid" style="margin-top: 23px" required>
        <option value="">Employee</option>
        
        <?php 
        // 1. Define the user type and get the logged-in user's ID
        $user_is_employee = ($this->session->userdata('user_type') == 'EMPLOYEE');
        
        // *** This is the correct session variable based on your controller ***
        $current_employee_id = $this->session->userdata('user_login_id'); 
        
        // IF the user is an EMPLOYEE: strictly limit the dropdown to only their name
        if ($user_is_employee) :
            foreach($employee as $value):
                // Check if the employee ID in the list matches the logged-in user's ID
                if($value->em_id == $current_employee_id): ?>
                
                <option value="<?php echo $value->em_id; ?>" selected>
                    <?php echo $value->first_name ?> <?php echo $value->last_name ?>
                </option>
                
                <?php endif;
            endforeach;
        
        // ELSE (ADMIN/HR-MANAGER): display ALL employees
        else :
            foreach($employee as $value): ?>
            <option value="<?php echo $value->em_id; ?>">
                <?php echo $value->first_name ?> <?php echo $value->last_name ?>
            </option>
            <?php endforeach;
        endif; 
        ?>
    </select>
</div>
                                    <div class="form-group col-md-4">
                                      <label>
                                      </label>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <div class='input-group date' id=''>
                                            <input type='text' name="datetime" class="form-control mydatetimepicker" placeholder="Month"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div> 
                                      <div class="form-group col-md-3">
                                      <button style="float:left;margin-top:23px" type="submit" id="BtnSubmit" class="btn btn-info">Submit</button>          
                                       </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>            
            <!--Savd vdgff gdfg dfg dfgdfg df  gd gdd gfd-->
            <div class="salaryr">

            </div>
            <button type='button' class='btn btn-primary print_payslip_btn' id='print_payslip_btn'><i class='fa fa-print'></i><i class='' aria-hidden='true' onclick='printDiv()'></i>  Print</button>                                
          </div>
        </div>
      </div>
    </div>


    <script>
        $('.print_payslip_btn').hide();
        // Populate the payroll table to generate the payroll for each individual
      $("#BtnSubmit").on("click", function(event){
        event.preventDefault();
        var emid = $('#emid').val();
        var datetime = $('.mydatetimepicker').val();
        
        $.ajax({
          url: "load_employee_Invoice_by_EmId_for_pay?date_time="+datetime+"&emid="+emid,
          type:"GET",
          dataType:'',
          data:'data',          
          success: function(response) {
            // console.log(response);
            $('.salaryr').html(response);
              $('.print_payslip_btn').show();
          },
          error: function(response) {
            
          }
        });
      });
    </script>


                            
    <?php
$this->load->view('backend/footer');
?>
   <script src="<?php echo base_url(); ?>assets/js/jquery.PrintArea.js" type="text/JavaScript"></script>
    <script>
    $(document).ready(function() {
        $(".print_payslip_btn").click(function() {
            console.log('sfsdfs');
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.salaryr").printArea(options);
        });
    });
    </script>