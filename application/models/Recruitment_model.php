<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_jobs() {
        $this->db->select('jobs.*');
        $this->db->from('jobs');
        $this->db->where('jobs.is_active', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_job_by_id($job_id) {
        $this->db->where('job_id', $job_id);
        $query = $this->db->get('jobs');
        return $query->row_array();
    }

    public function save_applicant($data) {
        return $this->db->insert('applicants', $data);
    }

    public function get_all_applications() {
        $this->db->select('applications.*, jobs.job_title');
        $this->db->from('applications');
        $this->db->join('jobs', 'jobs.job_id = applications.job_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_application_by_id($id)
    {
        $this->db->select('applications.*, jobs.job_title');
        $this->db->from('applications');
        $this->db->where('applications.id', $id);
        $this->db->join('jobs', 'jobs.job_id = applications.job_id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function is_application_exists($job_id, $email)
    {
        $this->db->where('job_id', $job_id);
        $this->db->where('email', $email);
        $query = $this->db->get('applications'); // Use your actual applications table name
        
        return $query->num_rows() > 0;
    }

    public function delete_application($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('applications');
    }

    public function save_job($data) {
        return $this->db->insert('jobs', $data);
    }

    public function get_jobs_today() {
        $today = date('Y-m-d');
        $this->db->like('posted_at', $today);
        $query = $this->db->get('jobs');
        return $query->result_array(); 
    }
    
    public function getJobDetails($job_id)
    {
        // Corrected the column name from 'title' to 'job_title'
        $this->db->select('job_id AS job_id, job_title AS job_title, description AS job_description, requirements AS requirements, posted_at AS posted_at');
        $this->db->from('jobs');
        $this->db->where('job_id', $job_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return (object) array(); 
        }
    }

    public function add_application($data) {
        return $this->db->insert('applications', $data);
    }

    public function get_designations() {
        $this->db->select('id, des_name');
        $this->db->from('designation');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_applications_by_user($user_id)
{
    $this->db->select('applications.*, jobs.job_title');
    $this->db->from('applications');
    $this->db->join('jobs', 'jobs.job_id = applications.job_id', 'left');
    $this->db->where('applications.user_id', $user_id); // Make sure this column exists
    $query = $this->db->get();
    return $query->result_array();
}

}