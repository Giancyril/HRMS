<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_model extends CI_Model{

    function __construct(){
        parent::__construct();

    }

    public function depselect(){
        $query = $this->db->get('department');
        $result = $query->result();
        return $result;
    }

    public function Add_Department($data){
        $this->db->insert('department',$data);
    }

    public function department_delete($dep_id){
        $this->db->delete('department',array('id' => $dep_id ));
    }

    public function department_edit($dep){
        $sql    = "SELECT * FROM `department` WHERE `id`='$dep'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function Update_Department($id, $data){
        $this->db->where('id',$id);
        $this->db->update('department',$data);
    }

    public function Add_Designation($data){
        $this->db->insert('designation',$data);
    }

    public function designation_delete($des_id){
        $this->db->delete('designation',array('id'=> $des_id));
    }

    public function designation_edit($des){
        $sql    = "SELECT * FROM `designation` WHERE `id`='$des'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function Update_Designation($id, $data){
        $this->db->where('id',$id);
        $this->db->update('designation',$data);
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
}
?>