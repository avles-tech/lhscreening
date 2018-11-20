<?php
class Patient_gp_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get($patient_id = FALSE)
        {
                $query = $this->db->get_where('patient_gp', array('patient_id' => $patient_id));
                return $query->row_array();
        }

        public function set($patient_id,$form_data)
        {
                $this->load->helper('url');
    

                $query = $this->db->get_where('patient_gp', array('patient_id' => $patient_id));
                $patient_gp = $query->result_array();
                $count = count($patient_gp);

                if (empty($count)){
                        return $this->db->insert('patient_gp', $form_data);
                }
                else{
                        $data = array(
                                'blood_results' => $form_data['blood_results']
                                , 'mri_results' => $form_data['mri_results']
                                , 'ultra_sound' => $form_data['ultra_sound']
                                , 'overall_lifestyle' => $form_data['overall_lifestyle']
                                , 'additional_comments' => $form_data['additional_comments']
                        );

                        $this->db->where('patient_id' , $form_data['patient_id']);
                        return $this->db->update('patient_gp', $data);
                }

               
                
        }

}