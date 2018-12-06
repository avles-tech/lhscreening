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

    $tcpdflib = new Fpdilib();

    //$tcpdflib->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    $tcpdflib->SetTitle($patient_details['first_name'].'_Report');
    $tcpdflib->SetHeaderMargin(PDF_MARGIN_HEADER);
    //echo PDF_HEADER_LOGO;
    //$tcpdflib->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    // set default header data
    $tcpdflib->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $tcpdflib->setFooterData(array(0,64,0), array(0,64,128));

    $tcpdflib->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $tcpdflib->SetTopMargin(20);
    $tcpdflib->setFooterMargin(20);
    $tcpdflib->SetAutoPageBreak(true,20);
    $tcpdflib->SetAuthor('lhscreening');
    $tcpdflib->SetDisplayMode('real', 'default');
    
    $tcpdflib->AddPage();

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

    $html = "<h1>Patient Details</h1>";
    $html .= "<table border='0'>";
    $html.= "<tr> <td> First Name </td> <td><b>".$patient_details['first_name']."</b></td></tr>";
    $html.= "<tr> <td> Last Name </td> <td><b>".$patient_details['last_name']."</b></td></tr>";
    $html.= "<tr> <td> Gender </td> <td><b>".$gender."</b></td></tr>";
    $html.= "<tr> <td> Age </td> <td><b>".($diff->format("%Y Years %m Months"))."</b></td></tr>";
    $html.= "<tr> <td> Date of birth </td> <td><b>".nice_date($patient_details['dob'],'d-M-Y')."</b></td></tr>";
    $html.= "<tr> <td> Email </td> <td><b>".$patient_details['email']."</b></td></tr>";
    $html.= "<tr> <td> Phone Mobile </td> <td><b>".$patient_details['phone_mobile']."</b></td></tr>";
    $html.= "<tr> <td> Phone Home </td> <td><b>".$patient_details['phone_home']."</b></td></tr>";
    $html.= "<tr> <td> Phone Work </td> <td><b>".$patient_details['phone_work']."</b></td></tr>";
    $html.= "<tr> <td> Address </td> <td><b>".$patient_details['address']."</b></td></tr>";
    $html.= "<tr> <td> Postal Code </td> <td><b>".$patient_details['postal_code']."</b></td></tr>";
    $html.= "<tr> <td> Blood Group </td> <td><b>".$patient_details['blood_group']."</b></td></tr>";
    $html.= "<tr> <td> Occupation </td> <td><b>".$patient_details['occupation']."</b></td></tr>";
    $html.= "<table>";

    $html.= "<h1>Next of kin details</h1>";
    $html.= "<p> Name <b>".$patient_details['next_of_kin_name']."</b></p>";
    $html.= "<p> Phone Number <b>".$patient_details['next_of_kin_phone']."</b></p>";
    $html.= "<p> Relationship <b>".$patient_details['next_of_kin_relationship']."</b></p>";
    $html.= "<p> In case of emergency if you are uncontactable, do you provide consent for your next of kin to be contacted
    and for relevant clinical information to be divulged <b>".($patient_details['next_of_kin_contact']=='1'?'Yes':'No')."</b></p>";

    $html.= "<h1>NHS / Alternative GP</h1>";
    $html.= "<p> Name <b>".$patient_details['alternative_gp']."</b></p>";
    $html.= "<p> I consent to my medical information being shared with my regular GP if I am not contactable. <b>".($patient_details['gp_contact_agree']=='1'?'Yes':'No')."</b></p>";
    

    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
    
    $html = "<br><h1>Health</h1>";
    $html.= "<p> How is your health at present? Is there anything in particular you would like to discuss with the Doctor today? :".$patient_details['health_at_present']."</p>";
    $html.= "<p> Are you taking any medications at present Kindly list the medications as well as doses? ".$patient_details['current_medication']."</p>";
    $html.= "<p> Are you aware of any allergies to the following? : </p>";
    $html.= "<table> <tr > <th> Allergy </th> <th> Yes/No</th></tr>";
    $html.= "<tr> <td> Eggs </td> <td> <b>".($patient_details['allergy_milk']=='1'?'Yes':'No')." </b></td> </tr>";
    $html.= "<tr> <td> Milk </td> <td> <b>".($patient_details['allergy_eggs']=='1'?'Yes':'No')." </b></td> </tr>";
    $html.= "<tr> <td> Peanuts </td> <td> <b>".($patient_details['allergy_peanuts']=='1'?'Yes':'No')." </b></td> </tr>";
    $html.= "<tr> <td> Shellfish </td> <td> <b>".($patient_details['allergy_shellfish']=='1'?'Yes':'No')." </b></td> </tr>";
    $html.= "<tr> <td> Iodine </td> <td> <b>".($patient_details['allergy_iodine']=='1'?'Yes':'No')." </b></td> </tr>";
    $html.= "<tr> <td> Penicillin </td> <td> <b>".($patient_details['allergy_pencillin']=='1'?'Yes':'No')." </b></td> </tr>";
    $html.= "<tr> <td> Tree nuts(walnuts/almonds/pecan) </td> <td> <b>".($patient_details['allergy_treenuts']=='1'?'Yes':'No')." </b></td> </tr>";
    $html.= "</table>";
    $html.= "<p> Other Allergies <b>".($patient_details['allergy_others']=='1'?'Yes':'No')."</b> </p>";
    $patient_details['allergy_others']=='1' ? $html.= "<p> Other Allergies Details <b>".$patient_details['allergy_others_details']."</b> </p>" : '' ;
    $html.= "<p> Do you suffer from Hayfever? <b>".($patient_details['hay_fever']=='1'?'Yes':'No')."</b> </p>";
    $html.= "<p> Do you have Asthma? <b>".($patient_details['asthma']=='1'?'Yes':'No')."</b> </p>";
    
    
    $html.= "<br><h1>CHAPERONE</h1>";
    $html.= "<p> Do you require a chaperone before this consultation? <b>".($patient_details['chaperone_required']=='1'?'Yes':'No')."</b> </p>";
    
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
    
    $html= "<br><h1>CONSENT</h1>";
    $html.= "<p>I consent to being contacted by un-encrypted email and/or telephone and /or WhatsApp messenger to discuss management plans, diagnosis and to disclose results. I accept the risk associated with receiving messages received by the above means <b>".($patient_details['consent_unencrypted']=='1'?'Yes':'No')."</b> </p>";
    $html.= "<p>I consent to having messages left on my preferred telephone number <b>".($patient_details['consent_messages']=='1'?'Yes':'No')."</b> </p>";
    $html.= "<p>I consent that my medical information being shared with my regular GP if I am not contactable <b>".($patient_details['consent_medical_information']=='1'?'Yes':'No')."</b> </p>";

    //$tcpdflib->writeHTML($html, true, 0, true, 0);

    //$tcpdflib->setJPEGQuality(25);
    //$imgdata = base64_decode($patient_details['signature']);
    if($patient_details['signature']){
        $img_base64_encoded = $patient_details['signature'];
        $imageContent = file_get_contents($img_base64_encoded);
        $path = tempnam(sys_get_temp_dir(), 'prefix');
        
        file_put_contents ($path, $imageContent);

        $html.= '<img align="right" height="80" width="80" src="' . $path . '">';
    }
    
    $tcpdflib->writeHTML($html, true, false, true, false, '');

    $tcpdflib->AddPage();
    $phq_score = 0;
    $html = "<br> <h1>PHQ-9 Details</h1>";
    foreach ($patient_phq as $item): 
        $html.= "<p>".$item['question']." <b> ".$answers[$item['value']]."</b></p>";
        $phq_score = $phq_score + $item['value'];
    endforeach;
    $html.= "<p> PHQ-9 Score: <b>".$phq_score."/27</b></p>";
    $dep_ser = 0;
    if($phq_score <= 4)
        $dep_ser = 'None';
    else if($phq_score <= 9)
        $dep_ser = 'Mild';
    else if($phq_score <= 14)
        $dep_ser = 'Moderate';
    else if($phq_score <= 19)
        $dep_ser = 'Moderately severe';
    else if($phq_score <= 27)
        $dep_ser = 'Severe';
    $html.= "<p> Depression Severity: <b>".$dep_ser."</b></p>";
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
    $gad_score = 0;
    $html = "<br><h1>GAD-7 Details</h1>";
    foreach ($patient_gad as $item): 
        $html.= "<p>".$item['question']." <b> ".$answers[$item['value']]."</b></p>";
        $gad_score = $gad_score + $item['value'];
    endforeach;
    $html.= "<p> GAD-7 Score: <b>".$gad_score."/24</b></p>";
    $anx_ser = '';
    if($gad_score <= 5)
        $anx_ser = 'None';
    else if($gad_score <= 10)
        $anx_ser = 'Mild';
    else if($gad_score <= 15)
        $anx_ser = 'Moderate ';
    else
        $anx_ser ='Sever anxiety';
    $html.= "<p> Anxiety Severity: <b>".$anx_ser."</b></p>";
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
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
    
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
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
    $tcpdflib->writeHTML($html, true, 0, true, 0);

    $tcpdflib->AddPage();
    $html = "<br> <h1>GP Summary & Recommendation</h1>";
    $html.='<table> ';
    $html.= "<tr>  <td> Blood results summary </td> <td><b>".$patient_gp_details['blood_results']."</b> </td></tr>";
    $html.= "<tr>  <td> Ultrasound results summary </td> <td><b>".$patient_gp_details['ultra_sound']."</b> </td></tr>";
    $html.= "<tr>  <td> MRI results summary </td> <td><b>".$patient_gp_details['mri_results']."</b> </td></tr>";
    $html.= "<tr>  <td> Overall lifestyle summary </td> <td><b>".$patient_gp_details['overall_lifestyle']."</b> </td></tr>";
    $html.= "<tr>  <td> Additional comments </td> <td><b>".$patient_gp_details['additional_comments']."</b> </td></tr>";
    $html.='</table> ';
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