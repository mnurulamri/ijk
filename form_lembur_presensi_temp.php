<?php
if(!session_id()) session_start();
include('../models/conn.php');

$nip = $_SESSION['user_nip'];

//ambil data bidang
$sql= "SELECT KodeBidang FROM TblPegawai WHERE nip = '$nip'";
//echo $sql; exit();
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_object($result))
{
	$kode_bidang = $row->KodeBidang;
}

if ($kode_bidang == '023'or $kode_bidang == '024' or $kode_bidang == '025') {
	include('presensi_satpam.php');
} else {
	include('form_lembur_presensi.php');
}


?>