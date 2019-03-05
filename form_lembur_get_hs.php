<?php
//echo 'testing'; exit();
if(!session_id()) session_start();
#echo '<pre>';
include_once("../models/conn.php");
//get data harga satuan
$sql = "SELECT * FROM lembur_hs";
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	$array_harga_satuan[$row[flag_libur]][$row[golongan]] = $row[harga_satuan];
}
$array_golongan = explode('/', $_POST['golongan']);
$golongan = $array_golongan[0];
$jml_jam = $_POST['jml_menit'] / 60;
$tgl_lembur = $_POST['tgl_lembur'];

if(!empty($tgl_lembur))
{
	$array_tgl = explode(', ', $tgl_lembur);
	$array_waktu = explode(' - ', $_POST['waktu'][$k]);
	$hari = $array_tgl[0];
	if($hari=='Sabtu' or $hari=='Minggu'){
		$harga_satuan = $array_harga_satuan[1][$golongan];		
	} else {
		$harga_satuan = $array_harga_satuan[0][$golongan];
	}
	$honor_lembur = $harga_satuan * $jml_jam;
	
	$data = array(
		'text' => number_format($honor_lembur),
		'number' => $honor_lembur
	);
	
	echo json_encode($data);
}
#echo '<pre>';
?>