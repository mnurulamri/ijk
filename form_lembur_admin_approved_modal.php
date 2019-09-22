<?php
if(!session_id()) session_start();
date_default_timezone_set('Asia/Jakarta');
include_once("../models/conn.php");
$nip = $_POST['nip'];
$tahun = $_POST['tahun'];
$bulan = bulan($_POST['bulan']);
function bulan($nama_bulan){
	$array_bulan = array("Januari"=>"01", "Februari"=>"02", "Maret"=>"03",
					   "April"=>"04", "Mei"=>"05", "Juni"=>"06",
					   "Juli"=>"07", "Agustus"=>"08", "September"=>"09",
					   "Oktober"=>"10", "November"=>"11", "Desember"=>"12");
	return $array_bulan[$nama_bulan];
}

$sql ="SELECT * FROM lembur_pemohon WHERE nip = '$nip' AND flag_transaksi = 0";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_assoc($result)){
	$data_pemohon['nama'] = $row['nama'];
	$data_pemohon['golongan'] = $row['golongan'];
	$data_pemohon['nip'] = $row['nip'];
	$data_pemohon['unit_kerja'] = $row['unit_kerja'];
}
/*
$sql ="SELECT id, tgl_lembur, presensi, uraian, waktu_lembur, status, keterangan, flag_libur, honor_lembur
		FROM lembur_detail
		WHERE nip = '$nip' AND flag_transaksi = 0
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
			$checkbox = '<input type="checkbox" class="approval-check" value="'.$v['id'].'"/>';
		} else {
			$status = 'Disetujui';
			$honor_lembur = $v['honor_lembur'];
			$remove = '';
			$edit = '';
			$checkbox = '';
		}
		
		echo '
		<tr id="'.$v['id'].'">
			<td width="160px">'.tanggal($v['tgl_lembur']).'</td>
			<td>'.$v['uraian'].'</td>
			<td>'.$mulai_lembur.'</td>
			<td>'.$selesai_lembur.'</td>
			<td>'.$waktu_lembur->format("H:i").'</td>
			<td>'.$status.'</td>
			<td class="keterangan">'.$v['keterangan'].'</td>
			<td class="honor">'.number_format($honor_lembur).'</td>
			<td style="color:red">'.$checkbox.'</td>
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
			 		<th>Hari/Tanggal</th>
			 		<th>Uraian Pekerjaan yang Dilakukan</th>
			 		<th>Mulai Lembur</th>
					<th>Selesai Lembur</th>
			 		<th>Lama Lembur</th>
					<th>Status</th>
					<th>Keterangan</th>
					<th>Honor</th>
					<th>Approve</th>
			 	</tr>
				</thead>
				<tbody>';
}

function footer_table($total_jam_hari_kerja, $total_jam_hari_libur, $total_jam_hari_kerja_disetujui, $total_jam_hari_libur_disetujui, $total_honor){
	
	echo '
				</tbody>
				<tfoot>
					<tr>
					<td colspan="8" style="border-left:1px solid #fff; border-bottom:1px solid #fff;"></td>
					</tr>
					<tr>
						<td colspan="7" style="border-left:1px solid #fff; border-bottom:1px solid #fff;">
							<span class="total-label">Total Jam Lembur Hari Kerja </span>
							<span class="total-value">'.$total_jam_hari_kerja.'</span>
							<span class="total-label">Disetujui </span>
							<span class="total-value">'.$total_jam_hari_kerja_disetujui.'</span>
						</td>
						<td rowspan="2" style="vertical-align:middle">'.number_format($total_honor).'</td>
					</tr>
					<tr>
						<td colspan="7" style="border-left:1px solid #fff; border-bottom:1px solid #fff;">
							<span class="total-label">Total Jam Lembur Hari Libur </span>
							<span class="total-value">'.$total_jam_hari_libur.'</span>
							<span class="total-label">Disetujui </span>
							<span class="total-value">'.$total_jam_hari_libur_disetujui.'</span>
						</td>
					</tr>
				</tfoot>
			</table>';
}
*/
?>

<div style="text-align:center; font-weight:bold;padding:10px">
	- Periode <?=$_POST['bulan']?> <?=$tahun?> -
</div>
<div>
    <input class="form-control" type="hidden" name="tahun" id="tahun" value="<?=$tahun?>"/>
	<input class="form-control" type="hidden" name="bulan" id="bulan" value="<?=$bulan?>"/>
</div>

<div class="panel panel-default">
	<!-- data pemohon -->
	<div class="panel-heading">
		<h3 class="panel-title">DATA PEMOHON</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<form>
			    <div class="col-xs-2 form-group">
			        <label>Nama</label>
			    </div>
			    <div class="col-xs-4 form-group">
			        <!--<input class="form-control" type="text" name="nama" id="nama" onkeyup="lihat(this.value)"/>-->
			        <input class="form-control" type="text" name="nama" id="nama" value="<?=$data_pemohon['nama']?>"/>							
					<div id="kotaksugest"></div>
			    </div>
				<div class="col-xs-2 form-group">
			        <label>Golongan</label>
			    </div>
			    <div class="col-xs-4 form-group">
			        <input class="form-control" type="text" name="golongan" id="golongan" value="<?=$data_pemohon['golongan']?>"/>
			    </div>

			    <div class="clearfix"></div>

			    <div class="col-xs-2 form-group">
			        <label>NPM/NIP/NUP</label>
			    </div>
			    <div class="col-xs-4 form-group">
			        <input class="form-control" type="text" name="nip" id="nip" value="<?=$data_pemohon['nip']?>"/>
			    </div>
				<div class="col-xs-2 form-group">
			        <label>PAF/Dept/Prodi</label>
			    </div>
			    <div class="col-xs-4 form-group">
			        <input class="form-control" type="text" name="unit_kerja" id="unit_kerja" value="<?=$data_pemohon['unit_kerja']?>"/>
			    </div>
			    <div class="clearfix"></div>
			    <div class="col-xs-4 form-group">
			    </div>				
			</form>
		</div>	
	</div>
</div>

<!-- Data Penugasan -->
<div class="panel panel-default">
	<div class="panel-heading" style="text-align:center">
		<h3 class="panel-title">PERSETUJUAN PELAKSANAAN LEMBUR</h3>
	</div>
	<div class="panel-body">
		
		<div id="table-data" style="overflow:auto"></div>
	</div>
</div>

<!--<pre id="test"></pre>-->

<script type="text/javascript">
$(document).ready(function(){
	var nip = $("#nip").val()
	var tahun = $("#tahun").val()
	var bulan = $("#bulan").val()
	$.ajax({
        type: "POST",
        url: "views/form_lembur_admin_approved_refresh.php",
        data: {nip:nip, tahun:tahun, bulan:bulan},
        success: function(res) {
			$("#table-data").html(res)
        }    
    })
})
</script>