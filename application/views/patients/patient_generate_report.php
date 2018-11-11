<?php
    $patient_details = $this->patients_model->get_patients($patient_id);
    $patient_gad = $this->patient_gad_model->get_patient_gad($patient_id);
    $patient_phq = $this->patient_phq_model->get_patient_phq($patient_id);
    $patient_reports = $this->patient_reports_model->get_patient_reports($patient_id);

    $tcpdflib = new Tcpdflib('P', 'mm', 'A4', true, 'UTF-8', false);
    $tcpdflib->SetTitle($patient_details['first_name'].'_Report');
    $tcpdflib->SetHeaderMargin(30);
    //$tcpdflib->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $tcpdflib->SetTopMargin(20);
    $tcpdflib->setFooterMargin(20);
    $tcpdflib->SetAutoPageBreak(true);
    $tcpdflib->SetAuthor('Author');
    $tcpdflib->SetDisplayMode('real', 'default');
    
    $tcpdflib->AddPage();

    $gender = $patient_details['gender'] == '1' ? 'Male' : 'Female';

    $answers = array(
        '0'=>'Not at all'
        ,'1'=>'Several days'
        ,'2'=>'More than half the days'
        ,'3'=>'Nearly every day'
    );

    $html = "<br><h1>Patient Details</h1>";
    $html.= "<p> First Name : ".$patient_details['first_name']."</p>";
    $html.= "<p> Last Name :".$patient_details['last_name']."</p>";
    $html.= "<p> Gender :".$gender."</p>";
    $html.= "<p> Age :".$patient_details['age']."</p>";
    $html.= "<p> Date of birth :".nice_date($patient_details['dob'],'d-M-Y')."</p>";
    $html.= "<p> Email : ".$patient_details['email']."</p>";
    $html.= "<p> Phone Mobile :".$patient_details['phone_mobile']."</p>";
    $html.= "<p> Phone Home :".$patient_details['phone_home']."</p>";
    $html.= "<p> Phone Work :".$patient_details['phone_work']."</p>";
    $html.= "<p> Address :".$patient_details['address']."</p>";
    $html.= "<p> Postal Code :".$patient_details['postal_code']."</p>";
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
    $html = "<br> <h1>PHQ-9 Details</h1>";
    foreach ($patient_phq as $item): 
        $html.= "<p>".$item['question']." : ".$answers[$item['value']]."</p>";
    endforeach;
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
    $html = "<br><h1>GAD-7 Details</h1>";
    foreach ($patient_gad as $item): 
        $html.= "<p>".$item['question']." : ".$answers[$item['value']]."</p>";
    endforeach;
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    if(!empty($patient_reports['blood'])){
        $tcpdflib->AddPage();
        $html = "<br><h1>Patient Blood Report</h1><br>";
        $tcpdflib->writeHTML($html, true, 0, true, 0);
        $tcpdflib->setImageScale('1.5');
        $tcpdflib->Image('./uploads/'.$patient_reports['blood'],0,$tcpdflib->GetY());
    }

    if(!empty($patient_reports['mri'])){
        $tcpdflib->AddPage();
        $html = "<br><h1>Patient MRI Report</h1><br>";
        $tcpdflib->writeHTML($html, true, 0, true, 0);
        $tcpdflib->setImageScale('1.5');
        $tcpdflib->Image('./uploads/'.$patient_reports['mri'],0,$tcpdflib->GetY());
    }

    if(!empty($patient_reports['xray'])){
        $tcpdflib->AddPage();
        $html = "<br><h1>Patient Xray Report</h1><br>";
        $tcpdflib->writeHTML($html, true, 0, true, 0);
        $tcpdflib->setImageScale('1.5');
        $tcpdflib->Image('./uploads/'.$patient_reports['xray'],0,$tcpdflib->GetY());
    }

    $tcpdflib->Output($patient_details['first_name'].'_Report', 'I');
    
?>