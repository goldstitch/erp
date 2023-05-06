

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 
if ( !defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');
class Pdf extends FPDF
{
function __construct($orientation='P',$unit='mm',$size='A4')
{
parent::__construct($orientation,$unit,$size);
}
}

?>