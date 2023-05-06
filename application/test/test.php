
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


exit('hello');
$command = "wkhtmltopdf -T 17 -B 13  ";
$command.= "--orientation 'Portrait' ";
$command.= "--title CollegeLetter "."test.html"." "."test.pdf";
$blah = exec($command);

?>