<?php
//echo 'testing'; exit();
if(!session_id()) session_start();
echo '<pre>';
include_once("../models/conn.php");

//get data harga satuan
$sql = "SELECT * FROM lembur_hs";
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	$array_harga_satuan[$row[flag_libur]][$row[golongan]] = $row[harga_satuan];
}
$array_golongan = explode('/', $_POST['golongan']);
$golongan = $array_golongan[0];

if($_POST['crud'] == 1){
	//print_r($_POST);
	
	foreach($_POST['tgl_lembur'] as $k=>$v){
		$array_tgl = explode(', ', $v);
		$array_waktu = explode(' - ', $_POST['waktu'][$k]);
		
		
		$hari = $array_tgl[0];
		if($hari=='Sabtu' or $hari=='Minggu'){
			$flag = 1;
			$selesai_lembur_hari_kerja = '00:00';
			$selesai_lembur_hari_libur = $array_waktu[1];
			$jumlah_hari_lembur_hari_kerja = 0;
			$jumlah_hari_lembur_hari_libur =1;
			$jumlah_jam_lembur_hari_kerja = 0;
			$jumlah_jam_lembur_hari_libur = $_POST['jml_jam_lembur'][$k];
			$harga_satuan = $array_harga_satuan[1][$golongan];
			$honor_lembur_kerja = 0;
			$honor_lembur_libur = $harga_satuan * $jumlah_jam_lembur_hari_libur;
		} else {
			$flag = 0;
			$selesai_lembur_hari_kerja = $array_waktu[1];
			$selesai_lembur_hari_libur = '00:00';
			$jumlah_hari_lembur_hari_kerja = 1;
			$jumlah_hari_lembur_hari_libur = 0;
			$jumlah_jam_lembur_hari_kerja = $_POST['jml_jam_lembur'][$k];
			$jumlah_jam_lembur_hari_libur =0;
			$harga_satuan = $array_harga_satuan[0][$golongan];
			$honor_lembur_kerja = $harga_satuan * $jumlah_jam_lembur_hari_kerja;
			$honor_lembur_libur = 0;
		}
		$array[$k] = array(
			'nip' => $_SESSION['user_nip'],
			'tgl_lembur' => tanggalToDb($v),
			'uraian' => $_POST['uraian'][$k],
			'presensi' => $_POST['waktu'][$k],
			'waktu_lembur' => $_POST['waktu_lembur'][$k],
			'hari' => $hari,
			'selesai_lembur_hari_kerja' => $selesai_lembur_hari_kerja,
			'selesai_lembur_hari_libur' => $selesai_lembur_hari_libur,
			'jumlah_hari_lembur_hari_kerja' => $jumlah_hari_lembur_hari_kerja,
			'jumlah_hari_lembur_hari_libur' => $jumlah_hari_lembur_hari_libur,
			'jumlah_jam_lembur_hari_kerja' => $jumlah_jam_lembur_hari_kerja,
			'jumlah_jam_lembur_hari_libur' => $jumlah_jam_lembur_hari_libur,
			'harga_satuan' => $harga_satuan,
			'honor_lembur_kerja' => $honor_lembur_kerja,
			'honor_lembur_libur' => $honor_lembur_libur
		);
		 
	}
	//print_r( $array );
}

function tanggalToDb($tgl_kegiatan)
{
	$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
	$tgl_array = explode(" ", $tgl_kegiatan);
	$d = $tgl_array[1];
	$month = array_search($tgl_array[2], $bulan)+1;
	$m = (strlen($month)==2) ? $month : '0'.$month; 
	$y = $tgl_array[3];
	$tgl = $y."-".$m."-".$d;
	$tgl_kegiatan = $tgl;
	return $tgl;
}
	
//test data
echo '<table border="1" cellspcacing="1">';
echo '<tr>';
foreach($array[0] as $key=>$value){
	echo '<th>'.$key.'</th>';
}
echo '</tr>';
foreach($array as $key=>$value){
	echo '<tr>';
	foreach($value as $k=>$v){
		echo '<td>'.$v.'</td>';
	}
	echo '</tr>';
}
echo '</table>';
echo '</pre>';
?>