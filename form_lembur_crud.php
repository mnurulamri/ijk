<?php
//echo 'testing'; exit();
if(!session_id()) session_start();

include_once("../models/conn.php");

//get data harga satuan
$sql = "SELECT * FROM lembur_hs";
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	$array_harga_satuan[$row[flag_libur]][$row[golongan]] = $row[harga_satuan];
}

$array_golongan = explode('/', $_POST['golongan']);
$golongan = $array_golongan[0];

$tahun = (!empty($_POST['tahun'])) ? $_POST['tahun'] : '' ;

$array_bulan = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05', 'Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','Nopember'=>'11','Desember'=>'12');
$post_bulan = (!empty($_POST['bulan'])) ? $_POST['bulan'] : '' ;
$bulan = $array_bulan[$post_bulan];

$nama = (!empty($_POST['nama'])) ? $_POST['nama'] : '' ;
$unit_kerja = (!empty($_POST['unit_kerja'])) ? $_POST['unit_kerja'] : '' ;
$deskripsi = (!empty($_POST['deskripsi'])) ? $_POST['deskripsi'] : '' ;

/*
$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$nama = $_POST['nama'];
$unit_kerja = $_POST['unit_kerja'];
$deskripsi = $_POST['deskripsi'];
*/
#set data untuk tabel data pemohon
$data_pemohon = array(
	'tahun' => $tahun,
	'bulan' => $bulan,
	'nip' => $_POST['nip'],
	'nama' => $nama,
	'golongan' => $_POST['golongan'],
	'unit_kerja' => $unit_kerja,
	'deskripsi' => $deskripsi
);

