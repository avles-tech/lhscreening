<?php
class Patient_medical_history_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get($patient_id)
        {
                $query = $this->db->get_where('patient_medical_history', array('patient_id' => $patient_id));
                return $query->row_array();
        }

        public function set($patient_id,$form_data)
        {
                $this->load->helper('url');

                $travel = $form_data['travel'];

                unset($form_data['travel']);;

                $query = $this->db->get_where('patient_medical_history', array('patient_id' => $patient_id));
                $patient_gp = $query->result_array();
                $count = count($patient_gp);

                if (empty($count)){
                        return $this->db->insert('patient_medical_history', $form_data);
                }
                else{
                        
                        $this->db->delete('patient_travel', array('patient_id' => $patient_id));
                        foreach ($travel as $value):
                                //$value['patient_id'] = $patient_id;
                                echo $travel['travel_destination'];
                                //$this->db->insert('patient_travel', $value);
                        endforeach;

                        $this->db->where('patient_id' , $patient_id);
                        return $this->db->update('patient_medical_history', $form_data);
                }
        }
}