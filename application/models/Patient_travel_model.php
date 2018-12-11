<?php
class Patient_travel_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get($patient_id)
        {
                $query = $this->db->get_where('patient_travel', array('patient_id' => $patient_id));
                return $query->row_array();
        }

        public function set($patient_id,$form_data)
        {
                $this->db->delete('patient_travel', array('patient_id' => $patient_id));
        }
}