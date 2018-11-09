<?php
class Patients extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('patients_model');
                $this->load->model('patient_reports_model');
                $this->load->model('phq_model');
                $this->load->model('gad_model');
                $this->load->helper('url_helper');
                $this->load->library('ion_auth');
        }

        function search()
        {
                $output = '';
                $query = '';
                if($this->input->post('query'))
                {
                        $query = $this->input->post('query');
                }
                $data = $this->patients_model->search($query);
                $output .= '
                <div class="table-responsive">
                <table class="table table-bordered ">
                <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th></th>
                </tr>
                ';
                if($data->num_rows() > 0)
                {
                        foreach($data->result() as $row)
                        {
                                $output .= '
                                <tr>
                                <td>'.$row->first_name.'</td>
                                <td>'.$row->last_name.'</td>
                                <td>'.$row->email.'</td>
                                <td>'.$row->gender.'</td>
                                <td>'.$row->dob.'</td>
                                <td>'.$row->address.'</td>
                                <td> <a href="'.base_url().'index.php/patients/view/'.$row->id.'"> view patient </a></td>
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

        public function view($id = NULL)
        {
                $this->load->helper('form');
                $this->load->helper('date');
                $this->load->library('form_validation');
                
                $data['patient'] = $this->patients_model->get_patients($id);
                $data['phq_list'] = $this->phq_model->get_phq_list();
                $data['gad_list'] = $this->gad_model->get_gad_list();
                $data['patient_reports'] = $this->patient_reports_model->get_patient_reports($id);

                if (empty($data['patient']))
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
                
                if ($this->form_validation->run() === FALSE)
                {
                        $data['patient'] = array(
                                
                        );
                        $this->load->view('templates/header');
                        $this->load->view('patients/create',$data);
                        $this->load->view('templates/footer');

                }
                else
                {
                        $this->patients_model->set_patients();
                        $this->load->view('patients/registration_success');
                }

                //echo "test";
        }

        public function update()
        {
                $this->load->helper('form');
                $this->load->library('form_validation');

                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        
                if ($this->form_validation->run() === FALSE)
                {
                        $form_data = $this->input->post();
                        $data['patient'] = $form_data;

                        //echo $form_data['first_name'];

                        $this->load->view('templates/header');
                        $this->load->view('patients/view',$data);
                        $this->load->view('templates/footer');

                }
                else
                {
                        $id = $this->input->post('id');
                        $form_data = $this->input->post();

                        $this->patients_model->update_patients($id,$form_data);
                        
                        $data['patient'] = $this->patients_model->get_patients($id);
                        $data['phq_list'] = $this->phq_model->get_phq_list();
                        $data['gad_list'] = $this->gad_model->get_gad_list();

                        $this->load->view('templates/header');
                        $this->load->view('patients/view',$data);
                        $this->load->view('templates/footer');
                }

                //echo "test";
        }

        // public function success(){
        //         $this->load->view('patients/registration_success');
        // }
}