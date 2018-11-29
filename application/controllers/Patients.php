<?php
class Patients extends CI_Controller {
        public function __construct()
        {
                parent::__construct();
                
                $this->load->model('patients_model');
                $this->load->model('patient_reports_model');
                $this->load->model('phq_model');
                $this->load->model('patient_phq_model');
                $this->load->model('patient_gad_model');
                $this->load->model('patient_lab_test_model');
                $this->load->model('user_activity_model');
                $this->load->model('patient_medical_history_model');
                $this->load->model('patient_gp_model');

                $this->load->model('gad_model');
                $this->load->helper('url_helper');
                $this->load->library('ion_auth');
                $this->load->library('Tcpdflib');
                $this->load->library('Fpdilib');
        }
        function search()
        {
                $output = '';
                $query = '';
                if($this->input->post('query'))
                {
                        $query = $this->input->post('query');
                }
                $dob = $this->input->post('dob');
                $data = $this->patients_model->search($query,$dob);
                $output .= '
                <div class="table-responsive">
                <table class="table table-bordered ">
                <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Phone Mobile</th>
                <th></th>
                </tr>
                ';
                if($data->num_rows() > 0)
                {
                        foreach($data->result() as $row)
                        {       
                                $gender = $row->gender == 1 ? 'Male' : 'Female';
                                $output .= '
                                <tr>
                                <td>'.$row->first_name.'</td>
                                <td>'.$row->last_name.'</td>
                                <td>'.$row->email.'</td>
                                <td>'.$gender.'</td>
                                <td>'.nice_date($row->dob,'d/m/Y').'</td>
                                <td>'.$row->phone_mobile.'</td>
                                <td> <a href="'.base_url().'index.php/patients/view/'.$row->patient_id.'"> view patient </a></td>
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

                if($query!='')
                {
                        $this->user_activity_model->set('searched for a registered patient');
                }

                echo $output;
        }

        public function set_activity($activity)
        {
                if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
                }
                $data['patients'] = $this->patients_model->get_patients();
                $data['title'] = 'patients archive';
                $this->load->view('templates/header');
                $this->load->view('patients/index', $data);
                $this->load->view('templates/footer');
        }

        public function patient_exists()
        {
                $data = $this->input->post();
                echo $this->patients_model->patient_exists($data['first_name'],$data['last_name'],$data['dob']);
        }

        public function occupations()
        {
                echo $this->patients_model->occupations();
        }

        public function index()
        {
                if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
                }
                $data['patients'] = $this->patients_model->get_patients();
                $data['title'] = 'patients archive';
                
                $this->load->view('templates/header');
                $this->load->view('patients/index', $data);
                $this->load->view('templates/footer');
        }
        public function view($patient_id = NULL)
        {
                if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
                }
                
                $this->load->helper('form');
                $this->load->helper('date');
                $this->load->library('form_validation');
                $data['patient_id'] = $patient_id;
                if (empty($data['patient_id']))
                {
                        show_404();
                }

                $this->load->view('templates/header');
                $this->load->view('patients/view',$data);
                $this->load->view('templates/footer');
        }
        public function create()
        {
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                //$this->form_validation->set_rules('dob', 'Date of birth', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]');

                if ($this->form_validation->run() === FALSE)
                {
                        $data['patient_id'] = '0';
                        $this->load->view('templates/header');
                        $this->load->view('patients/create',$data);
                        $this->load->view('templates/footer');
                }
                else
                {
                        $insert_id = $this->patients_model->set_patients();
                        $this->load->view('templates/header');
                        $this->load->view('patients/registration_success');
                        $this->load->view('templates/footer');
                        $this->patient_phq_model->get_patient_phq($insert_id);
                        $this->patient_gad_model->get_patient_gad($insert_id);
                        $this->patient_lab_test_model->get_patient_lab_test($insert_id);
                        
                }
                //echo "test";
        }
        public function update()
        {
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $patient_id = $this->input->post('patient_id');
                if ($this->form_validation->run() === FALSE)
                {
                        $this->load->view('templates/header');
                        $this->load->view('patients/view',array('patient_id' => $patient_id));
                        $this->load->view('templates/footer');
                }
                else
                {
                        $form_data = $this->input->post();
                        $this->patients_model->update_patients($patient_id,$form_data);
                        
                }
        }
        public function update_phq(){
  
                $patient_id = $this->input->post('patient_id');
                $form_data = $this->input->post();
                $this->patient_phq_model->set_patient_phq($patient_id,$form_data);
        }

        public function save_complete(){
                $patient_id = $this->input->post('patient_id');
                $this->patients_model->save_complete($patient_id);
        }

        public function update_gad(){
                $patient_id = $this->input->post('patient_id');
                $form_data = $this->input->post();
                $this->patient_gad_model->set_patient_gad($patient_id,$form_data);
        }
        public function update_patient_lab_test(){

                $patient_id = $this->input->post('patient_id');
                $form_data = $this->input->post();
                $this->patient_lab_test_model->set_patient_lab_test($patient_id,$form_data);
  
        }

        public function update_gp(){
                $patient_id = $this->input->post('patient_id');
                $form_data = $this->input->post();
                $this->patient_gp_model->set($patient_id,$form_data);
        }

        public function update_medical_history(){
                $this->load->library('form_validation');
                $patient_id = $this->input->post('patient_id');
                $form_data = $this->input->post();
                $this->patient_medical_history_model->set($patient_id,$form_data);
                $this->load->view('templates/header');
                $this->load->view('patients/view', array( 'patient_id' => $patient_id) );
                $this->load->view('templates/footer');
        }

        public function patient_generate_report($patient_id)
	{
                $this->load->view('patients/patient_generate_report',array('patient_id'=>$patient_id));
        }

        public function get_patients()
	{
                echo json_encode($this->patients_model->get_patients());
        }
}