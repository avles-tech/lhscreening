<?php

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();

                $this->load->model('patients_model');
                $this->load->model('patient_reports_model');
                $this->load->model('patient_lab_test_model');
                $this->load->model('patient_phq_model');
                $this->load->model('patient_gad_model');
                $this->load->model('phq_model');
                $this->load->model('gad_model');
                $this->load->model('user_activity_model');

                $this->load->library('ion_auth');

                $this->load->helper(array('form', 'url'));
                $this->load->helper('download');
                $this->load->helper('file');
        }

        public function index()
        {
                $this->load->view('upload_form', array('error' => ' ' ));
        }

        public function download ($file_name = "") {
                echo $file_name;
                $data = file_get_contents('./uploads/'.$file_name); // Read the file's contents

                force_download($file_name, $data);                       
            }

        public function do_upload()
        {
                $form_data = $this->input->post();
                $patient_id = $form_data['patient_id'];
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'pdf|jpg|jpeg';
                $config['max_size']             = 10240;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                $config['file_name'] = $patient_id.'_'.$form_data['report']; 
                $config['overwrite'] = true;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->patient_reports_model->set_patient_reports($this->upload->data('file_name'));


                        $this->load->view('templates/header');
                        $this->load->view('patients/view',array('patient_id' => $patient_id));
                        $this->load->view('templates/footer');
                }
        }
}
?>