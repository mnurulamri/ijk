<?php
include_once("../models/conn.php");
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

//ambil data karwayan
$sql = "SELECT DISTINCT nip, nama, 'Staf' as jabatan, Gol_Gapok as golongan, unit_kerja
		FROM ijk
		WHERE SUBSTR(periode, 1, 2) = '$bulan' AND SUBSTR(periode, 7, 4) = '$tahun' AND nip = '$nip' ";
$query = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_assoc($query)){
	//$data[] = $row;
	$data = array(
		'nip'=>$row['nip'],
		'nama'=>$row['nama'],
		'jabatan'=>$row['jabatan'],
		'golongan'=>$row['golongan'],
		'unit_kerja'=>$row['unit_kerja']
	);
}
echo json_encode($data);
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