<?php

if(!session_id()) session_start();
date_default_timezone_set('Asia/Jakarta');
include_once("../models/conn.php");

#set tahun dan bulan
$tahun = $_POST['tahun'];
$bulan = bulan($_POST['bulan']);
//echo '<pre>';print_r($tahun); print_r($bulan); echo '</pre>'; 
$periode = $_POST['periode'];
$periode_berjalan = $_POST['periode_berjalan'];

#set nip/nup
if(!empty($_POST['nip'])){
	$nip = $_POST['nip'];
} else {
	$nip = $_SESSION['user_nip'];
}

$sql ="SELECT * FROM lembur_pemohon WHERE nip = '$nip'";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_pemohon = $row;
}
//echo '<pre>';print_r($sql); echo '</pre>'; 
$sql ="SELECT id, tgl_lembur, presensi, uraian, waktu_lembur, waktu_lembur_disetujui, 
		status, keterangan, flag_libur, honor_lembur, TIME_TO_SEC(waktu_lembur_disetujui)/60 as jumlah_menit_disetujui,
		(TIME_TO_SEC(waktu_lembur_disetujui)/3600)*harga_satuan as honor_lembur_disetujui, flag_ajukan
		FROM lembur_detail
		WHERE nip = '$nip' AND flag_transaksi = 0 AND tahun = '$tahun' AND bulan ='$bulan'
		ORDER BY tgl_lembur";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_lembur[] = $row;
}
//echo '<pre>';print_r($sql); echo '</pre>'; 
/*$status = array(
	'0' => 'Belum Disetujui',
	'1' => 'Disetujui'
);
$array_status = array(
	'Belum Disetujui',
	'Disetujui'
);*/
//echo '<pre>';print_r($data_lembur); echo '</pre>'; exit();
//echo '<pre style="background-color:#eee;">';
header_table();
printTabel($data_lembur, $periode, $periode_berjalan);
//echo '</pre>';

