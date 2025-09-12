<?php

	class Payroll_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}
    public function Add_typeInfo($data){
        $this->db->insert('salary_type',$data);
    }
    public function insert_Salary_Pay($data){
        $this->db->insert('pay_salary',$data);
    }
    public function GetsalaryType(){
        $sql = "SELECT * FROM `salary_type` ORDER BY `salary_type` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;         
    }
    public function GetBankInfo($eid){
        $sql = "SELECT * FROM `bank_info` WHERE `em_id`='$eid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;         
    }
    public function GetDepEmployee($depid){
    $sql = "SELECT `employee`.*,
      `emp_salary`.`total`
      FROM `employee`
      LEFT JOIN `emp_salary` ON `employee`.`em_id`=`emp_salary`.`emp_id`
      WHERE `employee`.`dep_id`='$depid'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;         
    } 
    public function Get_typeValue($id){
        $sql = "SELECT * FROM `salary_type` WHERE `salary_type`.`id`= '$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;         
    } 
    public function GetLoanValueByID($id){
        $sql = "SELECT * FROM `loan` WHERE `loan`.`emp_id`= '$id' AND `status`='Granted' AND `status` != 'Done'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;         
    } 
    public function hasLoanOrNot($id){
        $sql = "SELECT * FROM `loan` WHERE `loan`.`emp_id`= '$id' AND `status`='Granted' AND `status` != 'Done'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result ? 1 : 0;    
    } 
    public function GetHolidayByYear($dateval){
        $sql = "SELECT * FROM `holiday` WHERE `holiday`.`year`= '$dateval'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;         
    } 
    public function GetloanInfo($emid){
        $sql = "SELECT * FROM `loan` WHERE `loan`.`emp_id`= '$emid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;         
    }
    public function Update_typeInfo($id,$data){
        $this->db->where('id', $id);
        $this->db->update('salary_type', $data);        
    }
    public function Update_SalaryPayInfo($id,$data){
        $this->db->where('pay_id', $id);
        $this->db->update('pay_salary', $data);        
    }
    public function Get_Salary_Value($id){
      $sql = "SELECT `emp_salary`.*,
      `addition`.*,
      `deduction`.*
      FROM `emp_salary`
      LEFT JOIN `addition` ON `emp_salary`.`id`=`addition`.`salary_id`
      LEFT JOIN `deduction` ON `emp_salary`.`id`=`deduction`.`salary_id`
      WHERE `emp_salary`.`emp_id`='$id'";
        $query=$this->db->query($sql);
		$result = $query->row();
		return $result;        
    }
    public function Get_Salarypay_Value($id){
      $sql = "SELECT `pay_salary`.*,
      `employee`.`em_id`,`first_name`,`last_name`,
      `salary_type`.*
      FROM `pay_salary`
      LEFT JOIN `employee` ON `pay_salary`.`emp_id`=`employee`.`em_id`
      LEFT JOIN `salary_type` ON `pay_salary`.`type_id`=`salary_type`.`id`
      WHERE `pay_salary`.`pay_id`='$id'";
        $query=$this->db->query($sql);
		$result = $query->row();
		return $result;        
    }
    public function getAllSalaryDataByMonthYearEm($eid,$month,$year){
      $sql = "SELECT `pay_salary`.*,
      `employee`.`em_id`,`first_name`,`last_name`,
      `salary_type`.*
      FROM `pay_salary`
      LEFT JOIN `employee` ON `pay_salary`.`emp_id`=`employee`.`em_id`
      LEFT JOIN `salary_type` ON `pay_salary`.`type_id`=`salary_type`.`id`
      WHERE `pay_salary`.`emp_id`='$eid' AND `pay_salary`.`month`='$month' AND `pay_salary`.`year`='$year'";
        $query=$this->db->query($sql);
		$result = $query->row();
		return $result;        
    }
    public function GetsalaryValueEm() {
      $sql = "SELECT `emp_salary`.*,
      `addition`.*,
      `deduction`.*,
      `salary_type`.`salary_type`,
      `employee`.`first_name`,`last_name`,`em_id`
      FROM `emp_salary`
      LEFT JOIN `salary_type` ON `emp_salary`.`type_id`=`salary_type`.`id`
      LEFT JOIN `addition` ON `emp_salary`.`id`=`addition`.`salary_id`
      LEFT JOIN `deduction` ON `emp_salary`.`id`=`deduction`.`salary_id`
      LEFT JOIN `employee` ON `emp_salary`.`emp_id`=`employee`.`em_id`
      ORDER BY `emp_salary`.`id` DESC";
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result;        
    }
    public function GetAllSalary(){
      $sql = "SELECT `pay_salary`.*,
      `employee`.`first_name`,`last_name`,`em_code`,
      `salary_type`.`salary_type`
      FROM `pay_salary`
      LEFT JOIN `employee` ON `pay_salary`.`emp_id`=`employee`.`em_id`
      LEFT JOIN `salary_type` ON `pay_salary`.`type_id`=`salary_type`.`id`
      ORDER BY `pay_salary`.`pay_id` DESC";
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result;        
    }



