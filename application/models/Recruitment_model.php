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

    public function get_all_applicants() {
        $this->db->select('applicants.*, jobs.title as job_title');
        $this->db->from('applicants');
        $this->db->join('jobs', 'jobs.job_id = applicants.job_id');
        $this->db->order_by('applied_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // New method to save a new job posting
    public function save_job($data) {
        return $this->db->insert('jobs', $data);
    }

    // Corrected method to return an array of arrays
    public function get_jobs_today() {
        $today = date('Y-m-d');
        $this->db->like('posted_at', $today);
        $query = $this->db->get('jobs');
        // Change result() to result_array() for consistency
        return $query->result_array(); 
    }
    
}