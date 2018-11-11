<?php 
    $tcpdflib = new Tcpdflib('P', 'mm', 'A4', true, 'UTF-8', false);
    $tcpdflib->SetTitle('My Title');
    $tcpdflib->SetHeaderMargin(30);
    //$tcpdflib->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $tcpdflib->SetTopMargin(20);
    $tcpdflib->setFooterMargin(20);
    $tcpdflib->SetAutoPageBreak(true);
    $tcpdflib->SetAuthor('Author');
    $tcpdflib->SetDisplayMode('real', 'default');
    
    $tcpdflib->AddPage();

    $html = "
        <h1>test</h1>
        
    ";
    
    $tcpdflib->writeHTML($html, true, 0, true, 0);
    //$tcpdflib->AddPage();
    $tcpdflib->setImageScale('1.5');
    $tcpdflib->Image('./uploads/27_blood.JPG',0,$tcpdflib->GetY());
    $tcpdflib->Output('My-File-Name.pdf', 'I');
?>