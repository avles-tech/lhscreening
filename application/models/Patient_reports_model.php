<?php
class Patient_reports_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }


        public function get_patient_reports($patient_id = FALSE)
        {
                $query = $this->db->get_where('patient_reports', array('patient_id' => $patient_id));
                return $query->row_array();
        }

        public function set_patient_reports($path)
        {
            $this->load->helper('url');
            $patient_id = $this->input->post('patient_id');

            $query = $this->db->get_where('patient_reports', array('patient_id' => $patient_id));
            $result = $query->result_array();
            $count = count($result);

            if (empty($count)){
                $data = array(
                        'patient_id' => $this->input->post('patient_id')
                        ,$this->input->post('report') => $path
                );
                return $this->db->insert('patient_reports', $data);
            }
            else{
                $data = array(
                        'patient_id' => $this->input->post('patient_id')
                        ,$this->input->post('report') => $path
                );
                $this->db->where('patient_id', $patient_id);

                return $this->db->update('patient_reports', $data);
            }
        }

        public function del_patient_reports($patient_id = FALSE)
        {
                $this->db->where('patient_id' , $this->input->post('patient_id'));
                $query = $this->db->update('patient_reports', array($this->input->post('report') => ''));
        }
}