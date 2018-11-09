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
                }
                $this->db->order_by('id', 'DESC');
                $this->db->limit('10');
                return $this->db->get();
        }

        public function get_patients($id = FALSE)
        {
                if ($id === FALSE)
                {
                        $query = $this->db->get('patients');
                        return $query->result_array();
                }

                $query = $this->db->get_where('patients', array('id' => $id));
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

            return $this->db->insert('patients', $data);
        }

        public function update_patients($id,$form_data)
        {
            $this->db->where('id', $id);

            $this->db->update('patients', $form_data);
        }
}