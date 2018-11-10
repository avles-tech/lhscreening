<?php
class Patient_gad_model extends CI_Model {
        public function __construct()
        {
                $this->load->database();
        }
        public function get_patient_gad($patient_id)
        {
                $this->db->select('p.gad_id,l.question,p.value,p.id');
                $this->db->from('patient_gad p');
                $this->db->join('gad_list l', 'l.gad_id = p.gad_id', 'left');
                $this->db->where('p.patient_id', $patient_id);
                $query = $this->db->get(); 
                $result = $query->result_array();
                $count = count($result);
                if (empty($count)){
                        $query_gad_list = $this->db->get('gad_list');
                        $gad_list = $query_gad_list->result_array();
                        foreach($gad_list AS $item){
                                $data = array(
                                        'patient_id'=> $patient_id
                                        ,'gad_id' => $item['gad_id']
                                        , 'value' => '0'
                                );
                                $this->db->insert('patient_gad', $data);
                        }
                        $result = $query->row_array();
                }
                return $result;
        }
        public function set_patient_gad($patient_id,$form_data)
        {
            $this->load->helper('url');
            $query_gad_list = $this->db->get('gad_list');
            $gad_list = $query_gad_list->result_array();
            $query = $this->db->get_where('patient_gad', array('patient_id' => $patient_id));
            $patient_gad = $query->result_array();
            $count = count($patient_gad);
            if (empty($count)){
                echo 'something wrong';
                //return $this->db->insert('patient_gad', $data);
            }
            else{
                foreach($patient_gad AS $item){
                        $data = array(
                                'id' => $item['id']
                                , 'value' => $form_data[$item['id']]
                        );
                        $this->db->where('id' , $item['id']);
                        $this->db->update('patient_gad', $data);
                }
            }
            return true;
        }
}