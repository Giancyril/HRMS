 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model');
        $this->load->model('settings_model');    
        $this->load->model('notice_model');    
        $this->load->model('project_model');    
        $this->load->model('organization_model');
        $this->load->model('leave_model');    
        $this->load->model('Recruitment_model');

    }
    
	public function index()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
            $data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
			$this->load->view('login');
	}
       function Dashboard(){
        if($this->session->userdata('user_login_access') != False) {
            // Call the correct method to get jobs from today
            $data['jobs'] = $this->Recruitment_model->get_jobs_today(); 
            
            // Pass the data to the dashboard view
            $this->load->view('backend/dashboard', $data);
        }
        else{
            redirect(base_url() , 'refresh');
        }               
    }
    public function add_todo(){
        $userid = $this->input->post('userid');
        $tododata = $this->input->post('todo_data');
        $date = date("Y-m-d h:i:sa");
        $this->load->library('form_validation');
        //validating to do list data
        $this->form_validation->set_rules('todo_data', 'To-do Data', 'trim|required|min_length[5]|max_length[150]|xss_clean');        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        } else {
        $data=array();
        $data = array(
        'user_id' => $userid,
        'to_dodata' =>$tododata,
        'value' =>'1',
        'date' =>$date    
        );
        $success = $this->dashboard_model->insert_tododata($data);
            #echo "successfully added";
            if($this->db->affected_rows()){
                echo "Successfully Added";
            } else {
                echo "validation Error";
            }
        }        
    }
	public function Update_Todo(){
        $id = $this->input->post('toid');
		$value = $this->input->post('tovalue');
			$data = array();
			$data = array(
				'value'=> $value
			);
        $update= $this->dashboard_model->UpdateTododata($id,$data);
        $inserted = $this->db->affected_rows();
		if($inserted){
			$message="Successfully Added";
			echo $message;
		} else {
			$message="Something went wrong";
			echo $message;			
		}
	}    
    public function getDepartmentChartData() {
        if ($this->session->userdata('user_login_access') != False) {
            $data = $this->organization_model->getDepartmentsWithEmployeeCount();
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($data));
        } else {
            redirect(base_url() , 'refresh');
        }
    }

    /**
     * Fetches designation data with employee counts for chart display.
     * Returns JSON data.
     */
    public function getDesignationChartData() {
        if ($this->session->userdata('user_login_access') != False) {
            $data = $this->organization_model->getDesignationsWithEmployeeCount();
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($data));
        } else {
            redirect(base_url() , 'refresh');
        }
    }
    // New method for Privacy Policy
    public function privacy_policy() {
        $this->load->view('backend/privacy_policy'); // Loads the new view file
    }
    public function analytics_view() {
        $this->load->view('backend/analytics_view'); // Loads the new view file
    }
        // In your Dashboard.php controller
    
}