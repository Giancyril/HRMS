<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recruitment_model');
        $this->load->model('settings_model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['jobs'] = $this->Recruitment_model->get_all_jobs();
        $this->load->view('backend/jobs_list', $data);
    }

    public function job_details($job_id) {
        $data['job'] = $this->Recruitment_model->get_job_by_id($job_id);
        if (empty($data['job'])) {
            show_404();
        }
        $this->load->view('backend/job_details', $data);
    }

    public function apply($job_id) {
        $data['job'] = $this->Recruitment_model->get_job_by_id($job_id);
        if (empty($data['job'])) {
            show_404();
        }
    
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('backend/application_form', $data);
        } else {
            $config['upload_path'] = './uploads/resumes/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
    
            $this->upload->initialize($config);
    
            if (!$this->upload->do_upload('resume')) {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('backend/application_form', $data);
            } else {
                $upload_data = $this->upload->data();
                $resume_path = 'uploads/resumes/' . $upload_data['file_name'];
    
                $applicant_data = array(
                    'job_id' => $job_id,
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'resume_path' => $resume_path,
                    'applied_at' => date('Y-m-d H:i:s')
                );
    
                $this->Recruitment_model->save_applicant($applicant_data);
                redirect('recruitment/application_success');
            }
        }
    }

    public function applications() {
        $data['applications'] = $this->Recruitment_model->get_all_applicants();
        $this->load->view('backend/applications_list', $data);
    }
    
    public function application_success() {
        $this->load->view('backend/application_success');
    }

    // New method to load the job creation form
    public function add_job() {
        $this->load->view('backend/jobs_list');
    }
    
    // New method to save a new job posting
    public function save_job() {
        $this->form_validation->set_rules('title', 'Job Title', 'required');
        $this->form_validation->set_rules('description', 'Job Description', 'required');
        $this->form_validation->set_rules('requirements', 'Job Requirements', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // If validation fails, return an error message to the AJAX call
            echo "Validation failed. Please fill out all required fields.";
            exit(); // Exit to prevent further execution
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'requirements' => $this->input->post('requirements'),
                'posted_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            );
            $this->Recruitment_model->save_job($data);
            // Instead of redirecting, return a success message
            echo "Job posted successfully!";
        }
    }
}
