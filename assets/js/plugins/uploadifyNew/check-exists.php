

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$targetFolder = '/uploads';
if (file_exists($_SERVER['DOCUMENT_ROOT'] .$targetFolder .'/'.$_POST['filename'])) {
echo 1;
}else {
echo 0;
}

?>