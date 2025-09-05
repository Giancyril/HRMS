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
        $this->load->model('Organization_model');
        $data['jobs'] = $this->recruitment_model->get_all_jobs();
        $data['designations'] = $this->Organization_model->get_all_designations();
        $this->load->view('backend/jobs_list', $data);
    }

    /**
     * This method displays the application form for a specific job.
     * It fetches job details and passes them to the view, similar to Projects::Field_visit().
     * @param int $job_id The ID of the job to apply for.
     */
    public function apply($job_id)
    {
        $data['job'] = $this->recruitment_model->get_job_by_id($job_id);
        if (!$data['job']) {
            show_404();
        }
        $this->load->view('backend/application_form', $data);
    }

    /**
     * This method handles the AJAX form submission for a new job application.
     * It no longer handles resume uploads.
     */
    public function apply_ajax()
    {
        $this->output->set_content_type('application/json');

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('job_id', 'Job ID', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[8]|max_length[20]|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Validation failed. ' . validation_errors()
            ]);
            return;
        }

        $appData = [
            'job_id'       => $this->input->post('job_id', TRUE),
            'first_name'   => $this->input->post('first_name', TRUE),
            'last_name'    => $this->input->post('last_name', TRUE),
            'email'        => $this->input->post('email', TRUE),
            'phone'        => $this->input->post('phone', TRUE),
            'status'       => 'Pending',
            'applied_at'   => date('Y-m-d H:i:s'),
        ];

        $saved = $this->recruitment_model->add_application($appData);
        if (!$saved) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Could not save application. Please try again.'
            ]);
            return;
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Your application has been submitted successfully!'
        ]);
    }

    public function add_job() {
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->model('Organization_model');
            $data['designations'] = $this->Organization_model->get_all_designations();
            $this->load->view('backend/add_job_posting', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function job_details($job_id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->model('recruitment_model');
            $data['job_details'] = $this->recruitment_model->getJobDetails($job_id);
            $this->load->view('backend/job_details', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function save_job()
    {
        if ($this->session->userdata('user_login_access') == FALSE) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            } else {
                redirect('recruitment');
            }
            return;
        }
        $this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Job Description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('requirements', 'Requirements', 'trim|required|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            $err = strip_tags(validation_errors());
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => $err]);
            } else {
                $this->session->set_flashdata('error', $err);
                redirect('recruitment');
            }
            return;
        }

        $data = [
            'job_title'        => $this->input->post('job_title', TRUE),
            'description'  => $this->input->post('description', TRUE),
            'requirements' => $this->input->post('requirements', TRUE),
            'posted_at'    => date('Y-m-d H:i:s'),
            'is_active'    => 1
        ];

        $success = $this->recruitment_model->save_job($data);
        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status'  => $success ? 'success' : 'error',
                'message' => $success ? 'Added successfully.' : 'Failed to save job.'
            ]);
        } else {
            $this->session->set_flashdata(
                $success ? 'success' : 'error',
                $success ? 'Job added successfully.' : 'Failed to save job.'
            );
            redirect('recruitment');
        }
    }

    public function get_jobs_data()
    {
        $this->output->set_content_type('application/json');

        if ($this->session->userdata('user_login_access') == FALSE) {
            $this->output->set_status_header(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            return;
        }

        $jobs = $this->recruitment_model->get_all_jobs();
        $jobs_data = [];

        foreach ($jobs as $job) {
            $jobs_data[] = [
                'title' => html_escape($job['title']),
                'description' => html_escape(substr($job['description'], 0, 100)) . '...',
                'posted_date' => html_escape(date('F j, Y', strtotime($job['posted_at']))),
                'action_buttons' => '<a href="' . site_url('recruitment/job_details/' . $job['job_id']) . '" class="btn btn-sm btn-primary">View</a> ' .
                                    '<button type="button" class="btn btn-sm btn-info apply-job-btn" data-toggle="modal" data-target="#applyModal" data-job-id="' . html_escape($job['job_id']) . '" data-job-title="' . html_escape($job['title']) . '"><i class="fa fa-paper-plane"></i> Apply</button>'
            ];
        }

        echo json_encode($jobs_data);
    }
    
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
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->model('recruitment_model');
            $data['application'] = $this->recruitment_model->get_application_by_id($id);
            if (empty($data['application'])) {
                show_404();
            }
            $this->load->view('backend/application_details', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function delete_application($id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->model('recruitment_model');
            $this->recruitment_model->delete_application($id);
            $this->session->set_flashdata('success', 'Application deleted successfully.');
            redirect('recruitment/applications');
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}