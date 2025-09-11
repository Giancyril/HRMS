<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goals extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        // Load all necessary models in the constructor for cleaner code
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('loan_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('goals_model');
        
        // Load other necessary libraries
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        // Check if the user is logged in
        if (!$this->session->userdata('user_login_access')) {
            redirect('login');
        }
        
        // Fetch goals and goal types to populate the main goals list view
        $data['goals'] = $this->goals_model->get_all_goals();
        $data['goal_types'] = $this->goals_model->get_all_goal_types();
        
        // Load the main goals list view
        $this->load->view('backend/goals_list', $data);
    }
    
    public function goals_type() {
    if (!$this->session->userdata('user_login_access')) {
        redirect('login');
    }

    $data['goal_types'] = $this->goals_model->get_all_goal_types();
    $this->load->view('backend/goals_type', $data);
}

    public function add_goal() {
    // Check if it's an AJAX request for proper JSON response handling
    if ($this->input->is_ajax_request()) {
        if ($this->input->post()) {
            $this->form_validation->set_rules('goal_type_id', 'Goal Type', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('target_achievement', 'Target Achievement', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == TRUE) {
                $goal_type_id = $this->input->post('goal_type_id');
                $subject = $this->input->post('subject');

                // Check for existing goal before insertion
                $existing_goal_count = $this->goals_model->get_goal_by_subject_and_type($subject, $goal_type_id);

                // Change: Check if the count of existing goals is greater than 0
                if ($existing_goal_count > 0) {
                    // Return an error if a duplicate is found
                    echo json_encode(['status' => 'error', 'message' => 'A goal with this subject already exists for this type.']);
                    return; // Crucially, stop execution here.
                }

                $goal_data = [
                    'goal_type_id' => $goal_type_id,
                    'subject' => $subject,
                    'target_achievement' => $this->input->post('target_achievement'),
                    'description' => $this->input->post('description'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'status' => $this->input->post('status'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Check if the insertion was successful
                $insert_id = $this->goals_model->add_goal($goal_data);
                if ($insert_id) {
                    // Return success JSON
                    echo json_encode(['status' => 'success', 'message' => 'Edit successfully!']);

                    echo "Successfully Added!";
                } else {
                    // Return error JSON for insertion failure
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add goal. Please try again.']);
                }
            } else {
                // Return validation errors as JSON
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            }
        } else {
            // Return error JSON for invalid request
            echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
        }
    } else {
        // Handle non-AJAX requests if necessary, or redirect
        // For now, return an error as the frontend expects JSON
        echo json_encode(['status' => 'error', 'message' => 'This endpoint only accepts AJAX requests.']);
    }
}
    
    public function update_goal() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('id', 'Goal ID', 'required');
            $this->form_validation->set_rules('goal_type_id', 'Goal Type', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('target_achievement', 'Target Achievement', 'required');

            if ($this->form_validation->run() == TRUE) {
                $goal_id = $this->input->post('id');
                $goal_data = [
                    'goal_type_id' => $this->input->post('goal_type_id'),
                    'subject' => $this->input->post('subject'),
                    'target_achievement' => $this->input->post('target_achievement'),
                    'description' => $this->input->post('description'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'status' => $this->input->post('status')
                ];
                
                // Check if the update was successful
                if ($this->goals_model->update_goal($goal_id, $goal_data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Edit Successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add goal type. Please try again.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
        }
    }

    

    public function get_goal_by_id($id) {
        $goal = $this->goals_model->get_goal_by_id($id);
        if ($goal) {
            echo json_encode($goal);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Goal not found.']);
        }
    }

    public function delete_goal($id) {
        $goal = $this->goals_model->get_goal_by_id($id);
        if ($goal) {
            $this->goals_model->delete_goal($id);
            $this->session->set_flashdata('success', 'Goal deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Goal not found.');
        }
        redirect('goals');
    }

    public function view($goal_id)
    {
        // Model is already loaded in the constructor, no need to load it again
        $data['goal_details'] = $this->goals_model->get_goal_by_id($goal_id);

        if (empty($data['goal_details'])) {
            show_404();
            return;
        }

        $this->load->view('backend/goal_details', $data);
    }
    
    // Add this new function to handle the form submission for adding a goal type
    public function save_goal_type() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('type_name', 'Goal Type Name', 'required');

            if ($this->form_validation->run() == TRUE) {
                $type_name = $this->input->post('type_name');

                // Check for existing goal type to prevent duplicates
                $existing_type = $this->goals_model->get_goal_type_by_name($type_name);
                if ($existing_type) {
                    echo json_encode(['status' => 'error', 'message' => 'This goal type already exists.']);
                    return;
                }

                $goal_type_data = [
                    'type_name' => $type_name
                ];

                if ($this->goals_model->add_goal_type($goal_type_data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Goal type added successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add goal type. Please try again.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
        }
    }

    public function update_goal_type() {
    if ($this->input->post()) {
        $this->form_validation->set_rules('id', 'Goal Type ID', 'required');
        $this->form_validation->set_rules('type_name', 'Goal Type Name', 'required');

        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('id');
            $type_name = $this->input->post('type_name');

            $goal_type_data = [
                'type_name' => $type_name
            ];

            if ($this->goals_model->update_goal_type($id, $goal_type_data)) {
                // Change: Echo a simple success string instead of JSON
                echo "Successfully Added!";
            } else {
                // Change: Echo a simple error string
                echo "Failed to update goal type. Please try again.";
            }
        } else {
            // Change: Echo validation errors directly
            echo validation_errors();
        }
    } else {
        // Change: Echo a simple error string
        echo "Invalid request.";
    }
}
    
    public function get_goal_type_by_id($id) {
        $goal_type = $this->goals_model->get_goal_type_by_id($id);
        if ($goal_type) {
            echo json_encode(['goaltypevalue' => $goal_type]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Goal type not found.']);
        }
    }
    
    public function delete_goal_type($id) {
        $goal_type = $this->goals_model->get_goal_type_by_id($id);
        if ($goal_type) {
            $this->goals_model->delete_goal_type($id);
            $this->session->set_flashdata('success', 'Goal type deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Goal type not found.');
        }
        redirect('goals/goals_type');
    }
}