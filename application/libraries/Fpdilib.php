<?php 
use setasign\Fpdi\TcpdfFpdi;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once realpath(dirname(__FILE__) . '/tcpdf/tcpdf.php');
require_once realpath(dirname(__FILE__) . '/fpdi/autoload.php');

class Fpdilib extends TcpdfFpdi
{
    function __construct()
    {
        parent::__construct();
    }
}