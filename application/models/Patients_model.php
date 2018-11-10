<?php
class Patients_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        function search($query)
        {
                $this->db->select("*");
                $this->db->from("patients");
                if($query != '')
                {
                        $this->db->like('first_name', $query);
                        $this->db->or_like('last_name', $query);
                        $this->db->or_like('email', $query);
                        $this->db->or_like('phone_mobile', $query);
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

        public function set_patients()
        {
            $this->load->helper('url');

            $data = array(
                    'first_name' => $this->input->post('first_name')
                    ,'last_name' => $this->input->post('last_name')
                    ,'email' => $this->input->post('email')
                    ,'dob' => $this->input->post('dob')
                    ,'gender' => $this->input->post('gender')
                    ,'address' => $this->input->post('address')
            );

            $this->db->insert('patients', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }

        public function update_patients($patient_id,$form_data)
        {
            $this->db->where('patient_id', $patient_id);

            return $this->db->update('patients', $form_data);
        }
}