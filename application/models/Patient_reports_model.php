<?php
class Patient_reports_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }


        public function get_patient_reports($id = FALSE)
        {
                $query = $this->db->get_where('patient_reports', array('id' => $id));
                return $query->row_array();
        }

        public function set_patient_reports($path)
        {
            $this->load->helper('url');
            $id = $this->input->post('id');

            $query = $this->db->get_where('patient_reports', array('id' => $id));
            $result = $query->result_array();
            $count = count($result);

            if (empty($count)){
                $data = array(
                        'id' => $this->input->post('id')
                        ,$this->input->post('report') => $path
                );
                return $this->db->insert('patient_reports', $data);
            }
            else{
                $data = array(
                        'id' => $this->input->post('id')
                        ,$this->input->post('report') => $path
                );
                $this->db->where('id', $id);

                return $this->db->update('patient_reports', $data);
            }
        }
}