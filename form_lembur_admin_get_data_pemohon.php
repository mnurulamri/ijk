<?php
include_once("../models/conn.php");

#ambil data pemohon
$sql = "SELECT * FROM lembur_pemohon WHERE flag_transaksi = 0 ";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_pemohon[$row['nip']] = $row;
}

#ambil data lembur
$sql ="SELECT id, nip, tgl_lembur, presensi, uraian, waktu_lembur, status, keterangan, flag_libur, honor_lembur
		FROM lembur_detail
		WHERE flag_transaksi = 0
		ORDER BY tgl_lembur";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_lembur[$row['nip']][] = $row;
}

#cetak data
//echo '<pre>';
header_table();
#etak isi tabel
$total = 0;
$total_honor_lembur = 0;
$no = 1;
foreach ($data_pemohon as $key => $value){
	$total = hitung_lembur($data_lembur[$key]);
	echo '
	<tr id="'.$value['id'].'" data-nip="'.$value['nip'].'">
		<td>'.$no.'</td>
		<td>'.$value['nip'].'</td>
		<td>'.$value['nama'].'</td>
		<td>'.$value['unit_kerja'].'</td>
		<td>'.$value['golongan'].'</td>
		<td>'.$total['total_jam_hari_kerja'].'</td>
		<td>'.$total['total_jam_hari_kerja_disetujui'].'</td>
		<td>'.$total['total_jam_hari_libur'].'</td>
		<td>'.$total['total_jam_hari_libur_disetujui'].'</td>
		<td>'.number_format($total['total_honor']).'</td>
		<td class="approval"><i class="btn btn-success btn-xs">approval</i></td>
	</tr>';
	$no++;
	$total_honor_lembur += $total['total_honor'];
}

footer_table($total_honor_lembur);
//echo '</pre>';


function hitung_lembur($data_lembur){
	$total_menit_hari_kerja = 0;
	$total_menit_hari_libur = 0;
	$total_menit_hari_kerja_disetujui = 0;
	$total_menit_hari_libur_disetujui = 0;
	$total_honor = 0;
	
	$test = 0;
	foreach($data_lembur as $k=>$v)
	{
		$presensi = $v['presensi'];
		$array_waktu = explode(' - ', $presensi);
		$selesai_lembur = $array_waktu[1];
		$waktu_lembur = new DateTime( $v['waktu_lembur'] );
		$array_selesai_lembur = explode(':', $array_waktu[1]);
		$menit_selesai = $array_selesai_lembur[0] * 60 + $array_selesai_lembur[1];
		$array_lembur = explode(':', $v['waktu_lembur']);
		$menit_lembur = $array_lembur[0] * 60 + $array_lembur[1];
		$mulai_lembur = date('H:i', mktime(0, $menit_selesai - $menit_lembur ));
		
		if($v['status'] == 0){
			$status = 'Belum Disetujui';
			$honor_lembur = 0;
			$remove = '<i class="fa fa-trash" ></i>';
			$edit = '<i class="fa fa-edit" ></i>';
		} else {
			$status = 'Disetujui';
			$honor_lembur = $v['honor_lembur'];
			$remove = '';
			$edit = '';
		}
		
		$test += $menit_lembur;
		# Hitung Total Jam Lembur
		if($v['flag_libur'] == 1){
			$total_menit_hari_libur += $menit_lembur;
		} else {
			$total_menit_hari_kerja += $menit_lembur;
		}
		
		# Hitung Total Jam Lembur disetujui
		if($v['status'] == 1 and $v['flag_libur'] == 1){
			$total_menit_hari_libur_disetujui += $menit_lembur;
		} else if($v['status'] == 1 and $v['flag_libur'] == 0){
			$total_menit_hari_kerja_disetujui += $menit_lembur;
		}
		
		$total_honor += $honor_lembur;
	}
	
	$total_jam_hari_kerja = convertToHoursMins($total_menit_hari_kerja, '%02d : %02d');
	$total_jam_hari_libur = convertToHoursMins($total_menit_hari_libur, '%02d : %02d');
	
	$total_jam_hari_kerja_disetujui = convertToHoursMins($total_menit_hari_kerja_disetujui, '%02d : %02d');
	$total_jam_hari_libur_disetujui = convertToHoursMins($total_menit_hari_libur_disetujui, '%02d : %02d');

	$data = array(
		'total_jam_hari_kerja' => $total_jam_hari_kerja,
		'total_jam_hari_libur' => $total_jam_hari_libur,
		'total_jam_hari_kerja_disetujui' => $total_jam_hari_kerja_disetujui,
		'total_jam_hari_libur_disetujui' => $total_jam_hari_libur_disetujui,
		'total_honor' => $total_honor
	);
	return $data;
}

function tanggal($tgl) { // fungsi atau method untuk mengubah tanggal ke format indonesia
	// variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
	$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
	$BulanIndo = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret",
					   "04"=>"April", "05"=>"Mei", "06"=>"Juni",
					   "07"=>"Juli", "08"=>"Agustus", "09"=>"September",
					   "10"=>"Oktober", "11"=>"November", "12"=>"Desember");
	$tgl_arr = explode('-',$tgl);
	$tahun = $tgl_arr[0]; 
	$bulan = $tgl_arr[1]; 
	$hari   = $tgl_arr[2]; 
	$kd_hari  = date('D', strtotime($tgl));
	$nama_hari = $array_hari[$kd_hari];
	$result = $nama_hari.', '.$hari . " " . $BulanIndo[$bulan] . " ". $tahun;
	return($result);
}

function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function header_table(){
	echo '
	<table class="table table-bordered" id="pelaksanaan-lembur">
				<thead>
			 	<tr>
			 		<th rowspan="2">No</th>
			 		<th rowspan="2">NIP</th>
			 		<th rowspan="2">Nama</th>
					<th rowspan="2">Unit Kerja</th>
					<th rowspan="2">Gol</th>
			 		<th colspan="2">Jam Lembur<br>Hari Kerja</th>
					<th colspan="2">Jam Lembur<br>Hari Libur</th>
			 		<th rowspan="2">Honor</th>
					<th rowspan="2">Approval</th>
			 	</tr>
			<tr>
				<th>Diajukan</th>
				<th>Disetujui</th>
				<th>Diajukan</th>
				<th>Disetujui</th>
			</tr>
				</thead>
				<tbody id="data">';
}

function footer_table($total_honor_lembur){
	
	echo '
				</tbody>
				<tfoot>
					<tr>
						<th colspan="9" style="border-left:1px solid #fff;border-bottom:1px solid #fff;"></th>
						<th>'.number_format($total_honor_lembur).'</th>
						<th style="border-righ:1px solid #fff;border-bottom:1px solid #fff;"></th>
					</tr>
				</tfoot>
			</table>';
}

?>
	