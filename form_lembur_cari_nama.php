<?php
include_once("../models/conn.php");
//if(!session_id()) session_start();
//$kd_organisasi = $_SESSION["kode"];


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
$kata = $_POST['q'];
$sql = "SELECT DISTINCT nip, nama, 'Staf' as jabatan, unit_kerja
		FROM ijk
		WHERE SUBSTR(periode, 1, 2) = '$bulan' AND SUBSTR(periode, 7, 4) = '$tahun' AND nama like '%$kata%' ";
$query = mysql_query($sql) or die(mysql_error());

echo '
<table class="autocomplete">
	<tr>
		<th>NPM/NIP/NUP</th>
		<th>Nama</th>
		<th>Jabatan</th>
		<th>PAF/Dept/Prodi</th>
	</tr>';
	while($k = mysql_fetch_array($query)){
		echo '

		<tr class="isi" id="'.$k[0].'">
			<td>'.$k[0].'</td>
			<td>'.$k[1].'</td>
			<td>'.$k[2].'</td>
			<td>'.$k[3].'</td>
		</tr>';
	}
echo '
	</table>';
?>

<style>
table.autocomplete {
	width:400px;
	position: absolute;
	z-index: 99;
}
table.autocomplete tr {
	cursor: pointer;
}
table.autocomplete tr th {
	background-color: lightgray;
	border: 1px solid lightgray;
	padding: 5px;
	font-size: 12px;
}
table.autocomplete tr td {
	background-color: #fafafa;
	border: 1px solid lightgray;
	padding: 5px;
	font-size: 12px;
}
</style>