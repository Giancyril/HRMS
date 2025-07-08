<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('organization_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
    }
    
    public function index()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
            $data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
            $this->load->view('login');
    }

    // --- Department Management ---
    public function Department(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['department'] = $this->organization_model->depselect();
            $this->load->view('backend/department',$data); 
        } else {
            redirect(base_url() , 'refresh');
        }           
    }

    public function Save_dep(){
        if($this->session->userdata('user_login_access') != False) { 
            $dep = $this->input->post('department');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('department','department','trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors(); // Consider returning JSON for AJAX calls
            } else {
                $data = array('dep_name' => $dep);
                $success = $this->organization_model->Add_Department($data); // Assuming Add_Department returns boolean or ID
                if ($success) {
                    echo "Successfully Added"; // Consider returning JSON for AJAX calls
                } else {
                    echo "Failed to add department"; // Consider returning JSON for AJAX calls
                }
            }
        } else {
            redirect(base_url() , 'refresh');
        }           
    }

    public function Delete_dep($dep_id){
        if($this->session->userdata('user_login_access') != False) { 
        $this->organization_model->department_delete($dep_id);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('organization/Department');
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    
    // Function to get Department by ID for AJAX (used by modal)
    public function getDepartmentById($id) {
        if($this->session->userdata('user_login_access') != False) {
            $department = $this->organization_model->department_edit($id); // Reuse your existing model method
            if ($department) {
                echo json_encode($department);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Department not found.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']); // Return JSON for unauthorized AJAX
        }
    }

     public function Dep_edit($dep){
        if($this->session->userdata('user_login_access') != False) { 
        $data['department'] = $this->organization_model->depselect();
        $data['editdepartment']=$this->organization_model->department_edit($dep);
        $this->load->view('backend/department', $data);
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }

    public function Update_dep(){
        if($this->session->userdata('user_login_access') != False) { 
        $id = $this->input->post('id');
        $department = $this->input->post('department');
        $data =  array('dep_name' => $department );
        $this->organization_model->Update_Department($id, $data);
        #$this->session->set_flashdata('feedback','Updated Successfully');
        echo "Successfully Updated";
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }

    // --- Designation Management ---
    public function Designation(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['designation'] = $this->organization_model->desselect();
            $this->load->view('backend/designation',$data);
        } else {
            redirect(base_url() , 'refresh');
        }           
    }

    public function Save_des(){
        if($this->session->userdata('user_login_access') != False) { 
            $des = $this->input->post('designation');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('designation','designation','trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors(); // Consider returning JSON for AJAX
            } else {
                $data = array('des_name' => $des);
                $success = $this->organization_model->Add_Designation($data); // Assuming Add_Designation returns boolean or ID
                if ($success) {
                    echo "Successfully Added"; // Consider returning JSON for AJAX
                } else {
                    echo "Failed to add designation"; // Consider returning JSON for AJAX
                }
            }
        } else {
            redirect(base_url() , 'refresh');
        }           
    }

    public function des_delete($des_id){
        if($this->session->userdata('user_login_access') != False) {
        $this->organization_model->designation_delete($des_id);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('organization/Designation');
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }

    // Function to get Designation by ID for AJAX (used by modal)
    public function getDesignationById($id) {
        if ($this->session->userdata('user_login_access') != False) {
            $data = $this->organization_model->getDesignationById($id);
            if ($data) {
                echo json_encode($data);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Designation not found.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
        }
    }

    public function Edit_des($des){
        if($this->session->userdata('user_login_access') != False) {
        $data['designation'] = $this->organization_model->desselect();
        $data['editdesignation']=$this->organization_model->designation_edit($des);
        $this->load->view('backend/designation', $data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }

    // This is the correct and only Update_des function now.
    public function Update_des(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $designation = $this->input->post('designation');
        $data =  array('des_name' => $designation );
        $this->organization_model->Update_Designation($id, $data);
        echo "Successfully Updated";
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
}