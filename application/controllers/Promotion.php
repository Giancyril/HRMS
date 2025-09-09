<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('project_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('promotion_model');
        $this->load->model('organization_model'); 
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        if ($this->session->userdata('user_login_access') == 1) {
            redirect('dashboard/Dashboard');
        }
        $this->load->view('login');
    }

    public function promotion_list() {
        $data['promotions'] = $this->promotion_model->get_promotions();
        $data['employees'] = $this->organization_model->get_all_employees(); 
        $data['designations'] = $this->organization_model->get_designations(); 
        $this->load->view('backend/promotion_list', $data);
    }

    public function add_promotion() {
    if ($this->input->post()) {
        $this->form_validation->set_rules('em_id', 'Employee', 'required');
        $this->form_validation->set_rules('new_des_id', 'New Designation', 'required');
        $this->form_validation->set_rules('attdate', 'Promotion Date', 'required');

        if ($this->form_validation->run() == TRUE) {
            $em_id = $this->input->post('em_id');
            $new_des_id = $this->input->post('new_des_id');
            $promotion_date = $this->input->post('attdate');
            
            $employee = $this->organization_model->get_employee_by_id($em_id);
            
            if (!$employee) {
                echo "Error: Employee not found.";
                return;
            }
            
            $old_des_id = is_object($employee) ? $employee->des_id : $employee['des_id'];

            $promotion_data = [
                'em_id' => $em_id,
                'old_des_id' => $old_des_id,
                'new_des_id' => $new_des_id,
                'promotion_date' => $promotion_date,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->promotion_model->add_promotion($promotion_data);
            $this->organization_model->update_employee_designation($em_id, $new_des_id);

            echo "Successfully Added!";
        } else {
            echo validation_errors();
        }
    } else {
        redirect('promotion/promotion_list');
    }
}

    public function get_employee_details() {
        $em_id = $this->input->post('em_id');
        $employee_details = $this->organization_model->get_employee_by_id($em_id);
        
        if ($employee_details) {
            // Check if the returned data is an object or an array
            $current_des_id = is_object($employee_details) ? $employee_details->des_id : $employee_details['des_id'];
            $designation = $this->organization_model->get_designation_by_id($current_des_id);
            $response = [
                'success' => true,
                // Check if the returned data is an object or an array
                'current_des_name' => is_object($designation) ? $designation->des_name : $designation['des_name']
            ];
            echo json_encode($response);
        } else {
            $response = [
                'success' => false,
                'message' => 'Employee not found.'
            ];
            echo json_encode($response);
        }
    }
    
    public function delete_promotion($id) {
        $promotion = $this->promotion_model->get_promotion_by_id($id);
        if ($promotion) {
            $this->promotion_model->delete_promotion($id);
            $this->session->set_flashdata('success', 'Promotion deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Promotion not found.');
        }
        redirect('promotion/promotion_list');
    }
}