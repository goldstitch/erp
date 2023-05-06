
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
if ( !function_exists('lang'))
{
function lang($line,$id = '')
{
$CI =&get_instance();
$line = $CI->lang->line($line);
if ($id != '')
{
$line = '<label for="'.$id.'">'.$line."</label>";
}
return $line;
}
}

?>