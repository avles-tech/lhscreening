<?php
    $patient_details = $this->patients_model->get_patients($patient_id);
    $patient_gad = $this->patient_gad_model->get_patient_gad($patient_id);
    $patient_phq = $this->patient_phq_model->get_patient_phq($patient_id);
    $patient_lab_test = $this->patient_lab_test_model->get_patient_lab_test($patient_id);
    $patient_reports = $this->patient_reports_model->get_patient_reports($patient_id);

    $tcpdflib = new Fpdilib();
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
    $html.= "<p> Blood Group :".$patient_details['blood_group']."</p>";
    $html.= "<p> Occupation :".$patient_details['occupation']."</p>";

    $html.= "<br><h1>Next of kin details</h1>";
    $html.= "<p> Name :".$patient_details['next_of_kin_name']."</p>";
    $html.= "<p> Phone Number :".$patient_details['next_of_kin_phone']."</p>";
    $html.= "<p> Relationship :".$patient_details['next_of_kin_relationship']."</p>";
    $html.= "<p> In case of emergency if you are uncontactable, do you provide consent for your next of kin to be contacted
    and for relevant clinical information to be divulged? ".($patient_details['next_of_kin_contact']=='1'?'Yes':'No')."</p>";

    $html.= "<br><h1>NHS / Alternative GP</h1>";
    $html.= "<p> Name :".$patient_details['alternative_gp']."</p>";
    $html.= "<p> I consent to my medical information being shared with my regular GP if I am not contactable. :".($patient_details['gp_contact_agree']=='1'?'Yes':'No')."</p>";
    


    $tcpdflib->writeHTML($html, true, 0, true, 0);
    
    $tcpdflib->AddPage();

    $html = "<br><h1>Health</h1>";
    $html.= "<p> How is your health at present? Is there anything in particular you would like to discuss with the Doctor today? :".$patient_details['health_at_present']."</p>";
    $html.= "<p> Are you taking any medications at present Kindly list the medications as well as doses? ".$patient_details['current_medication']."</p>";
    $html.= "<p> Are you aware of any allergies to the following? : </p>";
    $html.= "<table> <tr > <th> Allergy </th> <th> Yes/No</th></tr>";
    $html.= "<tr> <td> Eggs </td> <td>".($patient_details['allergy_milk']=='1'?'Yes':'No')." </td> </tr>";
    $html.= "<tr> <td> Milk </td> <td>".($patient_details['allergy_eggs']=='1'?'Yes':'No')." </td> </tr>";
    $html.= "<tr> <td> Peanuts </td> <td>".($patient_details['allergy_peanuts']=='1'?'Yes':'No')." </td> </tr>";
    $html.= "<tr> <td> Shellfish </td> <td>".($patient_details['allergy_shellfish']=='1'?'Yes':'No')." </td> </tr>";
    $html.= "<tr> <td> Iodine </td> <td>".($patient_details['allergy_iodine']=='1'?'Yes':'No')." </td> </tr>";
    $html.= "<tr> <td> Penicillin </td> <td>".($patient_details['allergy_pencillin']=='1'?'Yes':'No')." </td> </tr>";
    $html.= "<tr> <td> Tree nuts(walnuts/almonds/pecan) </td> <td>".($patient_details['allergy_treenuts']=='1'?'Yes':'No')." </td> </tr>";
    $html.= "</table>";
    $html.= "<p> Other Allergies ".($patient_details['allergy_others']=='1'?'Yes':'No')." </p>";
    $patient_details['allergy_others']=='1' ? $html.= "<p> Other Allergies Details ".($patient_details['allergy_others_details']=='1'?'Yes':'No')." </p>" : '' ;
    $html.= "<p> Do you suffer from Hayfever? ".($patient_details['hay_fever']=='1'?'Yes':'No')." </p>";
    $html.= "<p> Do you have Asthma? ".($patient_details['asthma']=='1'?'Yes':'No')." </p>";

    $html.= "<br><h1>CHAPERONE</h1>";
    $html.= "<p> ODo you require a chaperone before this consultation?".($patient_details['chaperone_required']=='1'?'Yes':'No')." </p>";

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
    
    $tcpdflib->AddPage();
    $html = "<br><h1>Lab Test</h1>";
    foreach ($patient_lab_test as $item): 
        $html.= "<p>".$item['test_name']." : ".$item['value']." ".$item['unit']."</p>";
    endforeach;
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    if(!empty($patient_reports['blood'])){
        $str = explode('.', $patient_reports['blood']);
        if($str[1]=='pdf'){
            $pageCount = $tcpdflib->setSourceFile('./uploads/'.$patient_reports['blood']);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $tcpdflib->importPage($pageNo);
            
                $tcpdflib->AddPage();
                // use the imported page and adjust the page size
                $tcpdflib->useTemplate($templateId, array('adjustPageSize' => true));
            
                $tcpdflib->SetFont('Helvetica');
                $tcpdflib->SetXY(5, 5);
                $tcpdflib->Write(8, 'Blood report');
            }
        }
        else{
            $tcpdflib->AddPage();
            $html = "<br><h1>Patient Blood Report</h1><br>";
            $tcpdflib->writeHTML($html, true, 0, true, 0);
            $tcpdflib->setImageScale('1.5');
            $tcpdflib->Image('./uploads/'.$patient_reports['blood'],0,$tcpdflib->GetY());
        }
        
    }

    if(!empty($patient_reports['mri'])){
        $str = explode('.', $patient_reports['mri']);
        if($str[1]=='pdf'){
            $pageCount = $tcpdflib->setSourceFile('./uploads/'.$patient_reports['mri']);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $tcpdflib->importPage($pageNo);
            
                $tcpdflib->AddPage();
                // use the imported page and adjust the page size
                $tcpdflib->useTemplate($templateId, array('adjustPageSize' => true));
            
                $tcpdflib->SetFont('Helvetica');
                $tcpdflib->SetXY(5, 5);
                $tcpdflib->Write(8, 'MRI report');
            }
        }
        else{
            $tcpdflib->AddPage();
            $html = "<br><h1>Patient MRI Report</h1><br>";
            $tcpdflib->writeHTML($html, true, 0, true, 0);
            $tcpdflib->setImageScale('1.5');
            $tcpdflib->Image('./uploads/'.$patient_reports['mri'],0,$tcpdflib->GetY());
        }
    }

    if(!empty($patient_reports['xray'])){
        $str = explode('.', $patient_reports['xray']);
        if($str[1]=='pdf'){
            $pageCount = $tcpdflib->setSourceFile('./uploads/'.$patient_reports['xray']);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $tcpdflib->importPage($pageNo);
            
                $tcpdflib->AddPage();
                // use the imported page and adjust the page size
                $tcpdflib->useTemplate($templateId, array('adjustPageSize' => true));
            
                $tcpdflib->SetFont('Helvetica');
                $tcpdflib->SetXY(5, 5);
                $tcpdflib->Write(8, 'Xray report');
            }
        }
        else{
            $tcpdflib->AddPage();
            $html = "<br><h1>Patient Xray Report</h1><br>";
            $tcpdflib->writeHTML($html, true, 0, true, 0);
            $tcpdflib->setImageScale('1.5');
            $tcpdflib->Image('./uploads/'.$patient_reports['xray'],0,$tcpdflib->GetY());
        }
    }

    $tcpdflib->Output($patient_details['first_name'].'_Report', 'I');
    
?>