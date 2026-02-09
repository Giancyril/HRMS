<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Output $output
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_DB $db
 * @property CI_Session $session
 * @property login_model $login_model
 * @property recruitment_model $recruitment_model
 * @property settings_model $settings_model
 * @property employee_model $employee_model
 * @property leave_model $leave_model
 * @property Organization_model $Organization_model
 * @method int affected_rows()
 */
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

    $job_id = $this->input->post('job_id', TRUE);
    $email = $this->input->post('email', TRUE);
    
    // This is the correct logic to check for an existing application.
    if ($this->recruitment_model->is_application_exists($job_id, $email)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'You have already applied for this job with this email address.'
        ]);
        return;
    }

    $appData = [
        'job_id'      => $job_id,
        'first_name'  => $this->input->post('first_name', TRUE),
        'last_name'   => $this->input->post('last_name', TRUE),
        'email'       => $email,
        'phone'       => $this->input->post('phone', TRUE),
        'status'      => 'Pending',
        'applied_at'  => date('Y-m-d H:i:s'),
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
        'message' => 'Your application has been submitted successfully!',
    ]);
}

    public function is_application_exists($job_id, $email)
    {
        $this->db->where('job_id', $job_id);
        $this->db->where('email', $email);
        $query = $this->db->get('applications'); // Replace 'applications' with your actual table name
        
        return $query->num_rows() > 0;
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

    /**
     * Get job by ID for editing
     */
    public function JobByID()
    {
        $this->output->set_content_type('application/json');
        
        if ($this->session->userdata('user_login_access') == FALSE) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            return;
        }

        $job_id = $this->input->get('id', TRUE);
        if (empty($job_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid job ID.']);
            return;
        }

        $job = $this->recruitment_model->get_job_by_id($job_id);
        if (empty($job)) {
            echo json_encode(['status' => 'error', 'message' => 'Job not found.']);
            return;
        }

        echo json_encode(['status' => 'success', 'job' => $job]);
    }

    /**
     * Update a job posting
     */
    public function update_job()
    {
        $this->output->set_content_type('application/json');

        if ($this->session->userdata('user_login_access') == FALSE) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            return;
        }

        $this->form_validation->set_rules('job_id', 'Job ID', 'trim|required|numeric');
        $this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Job Description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('requirements', 'Requirements', 'trim|required|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 'error', 'message' => strip_tags(validation_errors())]);
            return;
        }

        $job_id = $this->input->post('job_id', TRUE);
        $data = [
            'job_title'    => $this->input->post('job_title', TRUE),
            'description'  => $this->input->post('description', TRUE),
            'requirements' => $this->input->post('requirements', TRUE)
        ];

        try {
            $this->db->where('job_id', $job_id);
            $this->db->update('jobs', $data);
            $affected = (int)$this->db->affected_rows();

            if ($affected > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Job updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update job.']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error updating job: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Database error occurred.']);
        }
    }

    /**
     * Delete a job posting
     */
    public function delete_job()
    {
        $this->output->set_content_type('application/json');

        if ($this->session->userdata('user_login_access') == FALSE) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            return;
        }

        $job_id = $this->input->post('job_id', TRUE);
        if (empty($job_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid job ID.']);
            return;
        }

        try {
            $this->db->where('job_id', $job_id);
            $success = $this->db->delete('jobs');

            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Job deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete job.']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error deleting job: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Database error occurred.']);
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
        if ($this->session->userdata('user_login_access') != False) {
            $job_id = $this->input->get('job_id');
            $data['job_id'] = $job_id;
            $this->load->view('backend/applications_list', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function get_applications_data()
    {
        $this->output->set_content_type('application/json');

        if ($this->session->userdata('user_login_access') == FALSE) {
            $this->output->set_status_header(401);
            echo json_encode(['data' => []]);
            return;
        }

        $job_id = $this->input->get('job_id');
        
        // Get applications filtered by job_id if provided
        if ($job_id) {
            $applications = $this->recruitment_model->get_applications_by_job($job_id);
        } else {
            $applications = $this->recruitment_model->get_all_applications();
        }
        
        $data = [];
        foreach ($applications as $app) {
            $row = [
                'applicant_name' => html_escape($app['first_name'] . ' ' . $app['last_name']),
                'job_title'      => html_escape($app['job_title']),
                'email'          => html_escape($app['email']),
                'phone'          => html_escape($app['phone']),
                'applied_at'     => html_escape(date('F j, Y', strtotime($app['applied_at']))),
                'action'         => '<a href="' . site_url('recruitment/view_application/' . $app['id']) . '" class="btn btn-sm btn-info" title="View Details">View</a> ' .
                                    '<a href="' . site_url('recruitment/delete_application/' . $app['id']) . '" class="btn btn-sm btn-danger delete-application" title="Delete"><i class="fa fa-trash-o"></i></a>'
            ];
            $data[] = $row;
        }

    echo json_encode(['data' => $data]);
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

    /**
     * AJAX method to delete an application
     */
    public function delete_application_ajax()
    {
        $this->output->set_content_type('application/json');

        if ($this->session->userdata('user_login_access') == FALSE) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            return;
        }

        $app_id = $this->input->post('app_id', TRUE);
        
        if (empty($app_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid application ID.']);
            return;
        }

        try {
            $this->load->model('recruitment_model');
            $success = $this->recruitment_model->delete_application($app_id);
            
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Application deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete application or application not found.']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error deleting application: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Database error occurred.']);
        }
    }

    /**
     * Update application status
     */
    public function update_application_status()
    {
        $this->output->set_content_type('application/json');

        if ($this->session->userdata('user_login_access') == FALSE) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
            return;
        }

        $app_id = $this->input->post('app_id', TRUE);
        $status = $this->input->post('status', TRUE);

        if (empty($app_id) || empty($status)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
            return;
        }

        // Validate status values
        $valid_statuses = ['Pending', 'Reviewed', 'Interview', 'Offer', 'Hired', 'Rejected'];
        if (!in_array($status, $valid_statuses)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid status value.']);
            return;
        }

        try {
            // Check if application exists first
            $this->db->where('id', $app_id);
            $existing = $this->db->get('applications')->row_array();
            if (empty($existing)) {
                echo json_encode(['status' => 'error', 'message' => 'Application not found.']);
                return;
            }

            // Prepare update data
            $data = ['status' => $status];
            
            // Check if updated_at column exists before adding it
            $fields = $this->db->field_data('applications');
            $column_exists = false;
            foreach ($fields as $field) {
                if ($field->name === 'updated_at') {
                    $column_exists = true;
                    break;
                }
            }
            
            if ($column_exists) {
                $data['updated_at'] = date('Y-m-d H:i:s');
            }

            // Perform the update
            $this->db->where('id', $app_id);
            $this->db->update('applications', $data);
            
            $affected = (int)$this->db->affected_rows();
            
            if ($affected > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Application status updated successfully.']);
            } else {
                // Affected rows might be 0 if the value didn't actually change
                echo json_encode(['status' => 'success', 'message' => 'Application status updated successfully.']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error updating application status: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Database error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Download applicant resume
     */
    public function download_resume($app_id)
    {
        if ($this->session->userdata('user_login_access') == FALSE) {
            redirect(base_url(), 'refresh');
        }

        try {
            $this->load->model('recruitment_model');
            $application = $this->recruitment_model->get_application_by_id($app_id);

            if (empty($application)) {
                show_404();
                return;
            }

            // Build filename from applicant name
            $filename = 'Resume_' . str_replace(' ', '_', $application['first_name'] . '_' . $application['last_name']) . '.pdf';
            $filepath = './uploads/resumes/' . $filename;

            // Check if uploads/resumes directory exists, create if not
            if (!is_dir('./uploads/resumes/')) {
                @mkdir('./uploads/resumes/', 0755, true);
            }

            // Check if file exists
            if (!file_exists($filepath)) {
                log_message('warning', 'Resume file not found: ' . $filepath);
                $this->session->set_flashdata('error', 'Resume file not available for this applicant.');
                redirect('recruitment/view_application/' . $app_id);
                return;
            }

            // Force download
            $this->load->helper('download');
            force_download($filepath, NULL);
        } catch (Exception $e) {
            log_message('error', 'Error downloading resume: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while downloading the resume.');
            redirect('recruitment/view_application/' . $app_id);
        }
    }
}