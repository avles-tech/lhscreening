<?php
class Phq_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_phq_list($id = FALSE)
        {
                if ($id === FALSE)
                {
                        $query = $this->db->get('phq_list');
                        return $query->result_array();
                }

                $query = $this->db->get_where('phq_list', array('id' => $id));
                return $query->row_array();
        }

}