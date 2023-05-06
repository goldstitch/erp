

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '
';if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Databasebackupemail extends CI_Controller
{
public function __construct()
{
date_default_timezone_set('Asia/Karachi');
parent::__construct();
}
public function index()
{
$status = $this->sendbackup();
echo $status;
}
public function sendbackup()
{
$backupFile = $this->backup_tables();
$this->sendbackupemail($backupFile);
return "Mail Send ";
}
public function backup_tables()
{
$this->load->database();
$host = $this->db->hostname;
$username = $this->db->username;
$password = $this->db->password;
$database = $this->db->database;
$this->deleteallfilesfromfolder();
$path = $_SERVER['DOCUMENT_ROOT'] .'/db-backup/'.'db-backup-';
$date = date('y-m-d');
$md5 = $this->generaterandomstring();
$filename = 'db-backup-'.$date .'-'.$md5;
$zipFilename = $path .$date .'-'.$md5 .'.zip';
$sqlFilename = $path .$date .'-'.$md5 .'.sql';
$command = "mysqldump -h {$host} -u {$username} -p'{$password}' '{$database}' --events --routines --triggers > db-backup/{$filename}.sql";
shell_exec($command);
$zipFilename = $this->sqltozipfile($filename,$sqlFilename,$zipFilename);
return $zipFilename;
}
public function deleteallfilesfromfolder()
{
$files = glob('db-backup/*');
foreach($files as $file)
{
if(is_file($file)) {
unlink($file);
}
}
}
public function sqltozipfile($filename,$sqlFilename,$zipFilename)
{
$zip = new ZipArchive();
$zip->open($zipFilename,ZIPARCHIVE::CREATE);
$zip->addFile($sqlFilename,$filename .".sql");
$zip->close();
$this->deleteSqlFile($sqlFilename);
return $zipFilename;
}
public function deletesqlfile($sqlFilename)
{
unlink($sqlFilename);
}
public static function generaterandomstring($length = 20)
{
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0;$i <$length;$i++) {
$randomString .= $characters[rand(0,$charactersLength -1)];
}
return $randomString;
}
public function sendbackupemail($backupFile)
{
$this->load->database();
$database = $this->db->database;
$date = date('d-M-Y h:i:s') ;
$subject = $database ." , Database Backup (".$date .")";
$body = "<!DOCTYPE html>
                <html lang='en-US'>
                <head>
                    <meta charset='utf-8'>
                </head>
                <body>
                <h2>SKILL TECH CONSULTING </h2>
                <br>
                <div>
                    !السلام وعلیکم ورحمتہ اللہ وبرکاتہ
                    <br>
                    Please find attached file for database backup.
                </div>
                </body>
                </html>";
$ci = get_instance();
$ci->load->library('email');
$config['protocol'] = "smtp";
$config['smtp_host'] = "mail.alnaharsolution.com";
$config['smtp_port'] = "25";
$config['smtp_user'] = "apps@alnaharsolution.com";
$config['smtp_pass'] = 'Apps2019$#';
$config['charset'] = "utf-8";
$config['mailtype'] = "html";
$config['newline'] = "\r\n";
$ci->email->initialize($config);
$ci->email->from("apps@alnaharsolution.com",$subject);
$list = array("arshadfarouq@hotmail.com");
$ci->email->to($list);
$ci->email->subject($subject);
$ci->email->message($body);
$ci->email->attach($backupFile);
$status = $ci->email->send();
return $status;
}
}
?>