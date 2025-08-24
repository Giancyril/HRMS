<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment extends CI_Controller
{
    /**
     * The constructor for the Recruitment controller.
     * It loads necessary models, libraries, and helpers.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        // Assuming you have a recruitment model to handle job and application data
        $this->load->model('recruitment_model'); 
        $this->load->model('settings_model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $this->load->model('Organization_model'); 
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    /**
     * This is the main index method. It displays a list of available jobs.
     * The logic is similar to Projects::All_Projects().
     */
    public function index()
    {
        // Check if the user is an admin or employee, similar to Projects::index()
        // Here, we'll just load the page with a list of jobs.
        // You might want to handle this differently based on whether the page is public or for logged-in users.
        $data['jobs'] = $this->recruitment_model->get_all_jobs(); // Assuming this model method exists
        $this->load->view('backend/jobs_list', $data); // Assuming you have a view for job listings
    }

    /**
     * This method displays the application form for a specific job.
     * It fetches job details and passes them to the view, similar to Projects::Field_visit().
     * @param int $job_id The ID of the job to apply for.
     */
    public function apply($job_id)
    {
        // This is a public facing page, so no login check is required.
        // If you want it to be private, you can uncomment the login check below.
        /*
        if ($this->session->userdata('user_login_access') != False) {
        } else {
            redirect(base_url(), 'refresh');
        }
        */
        $data['job'] = $this->recruitment_model->get_job_by_id($job_id); // Assuming this model method exists
        
        // Check if the job exists before loading the view
        if (!$data['job']) {
            show_404(); // Display a 404 error if job not found
        }
        $this->load->view('backend/application_form', $data);
    }
    
    /**
     * This method handles the AJAX form submission for a new job application.
     * @param int $job_id The ID of the job being applied for.
     */
    public function apply_ajax($job_id)
    {
        // 1) Set JSON header
        $this->output->set_content_type('application/json');

        // 2) Validation
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[8]|max_length[20]|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Validation failed. Please check your inputs.',
                'errors'  => $this->form_validation->error_array()
            ]);
            return;
        }

        // 3) Create application data array
        $appData = [
            'job_id'      => $job_id,
            'first_name'  => $this->input->post('first_name', TRUE),
            'last_name'   => $this->input->post('last_name', TRUE),
            'email'       => $this->input->post('email', TRUE),
            'phone'       => $this->input->post('phone', TRUE),
            'status'      => 'Pending',
            'applied_at'  => date('Y-m-d H:i:s'),
        ];

        // 4) Save to DB
        $saved = $this->recruitment_model->add_application($appData);
        if (!$saved) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Could not save application. Please try again.'
            ]);
            return;
        }

        // 5) All good
        echo json_encode([
            'status'  => 'success',
            'message' => 'Your application has been submitted successfully!'
        ]);
    }

    public function job_details($job_id)
    {
        // Check if the user is logged in
        if ($this->session->userdata('user_login_access') != False) {
            
            // Load the recruitment model
            $this->load->model('recruitment_model');

            // Fetch job details from the database using the provided ID
            $data['job_details'] = $this->recruitment_model->getJobDetails($job_id);

            // Load the jobs_details view and pass the data to it
            $this->load->view('backend/job_details', $data);

        } else {
            // If the user is not logged in, redirect to the login page
            redirect(base_url(), 'refresh');
        }
    }

    // In your Recruitment.php controller
public function Applications()
{
    // Check if the user is logged in
    if ($this->session->userdata('user_login_access') != False) {
        
        // This is a crucial step: fetch applications from the database
        // Assuming your recruitment_model has a method to get all applications
        $data['applications'] = $this->recruitment_model->get_all_applications(); 

        // Load the view and pass the data
        $this->load->view('backend/applications_list', $data);

    } else {
        // Redirect to the login page if not logged in
        redirect(base_url(), 'refresh');
    }
}

public function view_application($id)
{
    // Check if the user is logged in
    if ($this->session->userdata('user_login_access') != False) {
        
        // Load the model to interact with the database
        $this->load->model('recruitment_model');

        // Fetch a single application record by its ID
        $data['application'] = $this->recruitment_model->get_application_by_id($id);

        // Check if an application was found
        if (empty($data['application'])) {
            show_404();
        }

        // Load the view to display the application details
        $this->load->view('backend/application_details', $data);

    } else {
        // Redirect to login page if not logged in
        redirect(base_url(), 'refresh');
    }
}

// In your Recruitment.php controller
public function delete_application($id)
{
    // Check if the user is logged in
    if ($this->session->userdata('user_login_access') != False) {
        
        // Load the model to interact with the database
        $this->load->model('recruitment_model');

        // Call the model function to delete the application
        $this->recruitment_model->delete_application($id);
        
        // Set a success message
        $this->session->set_flashdata('success', 'Application deleted successfully.');

        // Redirect back to the applications list page
        redirect('recruitment/applications');

    } else {
        // Redirect to login page if not logged in
        redirect(base_url(), 'refresh');
    }
}
}