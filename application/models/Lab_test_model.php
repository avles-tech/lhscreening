<?php
class Lab_test_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_lab_test_list($id = FALSE)
        {
                if ($id === FALSE)
                {
                        $query = $this->db->get('lab_test_list');
                        return $query->result_array();
                }

                $query = $this->db->get_where('lab_test_list', array('id' => $id));
                return $query->row_array();
        }

}