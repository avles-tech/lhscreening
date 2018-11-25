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

        function search()
        {
                $search_text = $this->input->post('search_text');
                $from_date_time = $this->input->post('from_date_time');
                $to_date_time = $this->input->post('to_date_time');
                $search_by_user = $this->input->post('search_by_user');


                $this->db->select("a.*,u.first_name");
                $this->db->from("user_activities a");
                $this->db->join('users u', 'a.user_id = u.id', 'left');
                if($search_text != '')
                {
                        $this->db->like('activity', $search_text);
                }
                if($from_date_time != '')
                {
                        $this->db->where('date_time >=', $from_date_time);
                }

                if($to_date_time != '')
                {
                        $this->db->where('date_time <=', $to_date_time);
                }

                if($search_by_user != '')
                {
                        $this->db->where('u.first_name', $search_by_user);
                }

                $this->db->limit('100');
                $this->db->order_by('date_time', 'DESC');
                return $this->db->get();
        }

}