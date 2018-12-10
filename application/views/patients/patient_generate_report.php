<?php
    $patient_details = $this->patients_model->get_patients($patient_id);
    $patient_gad = $this->patient_gad_model->get_patient_gad($patient_id);
    $patient_phq = $this->patient_phq_model->get_patient_phq($patient_id);
    $patient_lab_test = $this->patient_lab_test_model->get_patient_lab_test($patient_id);
    $patient_reports = $this->patient_reports_model->get_patient_reports($patient_id);
    $patient_medical_history_details = $this->patient_medical_history_model->get($patient_id);
    $patient_gp_details = $this->patient_gp_model->get($patient_id);

    $categories = array();
    foreach ($patient_lab_test as $c) {
        $categories[] = $c['category'];
    }
    $uniqueCategories = array_unique($categories);

    $pdf = new Tcpdflib();

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
    $pdf->setImageScale('1.5');
    $pdf->Image('./assets/lyca/images/logo.png',15, 10);

    $y = $pdf->getY();

    // set color for background
    $pdf->SetFillColor(51, 102, 255);

    // set color for text
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Helvetica', 'B', 20 );
    $pdf->MultiCell(297, 5,'',0,'J',true,1,0,30);
    $pdf->Text(50, 30, 'Health Assessment Report');

    $pdf->setImageScale('5');
    $pdf->Image('./assets/lyca/images/Health Assesment.jpg',15, $pdf->getY()+60);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Helvetica', 'B', 11 );

    $pdf->Text(100, 250, $patient_details['title'].' '.$patient_details['first_name'].' '.$patient_details['last_name']);

    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);
    
    $pdf->AddPage();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Helvetica', '', 13 );
    $pdf->MultiCell(180, 30, 'Our LycaHealth Ultra Health Assessment comprises of confidential questionnaires that ask questions about your health habits, your medical history and any pre-existing medical conditions (if known).',0,'[LEFT]',true,1,15, $pdf->getY()+10);

    $pdf->MultiCell(180, 30, 'From the analysis of this you will receive an easy-to-understand health report that you an overview of your current health status, as well as health risks and how to manage them.',0,'[LEFT]',true,1,15, $pdf->getY()+2);

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
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(70, 5,'',0,'C',true,1,50,20);
    //$pdf->Text(60, 20, 'Patient Details');

    $pdf->writeHTMLCell(70, 5, 10, 20, 'Patient Details', 0, 0, 1, true, 'L', true);

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
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(70, 5, 10, $pdf->getY()+9, 'Next of kin details', 0, 0, 1, true, 'L', true);

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
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->writeHTMLCell(297, 5, 0, $pdf->getY()+9, 'NHS / Alternative GP', 0, 0, 1, true, 'C', true);
    $pdf->writeHTMLCell(90, 5, 10, $pdf->getY()+9, 'NHS / Alternative GP', 0, 0, 1, true, 'L', true);
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
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(30, 5, 10, $pdf->getY()+9, 'Health', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 ); 
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(0, 0, 0);
    
    

    $pdf->Text(10, $pdf->getY()+12, 'How is your health at present? Is there anything in particular you would like to discuss with the Doctor today?');
    
    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_details['health_at_present'],0,'J',true,1,15, $pdf->getY()+10);

    $pdf->Text(10, $pdf->getY()+2, 'Are you taking any medications at present Kindly list the medications as well as doses?');
    
    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_details['current_medication'],0,'J',true,1,15, $pdf->getY()+10);

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
    
    $pdf->Text(15, $pdf->getY()+7, 'Tree nuts(walnuts/almonds/pecan)');
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

    $pdf->MultiCell(180, 30, $patient_details['allergy_others_details'],0,'J',true,1,15, $pdf->getY()+10);

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

    $pdf->Text(10, $pdf->getY()+9, ' Do you have Asthma?');
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
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->writeHTMLCell(50, 5, 10, $pdf->getY()+9, 'CHAPERONE', 0, 0, 1, true, 'L', true);

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
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(297, 5,'',0,'J',true,1,0,20);
    //$pdf->Text(30, 20, 'CONSENT');
    $pdf->writeHTMLCell(50, 5, 10, $pdf->getY()+9, 'CONSENT', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell(200, 5,'I consent to being contacted by un-encrypted email and/or telephone and /or WhatsApp messenger to discuss management plans, diagnosis and to disclose results. I accept the risk associated with receiving messages received by the above means',0,'L',true,1,10, $pdf->getY()+12);

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
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(297, 5,'',0,'J',true,1,0,20);
    //$pdf->Text(30, 20, 'PHQ-9 Details');
    $pdf->writeHTMLCell(60, 5, 10, $pdf->getY()+9, 'PHQ-9 Details', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    
    $phq_score = 0;
    $pdf->setY($pdf->getY()+15);
    $pdf->setCellPaddings(2, 2, 1, 1);
    foreach ($patient_phq as $item):
        $y_test = $pdf->getY();
        $pdf->MultiCell(105, 18, $item['question'],1,'[RIGHT]',0,1,15, $y_test);
        $pdf->MultiCell(80, 18, $answers[$item['value']],1,'[CENTER]',0,1,120, $y_test);
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
        $dep_ser ='Sever anxiety';

    $pdf->MultiCell(185, 10, 'PHQ-9 Score: '.$phq_score."/27"."\nDepression Severity: ".$dep_ser,1,'[RIGHT]',0,1,15, $pdf->getY());

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->SetFillColor(41, 163, 41);
    $pdf->SetTextColor(255, 255, 255);
    //$pdf->MultiCell(297, 5,'',0,'J',true,1,0,20);
    //$pdf->Text(30, 20, 'GAD-7 Details');
    $pdf->writeHTMLCell(60, 5, 10, $pdf->getY()+9, 'GAD-7 Details', 0, 0, 1, true, 'L', true);

    $pdf->SetFont('Helvetica', '', 11 );
    $pdf->SetTextColor(0, 0, 0);
    
    $gad_score = 0;
    $pdf->setY( $pdf->getY()+15);
    foreach ($patient_gad as $item):
        $y_test = $pdf->getY();
        $pdf->MultiCell(105, 13, $item['question'],1,'[RIGHT]',0,1,15, $y_test);
        $pdf->MultiCell(80, 13, $answers[$item['value']],1,'[RIGHT]',0,1,120, $y_test);
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

    $pdf->MultiCell(185, 10, 'GAD-7 Score: '.$gad_score."/24"."\n Anxiety Severity: ".$anx_ser,1,'[RIGHT]',0,1,15, $pdf->getY());

    $pdf->AddPage();
    $html = "<br> <h1>Medical History</h1>";
    $html.= "<p>Present Symptoms <b>".$patient_medical_history_details['present_symptoms']."</b></p>";
    $html.= "<p>Past Medical History <b>".$patient_medical_history_details['past_medical_history']."</b></p>";
    $html.= "<p>Current Treatment <b>".$patient_medical_history_details['current_treatment']."</b></p>";
    $html.= "<p>Men's / Women's Health <b>".$patient_medical_history_details['health']."</b></p>";
    $html.= "<p>Family History <b>".$patient_medical_history_details['family_history']."</b></p>";

    $html.= "<br> <h1>Vaccinations</h1>";
    $html.="<table>";
    $html.="<tr><td>Mumps</td><td><b>".($patient_medical_history_details['vaccine_mumps']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>German Measles (Rubella)</td><td><b>".($patient_medical_history_details['vaccine_rubella']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Chicken Pox</td><td><b>".($patient_medical_history_details['vaccine_tb']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Tuberculosis (TB)</td><td><b>".($patient_medical_history_details['vaccine_chicken_pox']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Tetanus</td><td><b>".($patient_medical_history_details['vaccine_tetanus']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Polio</td><td><b>".($patient_medical_history_details['vaccine_polio']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Hepatitis</td><td><b>".($patient_medical_history_details['vaccine_hepatitis']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Diphtheria</td><td><b>".($patient_medical_history_details['vaccine_diphtheria']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Scarlet Fever</td><td><b>".($patient_medical_history_details['vaccine_scarlet_fever']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="<tr><td>Yellow Fever</td><td><b>".($patient_medical_history_details['vaccine_yellow_fever']=='1' ? 'Yes' : 'No')."</b></td></tr>";
    $html.="</table>";

    $html.= "<br> <h1>Lifestyle</h1>";
    $html.="<p> Smoking <b>".$patient_medical_history_details['smoking']."</b></p>";
    $html.="<p> Sleep <b>".$patient_medical_history_details['sleep']."</b></p>";
    $html.="<p> Sleep comments <b>".$patient_medical_history_details['sleep_comments']."</b></p>";
    $html.="<p> Alcohol Consumption <b>".$patient_medical_history_details['alcohol_consumption']."</b></p>";
    $html.="<p> Diet <b>".$patient_medical_history_details['diet']."</b></p>";
    $html.="<p> Exercise <b>".$patient_medical_history_details['exercise']."</b></p>";
    $html.="<p> Additional comments on exercise <b>".$patient_medical_history_details['exercise_comments']."</b></p>";

    $html.= "<br> <h1>Examinations</h1>";
    $html.="<p> Height <b>".$patient_medical_history_details['smoking']."</b></p>";
    $html.="<p> Weight <b>".$patient_medical_history_details['sleep']."</b></p>";
    $html.="<p> Body Mass Index <b>".$patient_medical_history_details['body_mass']."</b></p>";
    $html.="<p> Body Fat <b>".$patient_medical_history_details['body_fat']."</b></p>";
    $html.="<p> Extraordinary Physical Findings <b>".$patient_medical_history_details['extra_ordinary_physical']."</b></p>";
    
    $pdf->writeHTML($html, true, 0, true, 0);

    $pdf->AddPage();
    $html = "<br> <h1>Laboratory Test</h1>";
    foreach ($uniqueCategories as $cat):
        $html.='<h3>'.$cat.'</h3>';
        $html.='<table> ';
        foreach ($patient_lab_test as $item):
            if($item['category']==$cat):
                $html.= "<tr>  <td> ".$item['test_name']." </td> <td><b>".$item['value']."</b> ".$item['unit']."</td></tr>";
            endif;
        endforeach;
        $html.='</table> ';
    endforeach;
    $pdf->writeHTML($html, true, 0, true, 0);

    $pdf->AddPage();
    $html = "<br> <h1>GP Summary & Recommendation</h1>";
    $html.='<table> ';
    $html.= "<tr>  <td> Blood results summary </td> <td><b>".$patient_gp_details['blood_results']."</b> </td></tr>";
    $html.= "<tr>  <td> Ultrasound results summary </td> <td><b>".$patient_gp_details['ultra_sound']."</b> </td></tr>";
    $html.= "<tr>  <td> MRI results summary </td> <td><b>".$patient_gp_details['mri_results']."</b> </td></tr>";
    $html.= "<tr>  <td> Overall lifestyle summary </td> <td><b>".$patient_gp_details['overall_lifestyle']."</b> </td></tr>";
    $html.= "<tr>  <td> Additional comments </td> <td><b>".$patient_gp_details['additional_comments']."</b> </td></tr>";
    $html.='</table> ';
    $pdf->writeHTML($html, true, 0, true, 0);

    if(!empty($patient_reports['blood'])){
        $str = explode('.', $patient_reports['blood']);
        if($str[1]=='pdf'){
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
        }
        else{
            $pdf->AddPage();
            $html = "<br><h1>Patient Xray Report</h1><br>";
            $pdf->writeHTML($html, true, 0, true, 0);
            $pdf->setImageScale('1.5');
            $pdf->Image('./uploads/'.$patient_reports['xray'],0,$pdf->GetY());
        }
    }

    $pdf->Output($patient_details['first_name'].'_Report.pdf', 'I');

    
?>