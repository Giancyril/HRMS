<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_model extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->database(); // Ensure database is loaded in the constructor
    }

    public function depselect(){
        $query = $this->db->get('department');
        $result = $query->result();
        return $result;
    }

    public function Add_Department($data){
        $this->db->insert('department',$data);
        return $this->db->insert_id(); // Return the ID of the newly inserted row
    }

    public function department_delete($dep_id){
        $this->db->delete('department',array('id' => $dep_id ));
        return $this->db->affected_rows() > 0; // Return true if row was affected
    }

    public function department_edit($dep){
        // Using Active Record for consistency and better readability
        $this->db->where('id', $dep);
        $query = $this->db->get('department');
        $result = $query->row();
        return $result;
    }

    public function Update_Department($id, $data){
        $this->db->where('id',$id);
        $this->db->update('department',$data);
        return $this->db->affected_rows() > 0; // Return true if row was affected
    }

    public function Add_Designation($data){
        $this->db->insert('designation',$data);
        return $this->db->insert_id(); // Return the ID of the newly inserted row
    }

    public function designation_delete($des_id){
        $this->db->delete('designation',array('id'=> $des_id));
        return $this->db->affected_rows() > 0; // Return true if row was affected
    }

    public function designation_edit($des){
        // Using Active Record for consistency
        $this->db->where('id', $des);
        $query = $this->db->get('designation');
        $result = $query->row(); // Returns an object, which json_encode handles well
        return $result;
    }

    // Renamed to avoid confusion with designation_edit if both are intended for similar purpose.
    // This method is identical to designation_edit and getDesignationById.
    // Keeping it as getDesignationById for clarity based on previous discussion,
    // and removing the duplicate Update_Designation.
    public function getDesignationById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('designation'); // Assuming 'designation' is your table name
        if ($query->num_rows() > 0) {
            return $query->row(); // Return a single row object
        }
        return false;
    }

    public function Update_Designation($id, $data){
        $this->db->where('id', $id);
        $this->db->update('designation', $data); // Assuming 'designation' is your table name
        return $this->db->affected_rows() > 0; // Return true if row was affected
    }


    public function desselect(){
        $query = $this->db->get('designation');
        $result = $query->result();
        return $result;
    }

    // --- New functions for charts ---

    /**
     * Fetches the count of employees per department.
     * Assumes 'employee' table has 'dep_id' and 'department' table has 'id' and 'dep_name'.
     *
     * @return array An array of objects with 'department_name' and 'employee_count'.
     */
    public function getDepartmentsWithEmployeeCount() {
        $this->db->select('d.dep_name as department_name, COUNT(e.id) as employee_count');
        $this->db->from('department d');
        $this->db->join('employee e', 'd.id = e.dep_id', 'left'); // Assuming 'dep_id' in employee table
        $this->db->group_by('d.dep_name');
        $this->db->order_by('d.dep_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * Fetches the count of employees per designation.
     * Assumes 'employee' table has 'des_id' and 'designation' table has 'id' and 'des_name'.
     *
     * @return array An array of objects with 'designation_name' and 'employee_count'.
     */
    public function getDesignationsWithEmployeeCount() {
        $this->db->select('des.des_name as designation_name, COUNT(e.id) as employee_count');
        $this->db->from('designation des');
        $this->db->join('employee e', 'des.id = e.des_id', 'left'); // Assuming 'des_id' in employee table
        $this->db->group_by('des.des_name');
        $this->db->order_by('des.des_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_designations() {
    $this->db->order_by('des_name', 'ASC');
    $query = $this->db->get('designation');
    return $query->result();
}

//promotion related functions

public function get_all_employees() {
    $this->db->select('id, first_name, last_name, des_id');
    $this->db->from('employee');
    $query = $this->db->get();
    return $query->result(); // Change from result_array() to result()
}

public function get_designations() {
    $this->db->select('*');
    $this->db->from('designation');
    $query = $this->db->get();
    // Change this line:
    // return $query->result_array();
    // To this:
    return $query->result(); 
}

public function get_designation_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('designation');
        return $query->row_array();
    }

public function get_employee_by_id($em_id) {
    $this->db->select('*');
    $this->db->from('employee');
    $this->db->where('id', $em_id);
    $query = $this->db->get();
    return $query->row_array();
}

public function update_employee_designation($em_id, $new_des_id) {
    $this->db->where('id', $em_id);
    $this->db->update('employee', ['des_id' => $new_des_id]);
}
}
?>