function printTabel($data_lembur, $periode, $periode_berjalan)
{
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
		$waktu_lembur_disetujui = new DateTime( $v['waktu_lembur_disetujui'] );
		$array_selesai_lembur = explode(':', $array_waktu[1]);
		$menit_selesai = $array_selesai_lembur[0] * 60 + $array_selesai_lembur[1];
		$array_lembur = explode(':', $v['waktu_lembur']);
		$menit_lembur = $array_lembur[0] * 60 + $array_lembur[1];
		$mulai_lembur = date('H:i', mktime(0, $menit_selesai - $menit_lembur ));
		
		//waktu lembur disetujui
		$array_lembur_disetujui = explode(':', $v['waktu_lembur_disetujui']);
		$menit_lembur_disetujui = $array_lembur_disetujui[0] * 60 + $array_lembur_disetujui[1];
		$menit_selesai_disetujui = $array_selesai_lembur_disetujui[0] * 60 + $array_selesai_lembur_disetujui[1];
		//$mulai_lembur_disetujui = date('H:i', mktime(0, $menit_selesai_disetujui - $menit_lembur_disetujui ));
		
		//bila belum mangajukan lembur aktifkan fungsi edit
		if($v['status'] == 0 AND $v['flag_ajukan'] == 0){
			$status = 'Belum Diajukan';
			$honor_lembur = 0;
			$remove = '<i class="fa fa-trash" ></i>';
			$edit = '<i class="fa fa-edit" ></i>';
			$flag = 'true';
			$waktu_lembur_disetujui = '00:00';
			$class_remove = 'remove';
			$style_remove = 'color:red; cursor:pointer;';
		} 
		//bila sudah mengajukan lembur nonaktifan fungsi edit
		else if ($v['status'] == 0 AND $v['flag_ajukan'] == 1){
			$status = 'Menunggu Persetujuan Kepala Unit';
			$honor_lembur = 0;
			$remove = '';
			$edit = '';
			$flag = 'true';
			$waktu_lembur_disetujui = '00:00';
			$class_remove = '';
			$style_remove = '';
		} else if ($v['status'] == 1){
			$status = 'Menunggu Persetujuan Manajer SDM';
			$honor_lembur = 0;
			$remove = '';
			$edit = '';
			$flag = 'false';
			$waktu_lembur_disetujui = $waktu_lembur_disetujui->format("H:i");
		} else if ($v['status'] == 2){
			$status = 'Disetujui';
			$honor_lembur = $v['honor_lembur_disetujui'];
			$remove = '';
			$edit = '';
			$flag = 'false';
			$waktu_lembur_disetujui = $waktu_lembur_disetujui->format("H:i");
		}
		
		//nonaktifkan fungsi edit
		if ($periode < $periode_berjalan) {
			$remove = '-';
			$class_remove = '';
			$style_remove = '';
		}
		
		/*//nonaktifkan fungsi edit setelah data lembur diajukan
		if($v['flag_ajukan'] == 1){
			$remove = '-';
			$class_remove = '';
			$style_remove = '';
		}
		
		if($v['flag_ajukan'] == 0){
			$status = 'Belum Diajukan';
			$remove = '-';
			$class_remove = 'remove';
			$style_remove = 'color:red; cursor:pointer;';
		}*/
		
		echo '
		<tr id="'.$v['id'].'">
			<td class="tgl-lembur">'.tanggal($v['tgl_lembur']).'</td>
			<td class="uraian" contenteditable="'.$flag.'">'.$v['uraian'].'</td>
			<td class="mulai-lembur">'.$mulai_lembur.'</td>
			<td class="selesai-lembur">'.$selesai_lembur.'</td>
			<td class="waktu-lembur">'.$waktu_lembur->format("H:i").'</td>
			<td>'.$waktu_lembur_disetujui.'</td>
			<td>'.$status.'</td>
			<td>'.$v['keterangan'].'</td>
			<td class="honor">'.number_format($honor_lembur).'</td>
			<td class="'.$class_remove.'" style="'.$style_remove.'">'.$remove.'</td>
			<!--<td class="edit" style="color:green">'.$edit.'</td>-->
		</tr>';
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
	
	$total_jam_hari_kerja = convertToHoursMins($total_menit_hari_kerja, '%02d jam %02d menit');
	$total_jam_hari_libur = convertToHoursMins($total_menit_hari_libur, '%02d jam %02d menit');
	
	$total_jam_hari_kerja_disetujui = convertToHoursMins($total_menit_hari_kerja_disetujui, '%02d jam %02d menit');
	$total_jam_hari_libur_disetujui = convertToHoursMins($total_menit_hari_libur_disetujui, '%02d jam %02d menit');
	
	footer_table($total_jam_hari_kerja, $total_jam_hari_libur, $total_jam_hari_kerja_disetujui, $total_jam_hari_libur_disetujui, $total_honor);
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

function bulan($nama_bulan){
	$array_bulan = array("Januari"=>"01", "Februari"=>"02", "Maret"=>"03",
					   "April"=>"04", "Mei"=>"05", "Juni"=>"06",
					   "Juli"=>"07", "Agustus"=>"08", "September"=>"09",
					   "Oktober"=>"10", "November"=>"11", "Desember"=>"12");
	return $array_bulan[$nama_bulan];
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
			 		<th>Hari/Tanggal</th>
			 		<th>Uraian Pekerjaan yang Dilakukan</th>
			 		<th>Mulai Lembur</th>
					<th>Selesai Lembur</th>
			 		<th>Lama Lembur</th>
					<th>Lama Lembur Disetujui</th>
					<th>Status</th>
					<th>Keterangan</th>
					<th>Honor</th>
					<th colspan="1"></th>
			 	</tr>
				</thead>
				<tbody>';
}

function footer_table($total_jam_hari_kerja, $total_jam_hari_libur, $total_jam_hari_kerja_disetujui, $total_jam_hari_libur_disetujui, $total_honor){
	//kotak isian biar sepadem
	$string = '&nbsp'; $spasi = '';
	for($i=0; $i<29; $i++){
		$spasi .= $string; 
	}
	if($total_jam_hari_kerja == ''){
		$total_jam_hari_kerja = $spasi;
	}
	if($total_jam_hari_libur == ''){
		$total_jam_hari_libur = $spasi;
	}
	
	echo '
				</tbody>
				<tfoot>
					<tr>
						<td colspan="8" style="border-left:1px solid #fff; border-bottom:1px solid #fff;"></td>
						<td style="vertical-align:middle"><b>'.number_format($total_honor).'</b></td>
						<td style="border-right:1px solid #fff; border-bottom:1px solid #fff;"></td>
					</tr>
					<tr>
						<td colspan="8" style="border-left:1px solid #fff; border-right:1px solid #fff; border-bottom:1px solid #fff;">
							<span class="total-label">Total Jam Lembur Hari Kerja </span>
							<span class="total-value">'.$total_jam_hari_kerja.'</span>
							<!--<span class="total-label">Disetujui </span>
							<span class="total-value">'.$total_jam_hari_kerja_disetujui.'</span>-->
						</td>
						<td colspan="2" style="border-right:1px solid #fff; border-left:1px solid #fff; border-bottom:1px solid #fff;"></td>
					</tr>
					<tr>
						<td colspan="8" style="border-left:1px solid #fff;  border-right:1px solid #fff; border-bottom:1px solid #fff;">
							<span class="total-label">Total Jam Lembur Hari Libur </span>
							<span class="total-value">'.$total_jam_hari_libur.'</span>
							<!--<span class="total-label">Disetujui </span>
							<span class="total-value">'.$total_jam_hari_libur_disetujui.'</span>-->
						</td>
						<td colspan="2" style="border-right:1px solid #fff; border-left:1px solid #fff; border-bottom:1px solid #fff;"></td>
					</tr>
				</tfoot>
			</table>';
}
?>