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


class Testtcpdf extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Tcpdflib');

    }

	public function index()
	{
        $this->load->view('view_file');
    }
    
}

/*
* application/controllers/Testpdf.php
*/

?>