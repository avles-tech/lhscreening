<?php
class Patients_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->library('ion_auth');
        }

        function search($query,$dob)
        {
                $this->db->select("*");
                $this->db->from("patients");
                if($query != '')
                {
                        $this->db->like('first_name', $query);
                        $this->db->or_like('last_name', $query);
                        $this->db->or_like('email', $query);
                        $this->db->or_like('phone_mobile', $query);
                        $this->db->or_like('DATE_FORMAT(dob, "%d/%m/%Y ")', $query);
                }
                if($dob != '')
                {
                        $this->db->where('dob', $dob);
                }
                $this->db->order_by('patient_id', 'DESC');
                $this->db->limit('10');
                return $this->db->get();
        }

        public function get_patients($patient_id = FALSE)
        {
                if ($patient_id === FALSE)
                {
                        $query = $this->db->get('patients');
                        return $query->result_array();
                }

                $query = $this->db->get_where('patients', array('patient_id' => $patient_id));
                return $query->row_array();
        }

        public function patient_exists($first_name,$last_name,$dob)
        {
                $query = $this->db->get_where('patients', array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'dob' => $dob
                ));
                $result = $query->result_array();
                $count = count($result);
                if (empty($count)){
                        return false;
                }
                else{
                        return true;
                }
        }

        public function occupations()
        {       
                $this->db->distinct('occupation');
                $this->db->select('occupation');
                $this->db->where('occupation is NOT NULL', NULL, FALSE);
                echo json_encode($this->db->get('patients')->result_array());
        }

        public function save_complete($patient_id)
        {
                $user = $this->ion_auth->user()->row(); 
                $this->db->where('patient_id', $patient_id);
                return $this->db->update('patients', array('save_exit'=>'1' , 'save_exist_user_id'=> $user->id));
        }

        public function set_patients()
        {
                $this->load->helper('url');

                $data = $this->input->post();
                if(!array_key_exists('allergy_milk',$data))
                        $data['allergy_milk'] = '0';
                if(!array_key_exists('allergy_eggs',$data))
                        $data['allergy_eggs'] = '0';
                if(!array_key_exists('allergy_peanuts',$data))
                        $data['allergy_peanuts'] = '0';
                if(!array_key_exists('allergy_shellfish',$data))
                        $data['allergy_shellfish'] = '0';
                if(!array_key_exists('allergy_iodine',$data))
                        $data['allergy_iodine'] = '0';
                if(!array_key_exists('allergy_pencillin',$data))
                        $data['allergy_pencillin'] = '0';
                if(!array_key_exists('allergy_treenuts',$data))
                        $data['allergy_treenuts'] = '0';

            $this->db->insert('patients', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }

        public function update_patients($patient_id,$form_data)
        {
                if(!array_key_exists('allergy_milk',$form_data))
                        $form_data['allergy_milk'] = '0';
                if(!array_key_exists('allergy_eggs',$form_data))
                        $form_data['allergy_eggs'] = '0';
                if(!array_key_exists('allergy_peanuts',$form_data))
                        $form_data['allergy_peanuts'] = '0';
                if(!array_key_exists('allergy_shellfish',$form_data))
                        $form_data['allergy_shellfish'] = '0';
                if(!array_key_exists('allergy_iodine',$form_data))
                        $form_data['allergy_iodine'] = '0';
                if(!array_key_exists('allergy_pencillin',$form_data))
                        $form_data['allergy_pencillin'] = '0';
                if(!array_key_exists('allergy_treenuts',$form_data))
                        $data['allergy_treenuts'] = '0';

                $this->db->where('patient_id', $patient_id);

                return $this->db->update('patients', $form_data);
        }
}