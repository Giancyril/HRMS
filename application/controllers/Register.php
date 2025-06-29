<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load any helpers or models needed for registration here
        // Example: $this->load->helper('url'); // URL helper for base_url()
    }

    public function index()
    {
        // This line tells CodeIgniter to load your renamed view file.
        // Do NOT include the .php extension.
        $this->load->view('register_view'); // Use the new name of your file
    }

    // You can add more methods here to handle form submission,
    // send OTP, verify OTP, etc.
    public function process_signup()
    {
        // Logic to handle form submission (e.g., validate, save to DB, etc.)
        // You would get POST data here: $this->input->post('email');
    }
}
?>