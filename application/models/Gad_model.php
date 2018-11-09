<?php
class Gad_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_gad_list($id = FALSE)
        {
                if ($id === FALSE)
                {
                        $query = $this->db->get('gad_list');
                        return $query->result_array();
                }

                $query = $this->db->get_where('gad_list', array('id' => $id));
                return $query->row_array();
        }

}