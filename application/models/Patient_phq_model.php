<?php
class Patient_phq_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }


        public function get_patient_phq($patient_id)
        {
                $this->db->select('p.phq_id,l.question,p.value,p.id');
                $this->db->from('patient_phq p');
                $this->db->join('phq_list l', 'l.phq_id = p.phq_id', 'left');
                $this->db->where('p.patient_id', $patient_id);
                $query = $this->db->get(); 
                 
                $result = $query->result_array();

                $count = count($result);

                if (empty($count)){
                        $query_phq_list = $this->db->get('phq_list');
                        $phq_list = $query_phq_list->result_array();

                        foreach($phq_list AS $item){
                                $data = array(
                                        'patient_id'=> $patient_id
                                        ,'phq_id' => $item['phq_id']
                                        , 'value' => '0'
                                );
                                $this->db->insert('patient_phq', $data);
                        }
                        $result = $query->row_array();
                }

                return $result;
        }

        public function set_patient_phq($patient_id,$form_data)
        {
            $this->load->helper('url');
            
            $query_phq_list = $this->db->get('phq_list');
            $phq_list = $query_phq_list->result_array();

            $query = $this->db->get_where('patient_phq', array('patient_id' => $patient_id));
            $patient_phq = $query->result_array();
            $count = count($patient_phq);

            if (empty($count)){
                

                echo 'something wrong';
        

                //return $this->db->insert('patient_phq', $data);
            }
            else{
                foreach($patient_phq AS $item){
                        $data = array(
                                'id' => $item['id']
                                , 'value' => $form_data[$item['id']]
                        );
                        $this->db->where('id' , $item['id']);
                        $this->db->update('patient_phq', $data);
                }
            }

            return true;
        }
}