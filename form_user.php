<?php
include "../models/conn.php";
$sql = "SELECT * FROM file_ijk WHERE file_dok = 1";
$result = mysql_query($sql) or die( mysql_error() );
while( $row = mysql_fetch_object($result) ){
	$data[] = $row;
}
$i=1;
$html = '
<table class="table">
	<th> No </th>
	<th> Nomor Formulir </th>
	<th> Nama Formulir </th>
	<th> Aksi </th>
';
foreach($data as $k => $v){
	$nama_file = $v->file_kode.'.doc';
	$html.= '
	<tr>
		<td>'. $i .'</td>
		<td>'. $v->file_kode .'</td>
		<td>'. $v->file_name .'</td>
		<td> <a href="dokumen/'. $nama_file .'"> download </a> </td>
	</tr>';
	$i++;
}
$html .= '</table>';
echo $html;
?>