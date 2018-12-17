<?php
    $patient_details = $this->patients_model->get_patients($patient_id);
    $patient_gad = $this->patient_gad_model->get_patient_gad($patient_id);
    $patient_phq = $this->patient_phq_model->get_patient_phq($patient_id);
    $patient_lab_test = $this->patient_lab_test_model->get_patient_lab_test($patient_id);
    $patient_reports = $this->patient_reports_model->get_patient_reports($patient_id);
    $patient_medical_history_details = $this->patient_medical_history_model->get($patient_id);
    $patient_gp_details = $this->patient_gp_model->get($patient_id);
    $patient_travel_details = $this->patient_travel_model->get($patient_id);
    $completed_user = $this->ion_auth->user($patient_details['save_exist_user_id'])->row(); // get users from group with id of '1'

    //echo $completed_user->first_name;

    $categories = array();
    foreach ($patient_lab_test as $c) {
        $categories[] = $c['category'];
    }
    $uniqueCategories = array_unique($categories);

    $pdf = new Fpdilib();

    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    $pdf->SetTitle($patient_details['first_name'].'_Report');
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //echo PDF_HEADER_LOGO;
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,0,0), array(255,255,255));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetTopMargin(20);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true,20);
    $pdf->SetAuthor('lhscreening');
    $pdf->SetDisplayMode('real', 'default');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage();
    $pdf->setImageScale('1');
    $pdf->Image('./assets/lyca/images/logo.png',55, 10);

    $y = $pdf->getY();

    // set color for background
    $pdf->SetFillColor(51, 102, 255);

    // set color for text
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Helvetica', 'B', 25 );
    $pdf->MultiCell(297, 5,'',0,'L',true,1,0,30);
    $pdf->Text(50, 30, 'Health Assessment Report');

    $pdf->setImageScale('5');
    $pdf->Image('./assets/lyca/images/Health Assesment.jpg',15, $pdf->getY()+60);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Helvetica', 'B', 15 );

    $pdf->Text(100, 250, $patient_details['title'].' '.$patient_details['first_name'].' '.$patient_details['last_name']);

    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);
    
    $pdf->AddPage();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Helvetica', '', 13 );
    $pdf->MultiCell(180, 30, 'Our LycaHealth Ultra Health Assessment comprises of confidential questionnaires that ask questions about your health habits, your medical history and any pre-existing medical conditions (if known).',0,'[LEFT]',true,1,15, $pdf->getY()+10);

    $pdf->MultiCell(180, 30, 'From the analysis of this you will receive an easy-to-understand health report that give you an overview of your current health status, as well as health risks and how to manage them.',0,'[LEFT]',true,1,15, $pdf->getY()+2);

    $pdf->MultiCell(180, 30, 'Whether you are trying to get in shape, control an existing condition, or whether this is done as part of a work placed annual health check-up, you will find the help you need through the LycaHealth Ultra Health Assessment.',0,'[LEFT]',true,1,15, $pdf->getY()+2);

    $pdf->AddPage();

    $gender = $patient_details['gender'] == '1' ? 'Male' : 'Female';

    $answers = array(
        '0'=>'Not at all'
        ,'1'=>'Several days'
        ,'2'=>'More than half the days'
        ,'3'=>'Nearly every day'
    );

    $date1=date_create($patient_details['dob']);
    $date2=new DateTime();

    $diff=date_diff($date1,$date2);

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    //$pdf->Text(5, 20, 'Patient Details');
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(70, 5,'',0,'C',true,1,50,20);
    //$pdf->Text(60, 20, 'Patient Details');

    $pdf->writeHTMLCell(189, 5, 10, 20, 'Patient Details', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Text(10, $pdf->getY()+12, 'First Name');
    $pdf->Text(50, $pdf->getY(), $patient_details['first_name']);

    $pdf->Text(10,  $pdf->getY()+9, 'Last Name');
    $pdf->Text(50, $pdf->getY(), $patient_details['last_name']);

    $pdf->Text(10,  $pdf->getY()+9, 'Gender');
    $pdf->Text(50, $pdf->getY(), $gender);

    $pdf->Text(10,  $pdf->getY()+9, 'Date of birth');
    $pdf->Text(50, $pdf->getY(), nice_date($patient_details['dob'],'d-M-Y'));

    $pdf->Text(80,  $pdf->getY(), 'Age ');
    $pdf->Text(90, $pdf->getY(), $diff->format("%Y Years %m Months"));

    $pdf->Text(10,  $pdf->getY()+9, 'Blood Group ');
    $pdf->Text(50, $pdf->getY(), $patient_details['blood_group']);

    $pdf->Text(10,  $pdf->getY()+9, 'Occupation');
    $pdf->Text(50, $pdf->getY(), $patient_details['occupation']);

    $pdf->Text(10,  $pdf->getY()+9, 'London Address');
    $pdf->Text(50, $pdf->getY(), $patient_details['address']);

    $pdf->Text(10,  $pdf->getY()+9, 'Postal Code');
    $pdf->Text(50, $pdf->getY(), $patient_details['postal_code']);

    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+9, 'Home telephone');
    $pdf->Text(50, $pdf->getY(), $patient_details['phone_home']);
    if($patient_details['phone_home_prefer']==1)
        $pdf->Circle(85,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(85,$pdf->getY()+2,2);
    $pdf->Text(87, $pdf->getY(), 'Preferred');

    $pdf->Text(10, $pdf->getY()+9, 'Mobile telephone');
    $pdf->Text(50, $pdf->getY(), $patient_details['phone_mobile']);
    if($patient_details['phone_mobile_prefer']==1)
        $pdf->Circle(85,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(85,$pdf->getY()+2,2);
    $pdf->Text(87, $pdf->getY(), 'Preferred');

    $pdf->Text(10, $pdf->getY()+9, 'Work telephone');
    $pdf->Text(50, $pdf->getY(), $patient_details['phone_work']);
    if($patient_details['phone_work_prefer']==1)
        $pdf->Circle(85,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(85,$pdf->getY()+2,2);
    $pdf->Text(87, $pdf->getY(), 'Preferred');

    $pdf->Text(10, $pdf->getY()+9, 'Email');
    $pdf->Text(50, $pdf->getY(), $patient_details['email']);

    $pdf->SetFont('Helvetica', 'B', 20 ); 

    //$pdf->Text(5, $pdf->getY()+9, 'Next of kin details');
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'Next of kin details', 0, 0, 1, true, 'L', true);

    //$pdf->MultiCell(70, 5,'',0,'C',true,1,50,20);
    //$pdf->Text(60, 20, 'Patient Details');

    $pdf->SetFont('Helvetica', '', 11 ); 
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+12, 'Name ');
    $pdf->Text(50, $pdf->getY(), $patient_details['next_of_kin_name']);

    $pdf->Text(10, $pdf->getY()+9, 'Phone Number');
    $pdf->Text(50, $pdf->getY(), $patient_details['next_of_kin_phone']);

    $pdf->Text(10, $pdf->getY()+9, 'Relationship');
    $pdf->Text(50, $pdf->getY(), $patient_details['next_of_kin_relationship']);

    $pdf->Text(10, $pdf->getY()+9, 'In case of emergency if you are uncontactable, do you provide consent for your next of kin to be contacted ');
    $pdf->Text(10, $pdf->getY()+5, 'and for relevant clinical information to be divulged?');
    $pdf->Text(10, $pdf->getY()+9, 'Y');
    if($patient_details['next_of_kin_contact']==1)
        $pdf->Circle(17,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(17,$pdf->getY()+2,2);
    $pdf->Text(20, $pdf->getY(), 'N');
    if($patient_details['next_of_kin_contact']==0)
        $pdf->Circle(27,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(27,$pdf->getY()+2,2);

    //$pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    //$pdf->Text(5, $pdf->getY()+9, 'NHS / Alternative GP');
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->writeHTMLCell(297, 5, 0, $pdf->getY()+9, 'NHS / Alternative GP', 0, 0, 1, true, 'C', true);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'NHS / Alternative GP', 0, 0, 1, true, 'L', true);
    $pdf->SetFont('Helvetica', '', 11 ); 
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+12, 'Name of NHS / Alternative GP');
    $pdf->Text(70, $pdf->getY(), $patient_details['alternative_gp']);

    $pdf->Text(10, $pdf->getY()+9, 'I consent to my medical information being shared with my regular GP if I am not contactable. ');
    $pdf->Text(10, $pdf->getY()+9, 'Agree');
    if($patient_details['gp_contact_agree']==1)
        $pdf->Circle(25,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(25,$pdf->getY()+2,2);
    $pdf->Text(28, $pdf->getY(), 'Disagree');
    if($patient_details['gp_contact_agree']==0)
        $pdf->Circle(48,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(48,$pdf->getY()+2,2);

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    //$pdf->Text(5, 20, 'Health');
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'Health', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 ); 
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);
    
    $pdf->Text(10, $pdf->getY()+12, 'How is your health at present? Is there anything in particular you would like to discuss with the Doctor today?');
    
    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_details['health_at_present'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->Text(10, $pdf->getY()+2, 'Are you taking any medications at present Kindly list the medications as well as doses?');
    
    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_details['current_medication'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFillColor(0,0,0);

    $pdf->Text(10, $pdf->getY()+3, 'Are you aware of any allergies to the following?');

    $pdf->Text(15, $pdf->getY()+7, 'Milk');
    if($patient_details['allergy_milk']==1)
        $pdf->Circle(35,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(35,$pdf->getY()+2,2);
    
    $pdf->Text(40, $pdf->getY(), 'Shellfish');
    if($patient_details['allergy_shellfish']==1)
        $pdf->Circle(60,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(60,$pdf->getY()+2,2);

    $pdf->Text(15, $pdf->getY()+7, 'Eggs');
    if($patient_details['allergy_eggs']==1)
        $pdf->Circle(35,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(35,$pdf->getY()+2,2);

    $pdf->Text(40, $pdf->getY(), 'Iodine');
    if($patient_details['allergy_iodine']==1)
        $pdf->Circle(60,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(60,$pdf->getY()+2,2);

    $pdf->Text(15, $pdf->getY()+7, 'Peanuts');
    if($patient_details['allergy_peanuts']==1)
        $pdf->Circle(35,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(35,$pdf->getY()+2,2);

    $pdf->Text(40, $pdf->getY(), 'Pencillin');
    if($patient_details['allergy_pencillin']==1)
        $pdf->Circle(60,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(60,$pdf->getY()+2,2);
    
    $pdf->Text(15, $pdf->getY()+7, 'Tree Nuts(Walnuts/Almonds/Pecan)');
    if($patient_details['allergy_treenuts']==1)
        $pdf->Circle(81,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(81,$pdf->getY()+2,2);

    $pdf->Text(10, $pdf->getY()+12, 'Other Allergies');
    $pdf->Text(40, $pdf->getY(), 'Y');
    if($patient_details['allergy_others_details']==1)
        $pdf->Circle(47,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(47,$pdf->getY()+2,2);
    $pdf->Text(50, $pdf->getY(), 'N');
    if($patient_details['allergy_others_details']==0)
        $pdf->Circle(57,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(57,$pdf->getY()+2,2);

    $pdf->Text(10, $pdf->getY()+9, 'Other Allergies Details');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_details['allergy_others_details'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+2, 'Do you suffer from Hayfever ?');
    $pdf->Text(65, $pdf->getY(), 'Y');
    if($patient_details['hay_fever']==1)
        $pdf->Circle(72,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(72,$pdf->getY()+2,2);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Text(75, $pdf->getY(), 'N');
    if($patient_details['hay_fever']==0)
        $pdf->Circle(82,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(82,$pdf->getY()+2,2);

    $pdf->Text(10, $pdf->getY()+9, 'Do you have Asthma?');
    $pdf->Text(65, $pdf->getY(), 'Y');
    if($patient_details['asthma']==1)
        $pdf->Circle(72,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(72,$pdf->getY()+2,2);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Text(75, $pdf->getY(), 'N');
    if($patient_details['asthma']==0)
        $pdf->Circle(82,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(82,$pdf->getY()+2,2);

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    //$pdf->Text(5, $pdf->getY()+9, 'CHAPERONE');
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'CHAPERONE', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 ); 
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+12, 'Do you require a chaperone before this consultation?');
    $pdf->Text(110, $pdf->getY(), 'Y');
    if($patient_details['chaperone_required']==1)
        $pdf->Circle(117,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(117,$pdf->getY()+2,2);
     $pdf->SetDrawColor(0, 0, 0);
     $pdf->Text(120, $pdf->getY(), 'N');
    if($patient_details['chaperone_required']==0)
        $pdf->Circle(127,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(127,$pdf->getY()+2,2);

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(297, 5,'',0,'L',true,1,0,20);
    //$pdf->Text(30, 20, 'CONSENT');
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'CONSENT', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell(200, 5,'I consent to being contacted by un-encrypted email and/or telephone to discuss management plans, diagnosis and to disclose results. I accept the risk associated with receiving messages received by the above means',0,'L',true,1,10, $pdf->getY()+12);

    $pdf->SetFillColor(0, 0, 0);

    $x_cor = 15;
    $pdf->Text(15, $pdf->getY()+5, 'Y');
    $x_cor = $x_cor + 7; // 22
    if($patient_details['consent_unencrypted']==1)
        $pdf->Circle($x_cor ,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle($x_cor,$pdf->getY()+2,2);
    $x_cor = $x_cor + 7; // 35
    $pdf->Text($x_cor, $pdf->getY(), 'N');
    $x_cor = $x_cor + 7; // 42
    if($patient_details['consent_unencrypted']==0)
        $pdf->Circle($x_cor,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle($x_cor,$pdf->getY()+2,2);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell(200, 5,'I consent to having messages left on my preferred telephone number',0,'L',true,1,10, $pdf->getY()+7);
    
    $pdf->SetFillColor(0, 0, 0);

    $x_cor = 15;
    $pdf->Text(15, $pdf->getY()+5, 'Y');
    $x_cor = $x_cor + 7; // 22
    if($patient_details['consent_messages']==1)
        $pdf->Circle($x_cor ,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle($x_cor,$pdf->getY()+2,2);
    $x_cor = $x_cor + 7; // 35
    $pdf->Text($x_cor, $pdf->getY(), 'N');
    $x_cor = $x_cor + 7; // 42
    if($patient_details['consent_messages']==0)
        $pdf->Circle($x_cor,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle($x_cor,$pdf->getY()+2,2);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell(200, 5,'I consent that my medical information being shared with my regular GP if I am not contactable',0,'L',true,1,10, $pdf->getY()+7);
    
    $pdf->SetFillColor(0, 0, 0);

    $x_cor = 15;
    $pdf->Text(15, $pdf->getY()+5, 'Y');
    $x_cor = $x_cor + 7; // 22
    if($patient_details['consent_medical_information']==1)
        $pdf->Circle($x_cor ,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle($x_cor,$pdf->getY()+2,2);
    $x_cor = $x_cor + 7; // 35
    $pdf->Text($x_cor, $pdf->getY(), 'N');
    $x_cor = $x_cor + 7; // 42
    if($patient_details['consent_medical_information']==0)
        $pdf->Circle($x_cor,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle($x_cor,$pdf->getY()+2,2);

    if(!empty($patient_details['signature'])){
        $img_base64_encoded = $patient_details['signature'];
        $imageContent = file_get_contents($img_base64_encoded);
        $path = tempnam('./uploads/', 'prefix');
        
        file_put_contents ($path, $imageContent);

        $pdf->setImageScale('3');
        $pdf->Image($path,15, $pdf->getY()+10);
    }

    $pdf->Text(20, $pdf->getY()+33, 'Signature');
    
    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(297, 5,'',0,'L',true,1,0,20);
    //$pdf->Text(30, 20, 'PHQ-9 Details');
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'PHQ-9 Details', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    
    $phq_score = 0;
    $pdf->setY($pdf->getY()+15);
    $pdf->setCellPaddings(2, 2, 1, 1);
    foreach ($patient_phq as $item):
        $y_test = $pdf->getY();
        $pdf->MultiCell(105, 18, $item['question'],1,'[L]',0,1,15, $y_test);
        $pdf->MultiCell(80, 18, $answers[$item['value']],1,'[L]',0,1,120, $y_test);
        $phq_score = $phq_score + $item['value'];
    endforeach;
    
    $dep_ser = '';
    if($phq_score <= 5)
        $dep_ser = 'None';
    else if($phq_score <= 10)
        $dep_ser = 'Mild';
    else if($phq_score <= 15)
        $dep_ser = 'Moderate ';
    else
        $dep_ser ='Sever Depression';

    $pdf->MultiCell(185, 20, 'PHQ-9 Score: '.$phq_score."/27"."\nDepression Severity: ".$dep_ser,1,'[L]',0,1,15, $pdf->getY());

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(297, 5,'',0,'L',true,1,0,20);
    //$pdf->Text(30, 20, 'GAD-7 Details');
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'GAD-7 Details', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    
    $gad_score = 0;
    $pdf->setY( $pdf->getY()+15);
    foreach ($patient_gad as $item):
        $y_test = $pdf->getY();
        $pdf->MultiCell(105, 13, $item['question'],1,'[L]',0,1,15, $y_test);
        $pdf->MultiCell(80, 13, $answers[$item['value']],1,'[L]',0,1,120, $y_test);
        $gad_score = $gad_score + $item['value'];
    endforeach;
    
    $anx_ser = '';
    if($gad_score <= 5)
        $anx_ser = 'None';
    else if($gad_score <= 10)
        $anx_ser = 'Mild';
    else if($gad_score <= 15)
        $anx_ser = 'Moderate ';
    else
        $anx_ser ='Sever anxiety';

    $pdf->MultiCell(185, 20, 'GAD-7 Score: '.$gad_score."/24"."\nAnxiety Severity: ".$anx_ser,1,'[L]',0,1,15, $pdf->getY());

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'Medical History', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+12, 'Present Symptoms');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['present_symptoms'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+5, 'Past Medical History');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['past_medical_history'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+5, 'Current Treatment');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['current_treatment'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+5, "Men's / Women's Health");

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['health'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'Family History', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255,255,255);

    $y_set = $pdf->getY()+15;
    $pdf->MultiCell(60, 7, '',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, 'Maternal',1,'[L]',1,1,75,$y_set);
    $pdf->MultiCell(60, 7, 'Paternal',1,'[L]',1,1,135, $y_set);

    $pdf->SetTextColor(0, 0, 0);
    //$pdf->SetFillColor(0, 178, 72);
    
    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Great grandparents',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['great_grandparents_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['great_grand_parents_paternal'],1,'[L]',0,1,135, $y_set);

    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Grandfather',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['grandfather_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['grandfather_paternal'],1,'[L]',0,1,135, $y_set);


    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Grandmother',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['grandmother_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['grandmother_paternal'],1,'[L]',0,1,135, $y_set);


    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Aunts & Uncles',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['aunt_uncle_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['aunt_uncle_paternal'],1,'[L]',0,1,135, $y_set);


    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Cousins',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['cousins_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['cousins_paternal'],1,'[L]',0,1,135, $y_set);


    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Parents',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['parents_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['parents_paternal'],1,'[L]',0,1,135, $y_set);


    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Siblings',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['siblings_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['siblings_paternal'],1,'[L]',0,1,135, $y_set);


    $y_set = $pdf->getY();
    $pdf->MultiCell(60, 7, 'Offspring',1,'[L]',0,1,15, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['offspring_maternal'],1,'[L]',0,1,75, $y_set);
    $pdf->MultiCell(60, 7, $patient_medical_history_details['offspring_paternal'],1,'[L]',0,1,135, $y_set);

    //$pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(297, 5,'',0,'L',true,1,0,20);
    //$pdf->Text(30, 20, 'PHQ-9 Details');
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'Travel & Vaccination History', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->setCellPaddings(2, 2, 1, 1);

    //$pdf->MultiCell(105, 18, $item['question'],1,'[L]',0,1,15, $y_test);
    //$pdf->MultiCell(80, 18, $answers[$item['value']],1,'[L]',0,1,120, $y_test);

   
    
    $phq_score = 0;
    $pdf->setY($pdf->getY()+15);

    $y_test = $pdf->getY();

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255,255,255);
    
    $pdf->MultiCell(40, 7, 'Destination',1,'[CENTER]',1,1,15, $y_test);
    $pdf->MultiCell(40, 7, 'Date',1,'[CENTER]',1,1,55, $y_test);
    $pdf->MultiCell(40, 7, 'Duration in days',1,'[CENTER]',1,1,95, $y_test);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(0, 178, 72);

    $length = count($patient_travel_details);
			for ($i=0; $i < $length; $i++) { 
                //echo "travel_destination[".$i."].value = ".$patient_travel_details[$i]['travel_destination'];
                $y_test = $pdf->getY();
                $pdf->MultiCell(40, 7, $patient_travel_details[$i]['travel_destination'],1,'[L]',0,1,15, $y_test);
                $pdf->MultiCell(40, 7, $patient_travel_details[$i]['travel_date'],1,'[L]',0,1,55, $y_test);
                $pdf->MultiCell(40, 7, $patient_travel_details[$i]['travel_duration'],1,'[L]',0,1,95, $y_test);
			}
    
    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'Vaccinations', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+20, 'Mumps');
    if($patient_medical_history_details['vaccine_mumps']==1)
        $pdf->Circle(45,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(45,$pdf->getY()+4,2);
    
    $pdf->Text(55, $pdf->getY(), 'German Measles (Rubella)');
    if($patient_medical_history_details['vaccine_rubella']==1)
        $pdf->Circle(110,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(110,$pdf->getY()+4,2);

    $pdf->Text(130, $pdf->getY(), 'Chicken Pox');
    if($patient_medical_history_details['vaccine_chicken_pox']==1)
        $pdf->Circle(160,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(160,$pdf->getY()+4,2);

    $pdf->Text(10, $pdf->getY()+7, 'Tuberculosis (TB)');
    if($patient_medical_history_details['vaccine_tb']==1)
        $pdf->Circle(45,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(45,$pdf->getY()+4,2);
    
    $pdf->Text(55, $pdf->getY(), 'Tetanus');
    if($patient_medical_history_details['vaccine_tetanus']==1)
        $pdf->Circle(110,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(110,$pdf->getY()+4,2);

    $pdf->Text(130, $pdf->getY(), 'Polio');
    if($patient_medical_history_details['vaccine_polio']==1)
        $pdf->Circle(160,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(160,$pdf->getY()+4,2);

    $pdf->Text(10, $pdf->getY()+7, 'Hepatitis');
    if($patient_medical_history_details['vaccine_hepatitis']==1)
        $pdf->Circle(45,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(45,$pdf->getY()+4,2);
    
    $pdf->Text(55, $pdf->getY(), 'Diphtheria');
    if($patient_medical_history_details['vaccine_diphtheria']==1)
        $pdf->Circle(110,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(110,$pdf->getY()+4,2);

    $pdf->Text(130, $pdf->getY(), 'Scarlet Fever');
    if($patient_medical_history_details['vaccine_scarlet_fever']==1)
        $pdf->Circle(160,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(160,$pdf->getY()+4,2);

    $pdf->Text(10, $pdf->getY()+7, 'Yellow Fever');
    if($patient_medical_history_details['vaccine_yellow_fever']==1)
        $pdf->Circle(45,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(45,$pdf->getY()+4,2);

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+12, 'Lifestyle', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+15, 'Smoking');
    //$pdf->Text(30, $pdf->getY(), $patient_medical_history_details['smoking']);

    $pdf->Text(28, $pdf->getY(), 'Non-smoker');
    if($patient_medical_history_details['smoking']=='Non-smoker')
        $pdf->Circle(55,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(55,$pdf->getY()+4,2);

    $pdf->Text(58, $pdf->getY(), 'Social');
    if($patient_medical_history_details['smoking']=='Social')
        $pdf->Circle(75,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(75,$pdf->getY()+4,2);
    
    $pdf->Text(78, $pdf->getY(), 'Frequent');
    if($patient_medical_history_details['smoking']=='Frequent')
        $pdf->Circle(99,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(99,$pdf->getY()+4,2);

    $pdf->Text(102, $pdf->getY(), 'Moderate');
    if($patient_medical_history_details['smoking']=='Moderate')
        $pdf->Circle(123,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(123,$pdf->getY()+4,2);

    $pdf->Text(126, $pdf->getY(), 'Chronic');
    if($patient_medical_history_details['smoking']=='Chronic')
        $pdf->Circle(144,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(144,$pdf->getY()+4,2);

    $pdf->Text(10, $pdf->getY()+7, 'Sleep');
    //$pdf->Text(30, $pdf->getY(), $patient_medical_history_details['sleep']);

    $pdf->Text(28, $pdf->getY(), '4-5 Hours');
    if($patient_medical_history_details['sleep']=='4-5 Hours')
        $pdf->Circle(52,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(52,$pdf->getY()+4,2);

    $pdf->Text(58, $pdf->getY(), '6-8 Hours');
    if($patient_medical_history_details['sleep']=='6-8 Hours')
        $pdf->Circle(80,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(80,$pdf->getY()+4,2);
    
    $pdf->Text(88, $pdf->getY(), '8-10 Hours');
    if($patient_medical_history_details['sleep']=='8-10 Hours')
        $pdf->Circle(115,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(115,$pdf->getY()+4,2);

    $pdf->Text(118, $pdf->getY(), '>10 Hours');
    if($patient_medical_history_details['sleep']=='>10 Hours')
        $pdf->Circle(145,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(145,$pdf->getY()+4,2);
    
    $pdf->Text(10, $pdf->getY()+7, "Sleep comments");

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['sleep_comments'],0,'L',true,1,15, $pdf->getY()+12);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+1, "Alcohol Consumption");

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 23, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['alcohol_consumption'],0,'L',true,1,15, $pdf->getY()+7);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()-3, "Diet");

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 23, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['diet'],0,'L',true,1,15, $pdf->getY()+7);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    //$pdf->Text(10, $pdf->getY()-3, 'Exercise');
    //$pdf->Text(30, $pdf->getY(), $patient_medical_history_details['exercise']);

    $pdf->Text(10, $pdf->getY()-3, 'Exercise');
    //$pdf->Text(30, $pdf->getY(), $patient_medical_history_details['sleep']);

    $pdf->Text(28, $pdf->getY(), 'None');
    if($patient_medical_history_details['exercise']=='None')
        $pdf->Circle(43,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(43,$pdf->getY()+4,2);

    $pdf->Text(58, $pdf->getY(), 'Low');
    if($patient_medical_history_details['exercise']=='Low')
        $pdf->Circle(70,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(70,$pdf->getY()+4,2);
    
    $pdf->Text(88, $pdf->getY(), 'Moderate');
    if($patient_medical_history_details['exercise']=='Moderate')
        $pdf->Circle(110,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(110,$pdf->getY()+4,2);

    $pdf->Text(118, $pdf->getY(), '>10 Hours');
    if($patient_medical_history_details['exercise']=='>10 Hours')
        $pdf->Circle(142,$pdf->getY()+4,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(142,$pdf->getY()+4,2);

    $pdf->Text(10, $pdf->getY()+9, "Additional comments on exercise");

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 23, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['diet'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+12, 'Examinations', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255, 255, 255);

    $pdf->writeHTMLCell(65, 5, 15, $pdf->getY()+15, 'Height', 1, 0, 1, true, 'L', true);
    $pdf->writeHTMLCell(65, 5, 80, $pdf->getY(), $patient_medical_history_details['height'], 1, 0, 1, true, 'L', true);

    // $pdf->Text(10, $pdf->getY()+15, 'Height',false,false,true,1);
    // $pdf->Text(50, $pdf->getY(),$patient_medical_history_details['height'],false,false,true,1);

    $pdf->writeHTMLCell(65, 5, 15, $pdf->getY()+7, 'Weight', 1, 0, 1, true, 'L', true);
    $pdf->writeHTMLCell(65, 5, 80, $pdf->getY(), $patient_medical_history_details['weight'], 1, 0, 1, true, 'L', true);

    // $pdf->Text(10, $pdf->getY()+8, 'Weight',false,false,true,1);
    // $pdf->Text(50, $pdf->getY(),$patient_medical_history_details['weight'],false,false,true,1);

    $pdf->writeHTMLCell(65, 5, 15, $pdf->getY()+7, 'Body Mass Index', 1, 0, 1, true, 'L', true);
    $pdf->writeHTMLCell(65, 5, 80, $pdf->getY(), $patient_medical_history_details['body_mass'], 1, 0, 1, true, 'L', true);

    // $pdf->Text(10, $pdf->getY()+8, 'Body Mass Index',false,false,true,1);
    // $pdf->Text(50, $pdf->getY(),$patient_medical_history_details['body_mass'],false,false,true,1);

    $pdf->writeHTMLCell(65, 5, 15, $pdf->getY()+7, 'Body Fat', 1, 0, 1, true, 'L', true);
    $pdf->writeHTMLCell(65, 5, 80, $pdf->getY(), $patient_medical_history_details['body_fat'], 1, 0, 1, true, 'L', true);

    // $pdf->Text(10, $pdf->getY()+8, 'Body Fat',false,false,true,1);
    // $pdf->Text(50, $pdf->getY(),$patient_medical_history_details['body_fat'],false,false,true,1);

    $bim_int = "Interpretation: <br> <br>
    What your BMI means: <br> <br>
    BMI below 18.5 : Experts generally consider a BMI below 18.5 to be underweight. <br> <br>
    BMI 18.5 – 24.9 : Experts generally consider a BMI of 18.5 to 25 to be healthy. <br> <br>
    BMI 25.0 – 29.9 : Experts generally consider a BMI of 25 to 30 to be considered overweight. <br> <br>
    BMI 30.0 – 39.9 : Experts generally consider a BMI over 30 as very overweight (obese).";

    $pdf->SetFont('Helvetica', 'B', 11 ); 

    $pdf->writeHTMLCell(180, 55, 15, $pdf->getY()+9, $bim_int, 0, 0, 0, true, 'L', true);


    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+80, 'Extraordinary Physical Findings', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255, 255, 255);

    $pdf->RoundedRect(10, $pdf->getY()+18, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_medical_history_details['extra_ordinary_physical'],0,'L',true,1,15, $pdf->getY()+17);

    $pdf->SetDrawColor(0, 0, 0);

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY(), 'Laboratory Test', 0, 0, 1, true, 'L', true);

    $pdf->setCellPaddings(1, 0, 0, 0);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->setY($pdf->getY()+5);

    $pdf->SetFillColor(255, 255, 255);

    foreach ($uniqueCategories as $cat):
        $pdf->SetFont('Helvetica', 'B', 15 );

        if($cat=='Neck'):
            $pdf->AddPage();
        endif;

        $pdf->Text(10, $pdf->getY()+9, $cat);
        $pdf->SetFont('Helvetica', '', 11 );
        
        $pdf->setY($pdf->getY()+5);

        foreach ($patient_lab_test as $item):
            if($item['category']==$cat):
                //$pdf->Text(15, $pdf->getY()+5, $item['test_name'],false,false,true,1,1,'L');
                $pdf->writeHTMLCell(65, 5, 15, $pdf->getY()+5, $item['test_name'], 1, 0, 1, true, 'L', true);
                //$pdf->Text(65, $pdf->getY(),$item['value']." ".$item['unit'],false,false,true,1);
                $pdf->writeHTMLCell(65, 5, 80, $pdf->getY(), $item['value']." ".$item['unit'], 1, 0, 1, true, 'L', true);
            endif;
        endforeach;
    endforeach;


    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(0, 178, 72);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(189, 5, 10, $pdf->getY()+9, 'GP Summary & Recommendation', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+12, 'Blood results summary');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_gp_details['blood_results'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+5, 'Ultrasound results summary');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_gp_details['ultra_sound'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+5, 'MRI results summary');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_gp_details['mri_results'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+5, "Overall lifestyle summary");

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_gp_details['overall_lifestyle'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+5, "Additional comments");

    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_gp_details['additional_comments'],0,'L',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);


    if(!empty($patient_reports['blood'])){
        $str = explode('.', $patient_reports['blood']);
        if($str[1]=='pdf'){
            $pdf->setPrintHeader(false);

            $pageCount = $pdf->setSourceFile('./uploads/'.$patient_reports['blood']);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
            
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, array('adjustPageSize' => true));
            
                $pdf->SetXY(5, 5);
                $pdf->Write(8, 'Blood report');

            }

            $pdf->setPrintHeader(true);
        }
        else{
            $pdf->AddPage();
            $html = "<br><h1>Patient Blood Report</h1><br>";
            $pdf->writeHTML($html, true, 0, true, 0);
            $pdf->setImageScale('1.5');
            $pdf->Image('./uploads/'.$patient_reports['blood'],0,$pdf->GetY());
        }
        
    }

    if(!empty($patient_reports['mri'])){
        $str = explode('.', $patient_reports['mri']);
        if($str[1]=='pdf'){

            $pdf->setPrintHeader(false);

            $pageCount = $pdf->setSourceFile('./uploads/'.$patient_reports['mri']);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
            
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, array('adjustPageSize' => true));
            
                
                $pdf->SetXY(5, 5);
                $pdf->Write(8, 'MRI report');
            }
            $pdf->setPrintHeader(true);
        }
        else{
            $pdf->AddPage();
            $html = "<br><h1>Patient MRI Report</h1><br>";
            $pdf->writeHTML($html, true, 0, true, 0);
            $pdf->setImageScale('1.5');
            $pdf->Image('./uploads/'.$patient_reports['mri'],0,$pdf->GetY());
        }
    }

    if(!empty($patient_reports['xray'])){
        $str = explode('.', $patient_reports['xray']);
        if($str[1]=='pdf'){

            $pdf->setPrintHeader(false);

            $pageCount = $pdf->setSourceFile('./uploads/'.$patient_reports['xray']);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
            
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, array('adjustPageSize' => true));
            
                $pdf->SetXY(5, 5);
                $pdf->Write(8, 'Xray report');
            }

            $pdf->setPrintHeader(true);
        }
        else{
            $pdf->AddPage();
            $html = "<br><h1>Patient Xray Report</h1><br>";
            $pdf->writeHTML($html, true, 0, true, 0);
            $pdf->setImageScale('1.5');
            $pdf->Image('./uploads/'.$patient_reports['xray'],0,$pdf->GetY());
        }
    }

    if(!empty($completed_user)){
        $pdf->AddPage();

        $pdf->Text(10, 40, 'Yours Sincerely');

        $path = './uploads/'.$completed_user->id.'_signature.jpeg';
        
        $pdf->setImageScale('3');
        $pdf->Image($path,15, 50);

        $pdf->Text(10, 70, 'Dr '.$completed_user->first_name.' '.$completed_user->last_name);
        $pdf->Text(10, 75, $completed_user->qualification);
        $pdf->Text(10, 80, $completed_user->designation);
        
    }
    
    $pdf->Output($patient_details['first_name'].'_Report.pdf', 'I');
?>