<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Testpdf
*
* Version: 1.0.0
*
* Author: Pedro Ruiz Hidalgo
*		  ruizhidalgopedro@gmail.com
*         @pedroruizhidalg
*
* Location: application/controllers/Testpdf.php
*
* Created:  208-02-27
*
* Description:  This demonstrates pdf library is working.
*
* Requirements: PHP5 or above
*
*/


class Testfpdi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Fpdilib');

    }

	public function index()
	{
        //echo 'test';
        $pdf = new Fpdilib();
        $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(true, 40);

        $pdf->AddPage();
        $html = "<br><h1>Patient Blood Report</h1><br>";
        $pdf->writeHTML($html, true, 0, true, 0);

        // add a page
        //$pdf->AddPage();

        // get external file content
        //$utf8text = file_get_contents('./uploads/sample_blood.pdf', true);

        //$pdf->SetFont('freeserif', '', 12);
        // now write some text above the imported page
        //$pdf->Write(5, $utf8text);

        $pageCount = $pdf->setSourceFile('./uploads/sample_blood.pdf');

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
        
            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, array('adjustPageSize' => true));
        
            $pdf->SetFont('Helvetica');
            $pdf->SetXY(5, 5);
            $pdf->Write(8, 'A complete document imported with FPDI');
        }



        $pdf->Output();
    }
    
}

/*
* application/controllers/Testpdf.php
*/

?>