if($_POST['crud'] == 1)
{
	$waktu = $_POST['waktu'];
	
	/*$nama = $_POST['nama'];
	$jabatan = $_POST['jabatan'];
	//$golongan = $_POST['golongan'];
	$unit_kerja = $_POST['unit_kerja'];
	$deskripsi = $_POST['deskripsi'];

	#set data untuk tabel data pemohon
	$data_pemohon = array(
		'tahun' => $tahun,
		'bulan' => $bulan,
		'nip' => $_POST['nip'],
		'nama' => $nama,
		'golongan' => $golongan,
		'unit_kerja' => $unit_kerja,
		'deskripsi' => $deskripsi
	);
	*/
	#insert data pemohon
	

	#data detail lembur
	foreach($_POST['tgl_lembur'] as $k=>$v){
		$array_tgl = explode(', ', $v);
		$array_waktu = explode(' - ', $waktu[$k]);
		
		$selesai_lembur = $array_waktu[1];
		$jumlah_menit = getMenit($_POST['waktu_lembur'][$k]);
		$jumlah_jam_lembur = $_POST['jml_jam_lembur'][$k];
		
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
		
		$honor_lembur = $harga_satuan * ( $jumlah_menit / 60 );
		$honor_lembur = number_format($honor_lembur);
		$honor_lembur = str_replace(',', '', $honor_lembur);
		
		//set data untuk tabel lembur detail
		$array[$k] = array(
			'tahun' => $tahun,
			'bulan' => $bulan,
			'nip' => $_SESSION['user_nip'],
			'tgl_lembur' => tanggalToDb($v),
			'uraian' => $_POST['uraian'][$k],
			'presensi' => $_POST['waktu'][$k],
			'flag_libur' => $flag,
			'waktu_lembur' => $_POST['waktu_lembur'][$k],
			'selesai_lembur' => $selesai_lembur,
			'jumlah_menit' => $jumlah_menit,
			'harga_satuan' => $harga_satuan,
			'honor_lembur' => $honor_lembur,
			'tgl_input' => date("Y-m-d H:i:s")
		);
	}
	
	#insert data lembur
	echo '<pre>';
	insertDataPemohon($data_pemohon);
	insertDataLembur($array);
	echo '</pre>';
} 
else if($_POST['crud'] == 2)
{
	
	$array_tgl = explode(', ', $_POST['tgl_lembur']);
	$array_waktu = explode(' - ', $_POST['waktu']);
		
	$selesai_lembur = $array_waktu[1];
	$jumlah_menit = getMenit($_POST['waktu_lembur']);
	
	$hari = $array_tgl[0];
		if($hari=='Sabtu' or $hari=='Minggu'){
			$flag = 1;
			$harga_satuan = $array_harga_satuan[1][$golongan];
		} else {
			$flag = 0;
			$harga_satuan = $array_harga_satuan[0][$golongan];
		}
	
	$honor_lembur = $harga_satuan * ( $jumlah_menit / 60 );
	$honor_lembur = number_format($honor_lembur);
	$honor_lembur = str_replace(',', '', $honor_lembur);
		
	//set data untuk tabel lembur detail
		$array[0] = array(
			'tahun' => $tahun,
			'bulan' => $bulan,
			'nip' => $_SESSION['user_nip'],
			'tgl_lembur' => tanggalToDb($_POST[tgl_lembur]),
			'uraian' => $_POST['uraian'],
			'presensi' => $_POST['waktu'],
			'flag_libur' => $flag,
			'waktu_lembur' => $_POST['waktu_lembur'],
			'selesai_lembur' => $selesai_lembur,
			'jumlah_menit' => $jumlah_menit,
			'harga_satuan' => $harga_satuan,
			'honor_lembur' => $honor_lembur,
			'tgl_input' => date("Y-m-d H:i:s")
		);
		
	echo '<pre>';
	insertDataPemohon($data_pemohon);
	insertDataLembur($array);
	echo '</pre>';
} 
else if($_POST['crud'] == 3)
{
	$id = mysql_real_escape_string($_POST['id']);
	$sql = "DELETE FROM lembur_detail WHERE id = '$id'";
	$result = mysql_query($sql) or die(mysql_error());
} 
else if($_POST['crud'] == 4)
{
	$nip = mysql_real_escape_string($_POST['nip']);
	$deskripsi = mysql_real_escape_string($_POST['deskripsi']);
	echo $sql = "UPDATE lembur_pemohon SET deskripsi = '$deskripsi' WHERE nip='$nip' AND flag_transaksi = 0";
	$result = mysql_query($sql) or die(mysql_error());
} 
else if($_POST['crud'] == 5)
{ //approval
	//print_r($_POST['id']);
	$id = '';
	$count = count($_POST['id']) - 1;
	foreach ($_POST['id'] as $k => $v){
		if($k < $count){
			$id.= $v.',';
		} else {
			$id.= $v;
		}
		//echo $k.'=>'.$count;
	}
	//$id = mysql_real_escape_string($_POST['id']);
	$sql = "UPDATE lembur_detail SET status = '1' WHERE id in ($id) AND flag_transaksi = 0";
	$result = mysql_query($sql) or die(mysql_error());
} 
else if($_POST['crud'] == 6)
{ //rollback	
	$id = '';
	$count = count($_POST['id']) - 1;
	foreach ($_POST['id'] as $k => $v){
		if($k < $count){
			$id.= $v.',';
		} else {
			$id.= $v;
		}
		//echo $k.'=>'.$count;
	}
	//$id = mysql_real_escape_string($_POST['id']);
	$sql = "UPDATE lembur_detail SET status = '0' WHERE id in ($id) AND flag_transaksi = 0";
	$result = mysql_query($sql) or die(mysql_error());
} 
else if($_POST['crud'] == 7)
{ //update keterangan
	$id = mysql_real_escape_string($_POST['id']);
	$field = mysql_real_escape_string($_POST['field']);
	$value = mysql_real_escape_string($_POST['value']);
	$sql = "UPDATE lembur_detail SET $field = '$value' WHERE id = $id";
	$result = mysql_query($sql) or die(mysql_error());
	echo 'data sudah disimpan';
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

function getMenit($timeStr)
{   
	$str = explode(':', $timeStr);    
    $jam = $str[0];
    $menit = $str[1];
    $totalMenit = $jam * 60 + $menit;    
    return $totalMenit;
};

//test data
echo '<pre>';
print_r($array);
//printTabel($array);
echo '</pre>';

function insertDataPemohon($data)
{
	$counts = count($data);
	$values = '';
	$field = '';
	$i = 1;
	foreach($data as $k => $v){
		if($i < count($data)){
			$field .= $k.',';
			$values .= "'".mysql_real_escape_string($v)."', ";
		} else {
			$field .= $k;
			$values .= "'".mysql_real_escape_string($v)."'";
		}
		$i++;
	}
	$nip = $_SESSION[user_nip];
	$query = "SELECT nip FROM lembur_pemohon WHERE flag_transaksi = 0 AND nip = '$nip'";
	$result = mysql_query($query) or die(mysql_error());
	echo $num_rows = mysql_num_rows($result);
	if($num_rows == 0){
		echo $sql = "INSERT INTO lembur_pemohon ( $field ) VALUES ( $values )";
		$result = mysql_query($sql) or die(mysql_error());
	} else {
		echo '<pre>ada data</pre>';
	}
}

function insertDataLembur($data)
{
	$values = '';
	$field = '';
	$i = 1;
	
	foreach($data[0] as $k=>$v){
		if($i < count($data[0])){
			$field .= $k.', ';
		} else {
			$field .= $k;
		}
		$i++;
	}
	
	$values = '';
	$values = '';
	$j = 1;
	$k=1;
	
	foreach($data as $keys=>$values){
		$value .= '(';
		foreach($values as $key=>$v){
			if($k < count($data[0])){
				$value .= "'".mysql_real_escape_string($v)."', ";
			} else {
				$value .= "'".mysql_real_escape_string($v)."'";
			}
			$k++;
		}
		
		if($j < count($data)){
			$value .= '), ';
		} else {
			$value .= ')';
		}
		
		$k=1;
		$j++;
	}
	
	echo $sql = "INSERT INTO lembur_detail ( $field ) VALUES $value ";
	$result = mysql_query($sql) or die(mysql_error());
}

function printTabel($data)
{
	echo '<table border="1" cellspcacing="1" cellpadding="2px">';
	echo '<tr>';
	foreach($data[0] as $key=>$value){
		echo '<th>'.$key.'</th>';
	}
	echo '</tr>';
	foreach($data as $key=>$value){
		echo '<tr>';
		foreach($value as $k=>$v){
			echo '<td>'.$v.'</td>';
		}
		echo '</tr>';
	}	
	echo '</table>';
}
?>