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
                $this->load->model('patient_medical_history_model');
                $this->load->model('patient_gp_model');

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
                        echo $error;
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->patient_reports_model->set_patient_reports($this->upload->data('file_name'));
                }
        }

        public function do_upload_ex()
        {
                $form_data = $this->input->post();
                $patient_id = $form_data['patient_id'];
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'pdf|jpg|jpeg';
                $config['overwrite'] = true;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        echo $error;
                        //$this->load->view('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->patient_reports_model->set_patient_reports($this->upload->data('file_name'));
                }
        }

        public function upload_signature()
        {
                $form_data = $this->input->post();
                $baseFromJavascript = $form_data['signature']; // $_POST['base64']; //your data in base64 'data:image/png....';
                // We need to remove the "data:image/png;base64,"
                $base_to_php = explode(',', $baseFromJavascript);
                // the 2nd item in the base_to_php array contains the content of the image
                $data = base64_decode($base_to_php[1]);

                $signature = base64_decode($form_data['signature']);

                $user_id = $form_data['user_id'];

                file_put_contents('./uploads/'. $user_id.'_signature.jpeg', $data);
        }

        public function rename_file()
        {
                $data = $this->input->post();
                $old_name = './uploads/'.$data['old_name'];
                $new_name = $data['new_name'].'.'.pathinfo($old_name, PATHINFO_EXTENSION);
                $new_name_path = './uploads/'.$data['new_name'].'.'.pathinfo($old_name, PATHINFO_EXTENSION);

                rename( $old_name, $new_name_path);

                $this->patient_reports_model->set_patient_reports($new_name);
        }

        public function del_report()
        {
                $this->patient_reports_model->del_patient_reports();
        }

        public function load_upload_div($patient_id,$report)
        {
                $data['result'] = array('patient_id'=>$patient_id , 'report'=>$report);


                return $this->load->view('patients/upload_file_div',$data,true);//This will load your view page to the div element
        }
}
?>