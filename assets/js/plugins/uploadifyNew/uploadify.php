

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$targetFolder = '/uploads';
$verifyToken = md5('unique_salt'.$_POST['timestamp']);
if (!empty($_FILES) &&$_POST['token'] == $verifyToken) {
$tempFile = $_FILES['Filedata']['tmp_name'];
$targetPath = $_SERVER['DOCUMENT_ROOT'] .$targetFolder;
$targetFile = rtrim($targetPath,'/') .'/'.$_FILES['Filedata']['name'];
$fileTypes = array('jpg','jpeg','gif','png');
$fileParts = pathinfo($_FILES['Filedata']['name']);
if (in_array($fileParts['extension'],$fileTypes)) {
move_uploaded_file($tempFile,$targetFile);
echo '1';
}else {
echo 'Invalid file type.';
}
}

?>