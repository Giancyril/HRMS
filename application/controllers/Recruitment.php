<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recruitment_model');
        $this->load->model('settings_model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        // Load the correct model: Organization_model, not Designation_model
        $this->load->model('Organization_model'); 
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        // Fetch all job postings from the database
        $data['jobs'] = $this->Recruitment_model->get_all_jobs();
        // Call the correct model to get designations
        $data['designations'] = $this->Organization_model->get_all_designations(); 
        
        // Pass both sets of data to the jobs_list view
        $this->load->view('backend/jobs_list', $data);
    }
    
    // ... rest of your controller code remains the same ...

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
    
    public function add_job() {
        // No code needed here since the index method already loads the necessary data.
    }
    
    public function save_job() {
        // Server-side validation
        $this->form_validation->set_rules('title', 'Job Title', 'required');
        $this->form_validation->set_rules('description', 'Job Description', 'required');
        $this->form_validation->set_rules('requirements', 'Job Requirements', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // If validation fails, return an error message
            echo "Validation failed. Please fill out all required fields.";
            exit();
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'requirements' => $this->input->post('requirements'),
                'posted_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            );
            $this->Recruitment_model->save_job($data);
            // Return a success message for the AJAX call
            echo "Job posted successfully!";
        }
    }
}