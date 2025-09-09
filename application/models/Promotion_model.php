<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_promotions() {
        $this->db->select('promotions.*, e.first_name, e.last_name, old_des.des_name AS old_des_name, new_des.des_name AS new_des_name, d.dep_name');
        $this->db->from('promotions');
        $this->db->join('employee as e', 'e.id = promotions.em_id');
        $this->db->join('designation as old_des', 'old_des.id = promotions.old_des_id');
        $this->db->join('designation as new_des', 'new_des.id = promotions.new_des_id');
        $this->db->join('department as d', 'd.id = e.dep_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_promotion($data) {
        $this->db->insert('promotions', $data);
        return $this->db->insert_id();
    }

    public function update_employee_designation($em_id, $new_des_id) {
        $this->db->where('id', $em_id);
        $this->db->update('employee', ['des_id' => $new_des_id]);
    }

    public function get_promotion_by_id($id) {
        $this->db->where('promotion_id', $id);
        $query = $this->db->get('promotions');
        return $query->row_array();
    }

    public function delete_promotion($id) {
        $this->db->where('promotion_id', $id);
        $this->db->delete('promotions');
        return $this->db->affected_rows();
    }
}