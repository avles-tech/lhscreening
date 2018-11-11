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


class Testpdf extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->add_package_path( APPPATH . 'third_party/fpdf');
        $this->load->library('pdf');
    }

	public function index()
	{
        $this->pdf = new Pdf();
        $this->pdf->Add_Page('P','A4',0);
        $this->pdf->AliasNbPages();
        
        $this->pdf->Output( 'page.pdf' , 'I' );
    }
    
    public function patient_report()
	{
        $this->pdf = new Pdf();
        $this->pdf->Add_Page('P','A4',0);
        $this->pdf->Cell(40,10,'Hello World !',1);
        //$this->pdf->SetY(-20);
        //$this->pdf->SetX(400);
        $y = $this->pdf->GetY() + 5;
        //$this->pdf->Cell(40,10,'Hello World !',1);
        //$this->pdf->Add_Page('P','A4',0);
        $this->pdf->Image('./uploads/27_blood.JPG',0,$y); //not work
        $this->pdf->AliasNbPages();
        
        $this->pdf->Output( 'page.pdf' , 'I' );
	}
}

/*
* application/controllers/Testpdf.php
*/
