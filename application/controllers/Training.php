<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('training_model');
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('project_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('logistic_model');
        $this->load->model('attendance_model');
    }

    // -------------------- Training Module --------------------

    public function index()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['trainings'] = $this->training_model->get_all_trainings();
            $this->load->view('backend/training', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function add_training()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data = array(
                'type_id' => $this->input->post('type_id'),
                'trainer_id' => $this->input->post('trainer_id'),
                'employee' => $this->input->post('employee'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'status' => $this->input->post('status'),
            );
            $this->training_model->add_training($data);
            redirect('Training');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function edit_training($id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['training'] = $this->training_model->get_training_by_id($id);
            $data['training_types'] = $this->training_model->get_all_training_types();
            $data['trainers'] = $this->training_model->get_all_trainers();
            $this->load->view('backend/edit_training', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function update_training()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');
            $data = array(
                'type_id' => $this->input->post('type_id'),
                'trainer_id' => $this->input->post('trainer_id'),
                'employee' => $this->input->post('employee'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'status' => $this->input->post('status'),
            );
            $this->training_model->update_training($id, $data);
            redirect('Training');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function delete_training($id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->training_model->delete_training($id);
            redirect('Training');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    // -------------------- Training Type Module --------------------

    public function training_types()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['training_types'] = $this->training_model->get_all_training_types();
            $this->load->view('backend/training_type', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function add_training_type()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            );
            $this->training_model->add_training_type($data);
            redirect('Training/training_types');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function delete_training_type($id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->training_model->delete_training_type($id);
            redirect('Training/training_types');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    // -------------------- Trainers Module --------------------

    public function trainers()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['trainers'] = $this->training_model->get_all_trainers();
            $this->load->view('backend/trainers', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function add_trainer()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data = array(
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
                'description' => $this->input->post('description'),
                'status' => $this->input->post('status'),
            );
            $this->training_model->add_trainer($data);
            redirect('Training/trainers');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function delete_trainer($id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->training_model->delete_trainer($id);
            redirect('Training/trainers');
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}