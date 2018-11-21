<?php
class Patient_lab_test_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_lab_test_categories()
        {
                $this->db->distinct();

                $this->db->select('category');
                $this->db->group_by("category");

                $query = $this->db->get('lab_test_list');

                //$query = $this->db->get('lab_test_list');

                return $query->result_array();
        }

        public function get_patient_lab_test($patient_id)
        {
                $this->db->select('p.id,p.test_id,l.test_name,p.value,l.category,l.unit');
                $this->db->from('patient_lab_test p');
                $this->db->join('lab_test_list l', 'l.test_id = p.test_id', 'left');
                $this->db->where('p.patient_id', $patient_id);
                $query = $this->db->get(); 
                 
                $result = $query->result_array();

                $count = count($result);

                if (empty($count)){
                        $query_lab_test_list = $this->db->get('lab_test_list');
                        $lab_test_list = $query_lab_test_list->result_array();

                        foreach($lab_test_list AS $item){
                                $data = array(
                                        'patient_id'=> $patient_id
                                        ,'test_id' => $item['test_id']
                                        , 'value' => ''
                                );
                                $this->db->insert('patient_lab_test', $data);
                        }
                        $result = $query->row_array();
                }

                return $result;
        }

        public function set_patient_lab_test($patient_id,$form_data)
        {
            $this->load->helper('url');
            
            $query_lab_test_list = $this->db->get('lab_test_list');
            $lab_test_list = $query_lab_test_list->result_array();

            $query = $this->db->get_where('patient_lab_test', array('patient_id' => $patient_id));
            $patient_lab_test = $query->result_array();
            $count = count($patient_lab_test);

            if (empty($count)){
                echo 'something wrong';
            }
            else{
                foreach($patient_lab_test AS $item){
                        $data = array(
                                'id' => $item['id']
                                , 'value' => $form_data[$item['id']]
                        );
                        $this->db->where('id' , $item['id']);
                        $this->db->update('patient_lab_test', $data);
                }
            }

            return true;
        }
}