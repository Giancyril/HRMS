<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_jobs() {
        $this->db->where('is_active', 1);
        $query = $this->db->get('jobs');
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

    public function get_all_applications()
{
    $this->db->select('applications.id, applications.first_name, applications.last_name, applications.email, applications.phone, applications.applied_at, jobs.title as job_title');
    $this->db->from('applications');
    $this->db->join('jobs', 'applications.job_id = jobs.job_id');
    $query = $this->db->get();
    return $query->result_array();
}

public function get_application_by_id($id)
{
    $this->db->where('id', $id);
    $query = $this->db->get('applications');
    return $query->row_array();
}

// In your Recruitment_model.php model
// In your Recruitment_model.php model
public function delete_application($id)
{
    // Where clause to specify the record to delete
    $this->db->where('id', $id);
    
    // Perform the delete operation on the 'applications' table
    return $this->db->delete('applications');
}

    // New methods added here, inside the class
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
        $this->db->select('job_id AS job_id, title AS job_title, description AS job_description, requirements AS requirements, posted_at AS posted_at');
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

    
    
} 