<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pay_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_total_payslips() {
        return $this->db->count_all_results('pay_salary');
    }

    public function get_total_salary_expense() {
        $this->db->select_sum('net_salary'); // Assuming 'net_salary' is a column in your pay_salary table
        $query = $this->db->get('pay_salary');
        return $query->row()->net_salary ? $query->row()->net_salary : 0;
    }

    public function get_average_salary() {
        $this->db->select_avg('net_salary');
        $query = $this->db->get('pay_salary');
        return $query->row()->net_salary ? $query->row()->net_salary : 0;
    }

    public function get_highest_salary() {
        $this->db->select_max('net_salary');
        $query = $this->db->get('pay_salary');
        return $query->row()->net_salary ? $query->row()->net_salary : 0;
    }

    public function get_lowest_salary() {
        $this->db->select_min('net_salary');
        $query = $this->db->get('pay_salary');
        return $query->row()->net_salary ? $query->row()->net_salary : 0;
    }

    // Optional: Salary distribution by department
    public function get_salary_distribution_by_department() {
        $this->db->select('d.dep_name, AVG(ps.net_salary) AS average_salary');
        $this->db->from('pay_salary ps');
        $this->db->join('employee e', 'ps.employee_id = e.em_id'); // Adjust join based on your foreign key
        $this->db->join('department d', 'e.dep_id = d.id'); // Adjust join based on your foreign key
        $this->db->group_by('d.dep_name');
        $query = $this->db->get();
        return $query->result_array();
    }

    // ... other functions ...
}