<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Check database table structure
     */
    public function check_tables() {
        header('Content-Type: application/json');
        
        $tables_info = [];
        
        // Check employee table columns
        $employee_fields = $this->db->field_data('employee');
        $tables_info['employee_columns'] = array_map(function($field) {
            return $field->name;
        }, $employee_fields);
        
        // Check department table
        $dept_exists = $this->db->table_exists('department');
        $tables_info['department_exists'] = $dept_exists;
        if ($dept_exists) {
            $dept_fields = $this->db->field_data('department');
            $tables_info['department_columns'] = array_map(function($field) {
                return $field->name;
            }, $dept_fields);
        }
        
        // Check designation table
        $desig_exists = $this->db->table_exists('designation');
        $tables_info['designation_exists'] = $desig_exists;
        if ($desig_exists) {
            $desig_fields = $this->db->field_data('designation');
            $tables_info['designation_columns'] = array_map(function($field) {
                return $field->name;
            }, $desig_fields);
        }
        
        // Count active employees
        $active_count = $this->db->where('status', 'ACTIVE')->count_all_results('employee');
        $tables_info['active_employees'] = $active_count;
        
        echo json_encode($tables_info, JSON_PRETTY_PRINT);
    }

    /**
     * Test the search query
     */
    public function test_search($searchTerm = 'admin') {
        header('Content-Type: application/json');
        
        try {
            // Use same escaping/like strategy as global_search
            $rawSearch = $searchTerm;
            $searchTerm = $this->db->escape_like_str($rawSearch);

            $this->db->select('e.em_id, e.first_name, e.last_name, e.em_code, e.status, d.des_name, dp.dep_name, e.em_email');
            $this->db->from('employee e');
            $this->db->join('designation d', 'd.id = e.des_id', 'left');
            $this->db->join('department dp', 'dp.id = e.dep_id', 'left');

            $this->db->where('e.status', 'ACTIVE');
            $this->db->group_start();
                $this->db->like('e.first_name', $searchTerm, 'both');
                $this->db->or_like('e.last_name', $searchTerm, 'both');
                $this->db->or_like('e.em_code', $searchTerm, 'both');
                $this->db->or_like('e.em_email', $searchTerm, 'both');
                $this->db->or_like('d.des_name', $searchTerm, 'both');
                $this->db->or_like('dp.dep_name', $searchTerm, 'both');
            $this->db->group_end();
            
            $this->db->limit(10);
            $this->db->order_by('e.first_name', 'ASC');

            $query = $this->db->get();
            
            $debug_info = [
                'query' => $this->db->last_query(),
                'num_rows' => $query->num_rows(),
                'results' => $query->result_array()
            ];
            
            echo json_encode($debug_info, JSON_PRETTY_PRINT);

        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
