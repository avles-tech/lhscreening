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
    $pdf->writeHTMLCell(297, 5, 0, 30, 'Health Assessment Report', 0, 0, 1, true, 'C', true);

    $pdf->setImageScale('5');
    $pdf->Image('./assets/lyca/images/Health Assesment.jpg',15, $pdf->getY()+60);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Helvetica', 'B', 11 );

    $pdf->Text(100, 250, $patient_details['title'].' '.$patient_details['first_name'].' '.$patient_details['last_name']);

    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);
    
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
    $pdf->Text(5, 20, 'Patient Details');

    $pdf->SetFont('Helvetica', '', 11 );

    $pdf->Text(10, $pdf->getY()+12, 'First Name');
    $pdf->Text(40, $pdf->getY(), $patient_details['first_name']);

    $pdf->Text(10,  $pdf->getY()+9, 'Last Name');
    $pdf->Text(40, $pdf->getY(), $patient_details['last_name']);

    $pdf->Text(10,  $pdf->getY()+9, 'Gender');
    $pdf->Text(40, $pdf->getY(), $gender);

    $pdf->Text(10,  $pdf->getY()+9, 'Date of birth');
    $pdf->Text(40, $pdf->getY(), nice_date($patient_details['dob'],'d-M-Y'));

    $pdf->Text(80,  $pdf->getY(), 'Age ');
    $pdf->Text(90, $pdf->getY(), $diff->format("%Y Years %m Months"));

    $pdf->Text(10,  $pdf->getY()+9, 'Blood Group ');
    $pdf->Text(40, $pdf->getY(), $patient_details['blood_group']);

    $pdf->Text(10,  $pdf->getY()+9, 'Occupation');
    $pdf->Text(40, $pdf->getY(), $patient_details['occupation']);

    $pdf->Text(10,  $pdf->getY()+9, 'London Address');
    $pdf->Text(40, $pdf->getY(), $patient_details['address']);

    $pdf->Text(10,  $pdf->getY()+9, 'Postal Code');
    $pdf->Text(40, $pdf->getY(), $patient_details['postal_code']);

    $pdf->SetFillColor(0, 0, 0);

    $pdf->Text(10, $pdf->getY()+9, 'Home telephone');
    $pdf->Text(40, $pdf->getY(), $patient_details['phone_home']);
    if($patient_details['phone_home_prefer']==1)
        $pdf->Circle(72,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(72,$pdf->getY()+2,2);
    $pdf->Text(74, $pdf->getY(), 'Preferred');

    $pdf->Text(10, $pdf->getY()+9, 'Mobile telephone');
    $pdf->Text(40, $pdf->getY(), $patient_details['phone_mobile']);
    if($patient_details['phone_mobile_prefer']==1)
        $pdf->Circle(72,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(72,$pdf->getY()+2,2);
    $pdf->Text(74, $pdf->getY(), 'Preferred');

    $pdf->Text(10, $pdf->getY()+9, 'Work telephone');
    $pdf->Text(40, $pdf->getY(), $patient_details['phone_work']);
    if($patient_details['phone_work_prefer']==1)
        $pdf->Circle(72,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(72,$pdf->getY()+2,2);
    $pdf->Text(74, $pdf->getY(), 'Preferred');

    $pdf->Text(10, $pdf->getY()+9, 'Email');
    $pdf->Text(40, $pdf->getY(), $patient_details['email']);

    $pdf->SetFont('Helvetica', 'B', 20 ); 

    $pdf->Text(5, $pdf->getY()+9, 'Next of kin details:');

    $pdf->SetFont('Helvetica', '', 11 ); 

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
    $pdf->Text(5, $pdf->getY()+9, 'NHS / Alternative GP');

    $pdf->SetFont('Helvetica', '', 11 );

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
    $pdf->Text(5, 20, 'Health');

    $pdf->SetFont('Helvetica', '', 11 );
    

    $pdf->Text(10, $pdf->getY()+12, 'How is your health at present? Is there anything in particular you would like to discuss with the Doctor today?');
    
    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_details['health_at_present'],0,'J',true,1,15, $pdf->getY()+10);

    $pdf->Text(10, $pdf->getY()+7, 'Are you taking any medications at present Kindly list the medications as well as doses?');
    
    $pdf->SetFillColor(255, 255, 255);
    $pdf->RoundedRect(10, $pdf->getY()+7, 190, 30, 3.50, '1111', 'DF',array('color' => array(51, 102, 255)));

    $pdf->MultiCell(180, 30, $patient_details['current_medication'],0,'J',true,1,15, $pdf->getY()+10);

    $pdf->SetDrawColor(0,0,0);

    $pdf->Text(10, $pdf->getY()+7, 'Are you aware of any allergies to the following?');

    $pdf->Text(10, $pdf->getY()+7, 'Milk');
    if($patient_details['allergy_milk']==1)
        $pdf->Circle(30,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(30,$pdf->getY()+2,2);
    
    $pdf->Text(40, $pdf->getY(), 'Shellfish');
    if($patient_details['allergy_shellfish']==1)
        $pdf->Circle(60,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(60,$pdf->getY()+2,2);

    $pdf->Text(10, $pdf->getY()+7, 'Eggs');
    if($patient_details['allergy_eggs']==1)
        $pdf->Circle(30,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(30,$pdf->getY()+2,2);

    $pdf->Text(40, $pdf->getY(), 'Iodine');
    if($patient_details['allergy_iodine']==1)
        $pdf->Circle(60,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(60,$pdf->getY()+2,2);

    $pdf->Text(10, $pdf->getY()+7, 'Peanuts');
    if($patient_details['allergy_peanuts']==1)
        $pdf->Circle(30,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(30,$pdf->getY()+2,2);

    $pdf->Text(40, $pdf->getY(), 'Pencillin');
    if($patient_details['allergy_pencillin']==1)
        $pdf->Circle(60,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(60,$pdf->getY()+2,2);
    
    $pdf->Text(10, $pdf->getY()+7, 'Tree nuts(walnuts/almonds/pecan)');
    if($patient_details['allergy_treenuts']==1)
        $pdf->Circle(75,$pdf->getY()+2,2,360, 359, 'F',array( 'color' => array(255, 0,0)));
    else
        $pdf->Circle(75,$pdf->getY()+2,2);

    $pdf->AddPage();
    
    
    $html= "<p> Other Allergies <b>".($patient_details['allergy_others']=='1'?'Yes':'No')."</b> </p>";
    $patient_details['allergy_others']=='1' ? $html.= "<p> Other Allergies Details <b>".$patient_details['allergy_others_details']."</b> </p>" : '' ;
    $html.= "<p> Do you suffer from Hayfever? <b>".($patient_details['hay_fever']=='1'?'Yes':'No')."</b> </p>";
    $html.= "<p> Do you have Asthma? <b>".($patient_details['asthma']=='1'?'Yes':'No')."</b> </p>";
    
    
    $html.= "<br><h1>CHAPERONE</h1>";
    $html.= "<p> Do you require a chaperone before this consultation? <b>".($patient_details['chaperone_required']=='1'?'Yes':'No')."</b> </p>";
    
    
    //echo $html;

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->AddPage();
    
    $html= "<br><h1>CONSENT</h1>";
    $html.= "<p>I consent to being contacted by un-encrypted email and/or telephone and /or WhatsApp messenger to discuss management plans, diagnosis and to disclose results. I accept the risk associated with receiving messages received by the above means <b>".($patient_details['consent_unencrypted']=='1'?'Yes':'No')."</b> </p>";
    $html.= "<p>I consent to having messages left on my preferred telephone number <b>".($patient_details['consent_messages']=='1'?'Yes':'No')."</b> </p>";
    $html.= "<p>I consent that my medical information being shared with my regular GP if I am not contactable <b>".($patient_details['consent_medical_information']=='1'?'Yes':'No')."</b> </p>";

    //$pdf->writeHTML($html, true, 0, true, 0);

    //$pdf->setJPEGQuality(25);
    //$imgdata = base64_decode($patient_details['signature']);
    if($patient_details['signature']){
        $img_base64_encoded = $patient_details['signature'];
        $imageContent = file_get_contents($img_base64_encoded);
        $path = tempnam('./uploads/', 'prefix');
        
        file_put_contents ($path, $imageContent);

        //echo $path;

        $html.= '<img align="right" height="80" width="80" src="' . $path . '">';
    }
    
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->AddPage();
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
    $pdf->writeHTML($html, true, 0, true, 0);

    $pdf->AddPage();

    $pdf->SetFont('Helvetica', 'B', 20 ); 
    $pdf->Text(5, 20, 'GAD-7 Details');

    $pdf->SetFont('Helvetica', '', 11 );
    
    $gad_score = 0;
    $pdf->setY(35);
    foreach ($patient_gad as $item):
        //$pdf->setY($pdf->getY()+7); 
        $pdf->MultiCell(105, 10, $item['question'],1,'[RIGHT]',0,1,15, $pdf->getY());
        $pdf->MultiCell(80, 10, $answers[$item['value']],1,'[RIGHT]',0,1,120, $pdf->getY()-10);
        $gad_score = $gad_score + $item['value'];
    endforeach;
    
    $pdf->MultiCell(185, 10, 'GAD-7 Score: '.$gad_score."/24",1,'[RIGHT]',0,1,15, $pdf->getY());

    $pdf->AddPage();

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
    $pdf->writeHTML($html, true, 0, true, 0);

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