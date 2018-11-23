<?php
class User_activity_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->library('ion_auth');
                $this->load->helper('date');
        }

        public function get($id = FALSE)
        {
                if ($id === FALSE)
                {
                        $query = $this->db->get('user_activities');
                        return $query->result_array();
                }

                $query = $this->db->get_where('user_activities', array('id' => $id));
                return $query->row_array();
        }

        public function set($activity)
        {
            $user = $this->ion_auth->user()->row(); 
            $data = array(
                'user_id'=>$user->id
                ,'activity'=>$activity
            );
            $this->db->insert('user_activities', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }

        function search($query)
        {
                $this->db->select("a.*,u.first_name");
                $this->db->from("user_activities a");
                $this->db->join('users u', 'a.user_id = u.id', 'left');
                if($query != '')
                {
                        $this->db->like('activity', $query);
                        $this->db->or_like('u.first_name', $query);
                }
                $this->db->limit('100');
                $this->db->order_by('date_time', 'DESC');
                return $this->db->get();
        }

}