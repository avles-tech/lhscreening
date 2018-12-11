<?php
class Patient_travel_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get($patient_id)
        {
                $query = $this->db->get_where('patient_travel', array('patient_id' => $patient_id));
                return $query->result_array();
        }

}