<?php
if(!session_id()) session_start();
#ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');
include_once("../models/conn.php");
include("fungsi.php");

$nip = $_POST['nip'];
$tahun = $_POST['tahun'];
$bulan = bulan($_POST['bulan']);

$array_bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$array_bulan1 = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05', 'Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
$array_bulan2 = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$m = date('n');
$day = date('d');
$tahun = date('Y');

if ($day <= 11){
	$bulan_sekarang = $array_bulan[ $m-1 ];
} else {
	$bulan_sekarang = $array_bulan[ $m ];
}
$periode_berjalan = $tahun.$array_bulan1[$bulan_sekarang];
$periode = $tahun.$bulan;

/*
$sql ="SELECT * FROM lembur_pemohon WHERE nip = '$nip' AND flag_transaksi = 0";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_pemohon['nama'] = $row['nama'];
	$data_pemohon['golongan'] = $row['golongan'];
	$data_pemohon['nip'] = $row['nip'];
	$data_pemohon['unit_kerja'] = $row['unit_kerja'];
}
*/
$sql ="SELECT id, tgl_lembur, presensi, uraian, waktu_lembur, waktu_lembur_disetujui, 
		status, keterangan, flag_libur, honor_lembur, TIME_TO_SEC(waktu_lembur_disetujui)/60 as jumlah_menit_disetujui,
		(TIME_TO_SEC(waktu_lembur_disetujui)/3600)*harga_satuan as honor_lembur_disetujui, flag_ajukan,
		CONCAT(tahun,bulan) as periode
		FROM lembur_detail
		WHERE nip = '$nip' AND flag_transaksi = 0 AND tahun = $tahun AND bulan = '$bulan'
		ORDER BY tgl_lembur";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_lembur[] = $row;
}

function printTabel($data_lembur)
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
		
		//bila mengajukan nonaktifkan fungsi edit
		if($v['status'] == 0 AND $v['flag_ajukan'] == 0){
			$status = 'Belum Diajukan';
			$honor_lembur = 0;
			$remove = '';
			$edit = '';
			$checkbox = '';
			$flag = 'true';
			$rollback = '';
			$waktu_lembur_disetujui = '00:00';
		} 
		//bila sudah mengajukan aktifkan fungsi edit
		else if($v['status'] == 0 AND $v['flag_ajukan'] == 1){
			$status = 'Menunggu Persetujuan Kepala Unit';
			$honor_lembur = 0;
			$remove = '<i class="fa fa-trash" ></i>';
			$edit = '<i class="fa fa-edit" ></i>';
			$checkbox = '<input type="checkbox" class="approval-check" value="'.$v['id'].'"/>';
			$flag = 'true';
			$rollback = '<input type="checkbox" class="rollback-check" value="'.$v['id'].'"/>';
			$waktu_lembur_disetujui = '00:00';
		} else if ($v['status'] == 1){
			$status = 'Menunggu Persetujuan Manajer SDM';
			$honor_lembur = $v['honor_lembur_disetujui'];
			$remove = '';
			$edit = '';
			$checkbox = '';
			$flag = 'false';
			$rollback = '<input type="checkbox" class="rollback-check" value="'.$v['id'].'"/>';
			$waktu_lembur_disetujui = $waktu_lembur_disetujui->format("H:i");
		} else if ($v['status'] == 2){
			$status = 'Disetujui';
			$honor_lembur = $v['honor_lembur_disetujui'];
			$remove = '';
			$edit = '';
			$checkbox = '';
			$flag = 'false';
			$rollback = '';
			$waktu_lembur_disetujui = $waktu_lembur_disetujui->format("H:i");
		}
		
		#jika yg dipilih adalah periode yg lama maka nonaktifkan fungsi approval dan fungsi edit
		/*
		if($v['periode'] < periode_berjalan()){ 
			$remove = '';
			$edit = '';
			$checkbox = '';
			$rollback = '';
		}
		*/
		echo '
		<tr id="'.$v['id'].'">
			<td width="160px">'.tanggal($v['tgl_lembur']).'</td>
			<td>'.$v['uraian'].'</td>
			<td>'.$mulai_lembur.'</td>
			<td>'.$selesai_lembur.'</td>
			<td>'.$waktu_lembur->format("H:i").'</td>
			<td class="waktu_lembur_disetujui" contenteditable="true">'.$waktu_lembur_disetujui.'</td>
			<td>'.$status.'</td>
			<td class="keterangan" contenteditable="true">'.$v['keterangan'].'</td>
			<td class="honor">'.number_format($honor_lembur).'</td>
			<td style="color:red">'.$checkbox.'</td>
			<td>'.$rollback.'</td>
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
	
	footer_table($total_jam_hari_kerja, $total_jam_hari_libur, $total_jam_hari_kerja_disetujui, $total_jam_hari_libur_disetujui, $total_honor, $total_menit_hari_kerja, $total_menit_hari_libur);
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
	//$result = $nama_hari.', '.$hari . " " . $BulanIndo[$bulan] . " ". $tahun;
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
			 		<th style="background-color:gray">Hari/Tanggal</th>
			 		<th>Uraian Pekerjaan yang Dilakukan</th>
			 		<th>Mulai Lembur</th>
					<th>Selesai Lembur</th>
			 		<th>Lama Lembur</th>
					<th>Lama Lembur Disetujui</th>
					<th>Status</th>
					<th>Keterangan</th>
					<th>Honor</th>
					<th><input type="checkbox" name="approval-check-all" class="approval-check-all">Disetujui</th>
					<th><input type="checkbox" name="rollback-check-all" class="rollback-check-all">Ditolak</th>
			 	</tr>
				</thead>
				<tbody>';
}

