<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goals_model extends CI_Model {

    // Get all goals with their corresponding goal type name
    public function get_all_goals() {
        $this->db->select('goals.*, goal_types.type_name');
        $this->db->from('goals');
        $this->db->join('goal_types', 'goal_types.id = goals.goal_type_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    // Get a single goal by its ID
    public function get_goal_by_id($id) {
        $this->db->select('goals.*, goal_types.type_name');
        $this->db->from('goals');
        $this->db->join('goal_types', 'goal_types.id = goals.goal_type_id', 'left');
        $this->db->where('goals.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    // Add a new goal
    public function add_goal($data) {
        return $this->db->insert('goals', $data);
    }
    
    // Update an existing goal
    public function update_goal($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('goals', $data);
    }

    // Delete a goal
    public function delete_goal($id) {
        $this->db->where('id', $id);
        return $this->db->delete('goals');
    }

    // Get all goal types
    public function get_all_goal_types() {
        $query = $this->db->get('goal_types');
        return $query->result();
    }
    
    // Add a new goal type
    public function add_goal_type($data) {
        return $this->db->insert('goal_types', $data);
    }
    
    // Get a single goal type by its ID
    public function get_goal_type_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('goal_types');
        return $query->row();
    }

    public function get_goal_type_by_name($type_name) {
      $this->db->where('type_name', $type_name);
      $query = $this->db->get('goal_types'); // Replace 'goal_types' with your actual table name
    
    // Return the number of rows to check for existence
     return $query->num_rows();
    }
    
    // Update a goal type
    public function update_goal_type($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('goal_types', $data);
    }
    
    // Delete a goal type
    public function delete_goal_type($id) {
        $this->db->where('id', $id);
        return $this->db->delete('goal_types');
    }

    // Check for existing goal by subject and type
    // In your Goals_model.php

public function get_goal_by_subject_and_type($subject, $goal_type_id) {
    $this->db->where('subject', $subject);
    $this->db->where('goal_type_id', $goal_type_id);
    $query = $this->db->get('goals'); // Replace 'goals' with your actual table name

    // Change: Return the number of rows found.
    return $query->num_rows(); 
}
}