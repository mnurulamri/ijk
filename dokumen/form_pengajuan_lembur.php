<?php
//$html = 'testing...';
//$file_1 = file_get_contents('file_1.php'); //file_get_contents('form_pengajuan_lembur.htm') ;
include('../dokumen/file_1.php');
$file_1 = $html;
$file_2 = file_get_contents('form_pengajuan_lembur_files/image001.png');
$file_3 = file_get_contents('form_pengajuan_lembur_files/header.htm');
//exit();
class mime10class
{
    private $data;
    const boundary='----=_NextPart_ERTUP.EFETZ.FTYIIBVZR.EYUUREZ';
    function __construct() { $this->data="MIME-Version: 1.0\nContent-Type: multipart/related; boundary=\"".self::boundary."\"\n\n"; }
    public function addFile($filepath,$contenttype,$data)
    {
        $this->data = $this->data.'--'.self::boundary."\nContent-Location: file:///C:/".preg_replace('!\\\!', '/', $filepath)."\nContent-Transfer-Encoding: base64\nContent-Type: ".$contenttype."\n\n";
        $this->data = $this->data.base64_encode($data)."\n\n";
    }
    public function getFile() { return $this->data.'--'.self::boundary.'--'; }
}

header('Content-Type: application/msword');
header('Content-disposition: filename=form_pengajuan_lembur.doc');
//header('Cache-Control: no-cache, must-revalidate');
//header("Expires: date()");

//header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//header('Content-disposition: filename=form_pengajuan_lembur.docx');

$doc = New mime10class();

$doc->addFile('form_pengajuan_lembur.htm','text/html; charset="utf-8"', $file_1);
$doc->addFile('form_pengajuan_lembur_files\image001.png','image/png;', $file_2);
$doc->addFile('form_pengajuan_lembur_files\header.htm','text/html; charset="utf-8"', $file_3);

echo $doc->getFile();
?>