/*Invoice Start*/
    public function getAllSalaryID($id){
      $sql = "SELECT *
              FROM `pay_salary` WHERE `emp_id` = '$id'";
      $query=$this->db->query($sql);
      $result = $query->row();
      return $result;        
    }


    public function getEmployeeID($id){
      $sql = "SELECT `employee`.*,
      `designation`.*,
      `department`.*
      FROM `employee`
      LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
      LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
      WHERE `em_id`='$id'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;         
    }
    public function Get_SalaryID($id){
      $sql = "SELECT `emp_salary`.*,
      `addition`.*,
      `deduction`.*
      FROM `emp_salary`
      LEFT JOIN `addition` ON `emp_salary`.`id`=`addition`.`salary_id`
      LEFT JOIN `deduction` ON `emp_salary`.`id`=`deduction`.`salary_id`
      WHERE `emp_salary`.`emp_id`='$id'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;        
    }

/*Invoice End*/   


    public function getAllSalaryData(){
      $sql = "SELECT `pay_salary`.*,
              `employee`.`first_name`,`last_name`,`em_code`
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`emp_id`=`employee`.`em_id`
              ORDER BY `pay_salary`.`month` DESC";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }
    
    

    public function getAllSalaryDataById($id){
      $sql = "SELECT `pay_salary`.*,
              `employee`.`first_name`,`last_name`,`em_code`
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`emp_id`=`employee`.`em_id`
              WHERE `pay_salary`.pay_id = '$id'";
      $query = $this->db->query($sql);
      $result = $query->row();
      return $result;
    }
    
    public function getAdditionDataBySalaryID($salaryID) {
      $sql = "SELECT `addition`.*
              FROM `addition`
              WHERE `addition`.salary_id = '$salaryID'";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }

    public function getDiductionDataBySalaryID($salaryID) {
      $sql = "SELECT `deduction`.*
              FROM `deduction`
              WHERE `deduction`.salary_id = '$salaryID'";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }

    public function GetsalaryValueByID($id){
      $sql = "SELECT `emp_salary`.*
      FROM `emp_salary`
      WHERE `emp_salary`.`emp_id`='$id'";
      $query=$this->db->query($sql);
      $result = $query->row();
      return $result;        
    }     
    public function getNumberOfHolidays($month, $year){
      $sql = "SELECT SUM(`number_of_days`) AS total_days
      FROM `holiday`
      WHERE MONTH(`from_date`)='$month' AND YEAR(`from_date`)='$year'";
      $query=$this->db->query($sql);
	    $result = $query->row();
	    return $result;        
    }
public function getPinFromID($employeeID){
      $sql = "SELECT `em_code`
      FROM `employee`
      WHERE `em_id` = '$employeeID'";
      $query=$this->db->query($sql);
	    $result = $query->row();
	    return $result;        
    }

      public function totalHoursWorkedByEmployeeInAMonth($employeePIN, $start_date, $end_date)
    {
      $sql = "SELECT TRUNCATE((SUM(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )))/3600), 1) AS Hours FROM `attendance` WHERE (`attendance`.`emp_id`='$employeePIN') AND (`atten_date` BETWEEN '$start_date' AND '$end_date')";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function insertPaidSalaryData($data){
        $result = $this->db->insert('pay_salary',$data);
        return $result;
    }

    public function updatePaidSalaryData($id, $data){
        $this->db->where('pay_id', $id);
        $result = $this->db->update('pay_salary', $data);
        return $result;
    }
    public function getSalaryRecord($emid, $month,$year){
      $sql = "SELECT `pay_salary`.*
              FROM `pay_salary`
              WHERE `emp_id`='$emid' AND `month`='$month' AND `year`='$year'";
      $query=$this->db->query($sql);
      $result = $query->result();
      return $result;        
    } 

    public function getOtherInfo($emid) {
      $sql = "SELECT `employee`.*,
              (SELECT `des_name` FROM `designation` WHERE `employee`.`des_id` = `designation`.`id`) AS name, 
              (SELECT `dep_name` FROM `department` WHERE `employee`.`dep_id` = `department`.`id`) AS dep_name, `emp_salary`.`total`, `bank_info`.*, `addition`.*, `deduction`.*, 
              (SELECT TRUNCATE((SUM(ABS(( TIME_TO_SEC( TIMEDIFF( `signin_time`, `signout_time` ) ) )))/3600), 1) AS Hours FROM `attendance` WHERE (`attendance`.`emp_id`='$emid') AND (DATE_FORMAT(`attendance`.`atten_date`, '%m'))=MONTH(CURRENT_DATE())) AS hours_worked,COUNT(*) AS days FROM `employee`
              LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id` 
              LEFT JOIN `addition` ON `employee`.`em_id`=`addition`.`salary_id` 
              LEFT JOIN `deduction` ON `employee`.`em_id`=`deduction`.`salary_id` 
              LEFT JOIN `bank_info` ON `employee`.`em_id`=`bank_info`.`em_id` 
              LEFT JOIN `emp_salary` ON `employee`.`em_id`=`emp_salary`.`emp_id` WHERE `employee`.`em_id`='$emid'";
      $query=$this->db->query($sql);
      $result = $query->result();
      return $result;
    }   

    // In Leads model

public function GetProjectsWithTeamHeads() {
    // Assuming you have 'projects' and 'employees' tables
    // And a column in 'projects' table like 'team_head_id' that references employees.id
    // And a table like 'project_assignments' linking employees to projects (for assigned employees)

    $this->db->select('p.*, th.name as team_head_name, th.email as team_head_email, th.phone as team_head_phone');
    $this->db->from('projects p');
    $this->db->join('employees th', 'p.team_head_id = th.id', 'left'); // Adjust table and column names
    // You might need another join for assigned employees if not directly on the project table
    // $this->db->join('project_assignments pa', 'p.id = pa.project_id', 'left');
    // $this->db->join('employees assigned_emp', 'pa.employee_id = assigned_emp.id', 'left');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $projects_data = $query->result();
        // If you need to group assigned employees per project, you'll need additional processing here.
        // For now, this example assumes direct team head info is sufficient or can be fetched separately.
        return $projects_data;
    } else {
        return [];
    }
}

// A more complex example that tries to get assigned employees too
public function GetProjectsWithDetails() {
    $this->db->select('p.*, th.name as team_head_name, th.email as team_head_email, th.phone as team_head_phone');
    $this->db->from('projects p');
    $this->db->join('employees th', 'p.team_head_id = th.id', 'left');
    $query = $this->db->get();
    $projects = $query->result();

    $results = [];
    if (!empty($projects)) {
        foreach ($projects as $project) {
            // Get assigned employees for this project
            $this->db->select('e.name');
            $this->db->from('project_assignments pa'); // Your assignment table
            $this->db->join('employees e', 'pa.employee_id = e.id');
            $this->db->where('pa.project_id', $project->id); // Assuming 'id' is the primary key for projects
            $assigned_query = $this->db->get();
            $project->assigned_employees = $assigned_query->result();

            // Map team head details from the join
            $project->team_head = (object) [
                'name' => $project->team_head_name,
                'email' => $project->team_head_email,
                'phone' => $project->team_head_phone
            ];

            $results[] = $project;
        }
    }
    return $results;
}
}