function footer_table($total_jam_hari_kerja, $total_jam_hari_libur, $total_jam_hari_kerja_disetujui, $total_jam_hari_libur_disetujui, $total_honor, $total_menit_hari_kerja, $total_menit_hari_libur){
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
	$total_jam_hari_kerja_disetujui = ($total_jam_hari_kerja_disetujui == '') ? $spasi : $total_jam_hari_kerja_disetujui;
	$total_jam_hari_libur_disetujui = ($total_jam_hari_libur_disetujui == '') ? $spasi : $total_jam_hari_libur_disetujui;
	
	$warning_kerja = ($total_menit_hari_kerja > 1500) ? '<font class="text-danger">&nbsp;&nbsp;lebih dari 25 jam!..</font>' : '';
	$warning_libur = ($total_menit_hari_libur > 1500) ? '<font class="text-danger">&nbsp;&nbsp;lebih dari 25 jam!...</font>' : '';

	echo '
				</tbody>
				<tfoot>
					<tr>
					<td colspan="11" style="border-left:1px solid #fff; border-right:1px solid #fff; border-bottom:1px solid #fff;"></td>
					</tr>
					<tr>
						<td colspan="7" style="border-left:1px solid #fff; border-bottom:1px solid #fff; border-right:1px solid #fff;">
							<span class="total-label">Total Jam Lembur Hari Kerja </span>
							<span class="total-value">'.$total_jam_hari_kerja.'</span>
							<span class="total-label">Disetujui </span>
							<span class="total-value">'.$total_jam_hari_kerja_disetujui.'</span>
							<span class="warning">'.$warning_kerja.'</span>
						</td>
						<td rowspan="2" style="border-left:1px solid #fff; border-bottom:1px solid #fff;"></td>
						<td rowspan="2" style="vertical-align:middle; border-top:1px solid gray; ">'.number_format($total_honor).'</td>
					</tr>
					<tr>
						<td colspan="7" style="border-left:1px solid #fff; border-bottom:1px solid #fff;">
							<span class="total-label">Total Jam Lembur Hari Libur </span>
							<span class="total-value">'.$total_jam_hari_libur.'</span>
							<span class="total-label">Disetujui </span>
							<span class="total-value">'.$total_jam_hari_libur_disetujui.'</span>
							<span class="warning">'.$warning_libur.'</span>
						</td>
					</tr>
				</tfoot>
			</table>';
}
//echo '<pre style="background-color:#eee;">';

if ($periode >= $periode_berjalan) {
	echo '
	<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;" id="info-persetujuan">
		<!--<li>Bila status Belum Disetujui maka persetujuan lembur belum dapat dilakukan </li>-->
		<!--<li>Tekan tombol <input type="checkbox"> (checkbox) pada kolom Disetujui untuk memilih item lembur yang akan disetujui.</li>-->
		<li>Silahkan tekan tombol <font class="label label-primary">Ajukan</font> untuk menyetujui dan meningkatkan status menjadi "Menunggu Persetujuan Manajer SDM"</li>
		<!--<li>Setelah memilih item lembur, silahkan tekan tombol <font class="label label-primary">approve</font> untuk memberikan persetujuan. Selanjutnya secara otomatis status akan berubah menjadi "Menunggu Persetujuan Manajer SDM"</li>-->
		<!--<li>Untuk pembatalan item lembur yang sudah disetujui, tekan tombol <input type="checkbox"> (checkbox) pada kolom rollback, kemudian tekan tombol <font class="label label-warning">rollback</font></li>-->
	</ul>';
}
		
#cetak data
header_table();
printTabel($data_lembur);
//echo '</pre>';
?>