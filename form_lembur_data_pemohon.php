<?php
#include("../models/conn2.php"); -> untuk knyetak msword pake ini nggak jalan ????
#include("https://remun.ppaa.fisip.ui/ijk/libraries/unit_Kerja.php");

$mysqli = mysql_connect($server,$user,$pass) or die('error connecting mysql');
mysql_select_db($db,$mysqli) or die('Database tidak ditemukan');

if(!session_id()) session_start();
$nip = $_SESSION['user_nip'];

//ambil tahun terakhir
$sql = "SELECT DISTINCT(MAX(SUBSTR(periode, 7, 4))) as tahun FROM ijk"; 
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_object($result)) {
	$tahun = $row->tahun;
}

//ambil bulan terakhir
$sql="SELECT DISTINCT(MAX(SUBSTR(periode, 1, 2))) as bulan 
FROM ijk 
WHERE SUBSTR(periode, 1, 2) < 13 AND SUBSTR(periode, 7, 4) = '$tahun'"; 
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_object($result)) {
	$bulan = $row->bulan;
}

//ambil data unit kerja
$sql = "SELECT unit_kerja_ijk, unit_kerja_real FROM cek_unit_kerja";
$query = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_assoc($query)){
	$array_unit_kerja[$row['unit_kerja_ijk']] = $row['unit_kerja_real'];
}

//ambil data karwayan
$sql = "SELECT DISTINCT nip, nama, 'Staf' as jabatan, Gol_Gapok as golongan, unit_kerja
		FROM ijk
		WHERE SUBSTR(periode, 1, 2) = '$bulan' AND SUBSTR(periode, 7, 4) = '$tahun' AND nip = '$nip' ";
$query = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_assoc($query)){
	//$data[] = $row;
	if (empty($array_unit_kerja[$row['unit_kerja']])) {
		$unit_kerja = $row['unit_kerja'];
	} else {
		$unit_Kerja = $array_unit_kerja[$row['unit_kerja']];
	}

	$data = array(
		'nip'=>$row['nip'],
		'nama'=>$row['nama'],
		'golongan'=>$row['golongan'],
		'unit_kerja'=>$unit_Kerja
	);
}

#cek data deskripsi
$sql = "SELECT deskripsi FROM lembur_pemohon WHERE nip = '$nip' AND flag_transaksi = 0";
$query = mysql_query($sql) or die(mysql_error());
$num_rows = mysql_num_rows($result);
if($num_rows > 0){
	while ($row = mysql_fetch_assoc($query)){
		$deskripsi = $row[deskripsi];
	}
}

$data['deskripsi'] = $deskripsi;

//echo json_encode($data);

/*
echo '
$("#nip").val()
$("#nama").val()
$("#jabatan").val()
$("#unit_kerja").val()
';


echo '<pre>';
print_r($data);
echo '</pre>';
*/
?>
