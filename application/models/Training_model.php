<?php

class Training_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // -------------------- Training CRUD Operations --------------------

    public function add_training($data)
    {
        return $this->db->insert('trainings', $data);
    }

    public function get_all_trainings()
    {
        $sql = "SELECT t.*, tt.name AS training_type, tr.name AS trainer_name
                FROM trainings t
                LEFT JOIN training_types tt ON t.type_id = tt.id
                LEFT JOIN trainers tr ON t.trainer_id = tr.id
                ORDER BY t.id DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_training_by_id($id)
    {
        $sql = "SELECT t.*, tt.name AS training_type, tr.name AS trainer_name
                FROM trainings t
                LEFT JOIN training_types tt ON t.type_id = tt.id
                LEFT JOIN trainers tr ON t.trainer_id = tr.id
                WHERE t.id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }

    public function update_training($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('trainings', $data);
    }

    public function delete_training($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('trainings');
    }

    // -------------------- Training Type CRUD Operations --------------------

    public function add_training_type($data)
    {
        return $this->db->insert('training_types', $data);
    }

    public function get_all_training_types()
    {
        $query = $this->db->get('training_types');
        return $query->result();
    }

    public function delete_training_type($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('training_types');
    }

    // -------------------- Trainers CRUD Operations --------------------

    public function add_trainer($data)
    {
        return $this->db->insert('trainers', $data);
    }

    public function get_all_trainers()
    {
        $query = $this->db->get('trainers');
        return $query->result();
    }

    public function delete_trainer($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('trainers');
    }
}