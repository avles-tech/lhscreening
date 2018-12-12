<?php
class Patient_medical_history_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get($patient_id)
        {
                $query = $this->db->get_where('patient_medical_history', array('patient_id' => $patient_id));
                return $query->row_array();
        }

        public function set($patient_id,$form_data)
        {
                $this->load->helper('url');

                $travel_destination = $form_data['travel_destination'];
                $travel_date = $form_data['travel_date'];
                $travel_duration = $form_data['travel_duration'];

                unset($form_data['travel_destination']);
                unset($form_data['travel_date']);
                unset($form_data['travel_duration']);

                foreach ($travel_destination as $value){
                        echo 'travel_destination:'.$value;
                }

                $query = $this->db->get_where('patient_medical_history', array('patient_id' => $patient_id));
                $patient_gp = $query->result_array();
                $count = count($patient_gp);

                if (empty($count)){
                        return $this->db->insert('patient_medical_history', $form_data);
                }
                else{
                        
                        $this->db->delete('patient_travel', array('patient_id' => $patient_id));

                         $length = count($travel_destination);

                        echo 'length '.$length;

                        for ($i=0; $i < $length; $i++) { 
                                echo 'travel_destination : '.$travel_destination[$i];
                                echo 'travel_date : '.$travel_date[$i];
                                echo 'travel_duration : '.$travel_duration[$i];

                                $data = array(
                                                'travel_destination' => $travel_destination[$i]
                                                ,'travel_date' => $travel_date[$i]
                                                ,'travel_duration' => $travel_duration[$i]
                                                ,'patient_id' => $patient_id
                                        );
                                $this->db->insert('patient_travel', $data);
                        }
                        // foreach ($travel as $value):
                        //         //$value['patient_id'] = $patient_id;
                        //         echo 'test '.$value;
                        //         $data = array(
                        //                 'travel_destination' => $value['travel_destination']
                        //                 ,'travel_date' => $value['travel_date']
                        //                 ,'travel_duration' => $value['travel_duration']
                        //                 ,'patient_id' => $patient_id
                        //         );
                        //         $this->db->insert('patient_travel', $data);
                        // endforeach;

                        $this->db->where('patient_id' , $patient_id);
                        return $this->db->update('patient_medical_history', $form_data);
                }
        }
}