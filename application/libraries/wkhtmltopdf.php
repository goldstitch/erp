
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


class WkHtmlToPdf
{
protected $binPath='C:\wkhtmltopdf\wkhtmltopdf.exe';
protected $binName = '';
protected $enableEscaping = true;
protected $version9 = false;
protected $options = array();
protected $pageOptions = array();
protected $objects = array();
protected $tmp;
protected $tmpFile;
protected $tmpFiles = array();
protected $procEnv;
protected $isWindows;
protected $enableXvfb = false;
protected $xvfbRunBin;
protected $xvfbRunOptions = ' --server-args="-screen 0, 1024x768x24" ';
protected $error;
protected $localOptions = array(
'binName',
'binPath',
'tmp',
'enableEscaping',
'version9',
'procEnv',
'enableXvfb',
'xvfbRunBin',
'xvfbRunOptions',
);
const REGEX_HTML = '/<html/i';
public function __construct($options=array())
{
if ($options!==array()) {
$this->setOptions($options);
}
}
public function __destruct()
{
if ($this->tmpFile!==null) {
unlink($this->tmpFile);
}
foreach($this->tmpFiles as $tmp) {
unlink($tmp);
}
}
public function addPage($input,$options=array())
{
$options['input'] = preg_match(self::REGEX_HTML,$input) ?$this->createTmpFile($input) : $input;
$this->objects[] = array_merge($this->pageOptions,$this->processOptions($options));
}
public function addCover($input,$options=array())
{
$options['input'] = ($this->version9 ?'--': '')."cover $input";
$this->objects[] = array_merge($this->pageOptions,$options);
}
public function addToc($options=array())
{
$options['input'] = ($this->version9 ?'--': '')."toc";
$this->objects[] = $options;
}
public function saveAs($filename)
{
if (($pdfFile = $this->getPdfFilename())===false) {
return false;
}
copy($pdfFile,$filename);
return true;
}
public function send($filename=null,$inline=false)
{
if (($pdfFile = $this->getPdfFilename())===false) {
return false;
}
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Type: application/pdf');
header('Content-Transfer-Encoding: binary');
header('Content-Length: '.filesize($pdfFile));
if ($filename!==null ||$inline) {
$disposition = $inline ?'inline': 'attachment';
header("Content-Disposition: $disposition; filename=\"$filename\"");
}
readfile($pdfFile);
return true;
}
public function setOptions($options=array())
{
$options = $this->processOptions($options);
foreach ($options as $key=>$val) {
if(in_array($key,$this->localOptions,true)) {
$this->$key = $val;
}elseif (is_int($key)) {
$this->options[] = $val;
}else {
$this->options[$key] = $val;
}
}
}
public function setPageOptions($options=array())
{
$this->pageOptions = $this->processOptions($options);
}
public function processOptions($options=array())
{
foreach ($options as $key=>$val) {
if (preg_match('/^(header|footer)-html$/',$key) &&
!(is_file($val) ||preg_match('/^(https?:)?\/\//i',$val) ||$val===strip_tags($val))) {
$options[$key] = $this->createTmpFile($val);
}
}
return $options;
}
public function getBin()
{
if ($this->binPath===null) {
if ($this->getIsWindows()) {
return '';
}else {
$this->binPath = trim(shell_exec('which '.$this->binName));
}
}
return $this->binPath;
}
public function getXvfbRunBin()
{
if ($this->xvfbRunBin===null) {
if ($this->getIsWindows()) {
return null;
}else {
$this->xvfbRunBin = trim(shell_exec('which xvfb-run'));
}
}
return $this->xvfbRunBin;
}
public function getIsWindows()
{
if ($this->isWindows===null) {
$this->isWindows = strtoupper(substr(PHP_OS,0,3))==='WIN';
}
return $this->isWindows;
}
public function getError()
{
return $this->error;
}
public function getTmpDir()
{
if ($this->tmp===null) {
$this->tmp = sys_get_temp_dir();
}
return $this->tmp;
}
public function getCommand($filename)
{
$command = $this->escape($this->getBin());
$command .= $this->renderOptions($this->options);
foreach($this->objects as $object)
{
$command .= ' '.$this->escape($object['input']);
unset($object['input']);
$command .= $this->renderOptions($object);
}
return $command.' '.$filename;
}
public function getPdfFilename()
{
if ($this->tmpFile===null) {
$tmpFile = tempnam($this->getTmpDir(),'tmp_WkHtmlToPdf_');
if ($this->createPdf($tmpFile)===true) {
$this->tmpFile = $tmpFile;
}else {
return false;
}
}
return $this->tmpFile;
}
protected function createPdf($fileName)
{
$command = $this->getCommand($fileName);
if($this->enableXvfb) {
$command = $this->xvfbRunCommand($command);
}
$descriptors = array(
2   =>array('pipe','w'),
);
$command = exec( $command );
return $this->error===null;
}
protected function createTmpFile($content)
{
$tmpFile = tempnam($this->getTmpDir(),'tmp_WkHtmlToPdf_');
rename($tmpFile,($tmpFile.='.html'));
file_put_contents($tmpFile,$content);
$this->tmpFiles[] = $tmpFile;
return $tmpFile;
}
protected function renderOptions($options)
{
$out = '';
foreach($options as $key=>$val)
if (is_numeric($key)) {
$out .= " --$val";
}elseif (is_array($val)) {
foreach($val as $vkey =>$vval) {
if(is_numeric($vkey)) {
$out .= " --$key ".$this->escape($vval);
}else {
$out .= " --$key ".$this->escape($vkey).' '.$this->escape($vval);
}
}
}else {
$out .= " --$key ".$this->escape($val);
}
return $out;
}
protected function escape($val)
{
return $this->enableEscaping ?escapeshellarg($val) : $val;
}
protected function xvfbRunCommand($command)
{
$xvfbRun = $this->getXvfbRunBin();
if(!$xvfbRun) {
return $command;
}
return $xvfbRun.$this->xvfbRunOptions.$command;
}
}

?>