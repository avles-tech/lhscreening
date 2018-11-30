<?php
class Useractivity extends CI_Controller {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->model('user_activity_model');
        }
        
        public function set_activity(){
            $activity = $this->input->post('activity');
            $this->user_activity_model->set($activity);
        }

        public function get_users(){
                echo json_encode($this->ion_auth->users()->result()) ;
        }

        function search()
        {
                $output = '';
      
                $data = $this->user_activity_model->search();

                $output .= '
                <div class="table-responsive">
                <table class="table table-bordered ">
                <tr>
                <th>ID</th>
                <th>User</th>
                <th>Activity</th>
                <th>Datetime</th>
                </tr>
                ';
                if($data->num_rows() > 0)
                {
                        foreach($data->result() as $row)
                        {       
                                $date_time = new DateTime($row->date_time);
                                $output .= '
                                <tr>
                                <td>'.$row->id.'</td>
                                <td>'.$row->first_name.'</td>
                                <td>'.$row->activity.'</td>
                                <td>'.date_format($date_time,'d-m-Y g:i A').'</td>
                                </tr>
                                ';
                        }
                }
                else
                {
                        $output .= '<tr>
                        <td colspan="5">No Data Found</td>
                        </tr>';
                }
                $output .= '</table>';

                echo $output;
        }

        public function view(){
            $this->load->view('templates/header');
            $this->load->view('useractivity/view');
            $this->load->view('templates/footer');
        }

}