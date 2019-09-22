
<?php
//ini_set('display_errors', 1);
include "pdo.class.php";
//New PDO object
$pdo = new Database();
if(!session_id()) session_start();
#set tahun dan bulan
$tahun = $_POST['tahun'];
$bulan = bulan($_POST['bulan']);
#$tahun = 2019;
#$bulan = '05';

#ambil data unit kerja dan golongan terkini
//ambil tahun terakhir
$sql = "SELECT DISTINCT(MAX(SUBSTR(periode, 7, 4))) as tahun FROM ijk"; 
$stmt = $pdo->query($sql) ; //or die( $pdo->errorInfo()[2] );
$result = $pdo->resultset();
foreach($result as $row){
	$tahun_ijk = $row['tahun'];
}

//ambil bulan terakhir
$sql="SELECT DISTINCT(MAX(SUBSTR(periode, 1, 2))) as bulan 
FROM ijk 
WHERE SUBSTR(periode, 1, 2) < 13 AND SUBSTR(periode, 7, 4) = '$tahun'"; 
$stmt = $pdo->query($sql) ; //or die( $pdo->errorInfo()[2] );
$result = $pdo->resultset();
foreach($result as $row){
	$bulan_ijk = $row['bulan'];
}

//$nip_pejabat = $_SESSION['user_nip']; //$nip_pejabat = '196606161993031004'; //nanti ambil dari session
if ($_SESSION['user_nip'] == '090613091') {
	$nip_pejabat = '196606161993031004';
} else if ($_SESSION['user_nip'] == '090613045'){
	$nip_pejabat = '196510211993032001';
} else {
	$nip_pejabat = $_SESSION['user_nip']; 
}

if ($_SESSION['user_nip'] == '100220310210019891' or $_SESSION['user_nip'] == '090613045' or $_SESSION['user_nip'] == '090613091') {
	//ambil data pemohon unit
	$sql = "SELECT  DISTINCT a.nip, a.nama as nama, a.gol_gapok, unit_kerja_real, gol_gapok, d.nama as nama_pejabat, jabatan, c.kodebidang as kode_bidang, b.status
			FROM ijk a
			LEFT OUTER JOIN lembur_detail b ON a.nip=b.nip
			LEFT OUTER JOIN cek_unit_kerja c ON unit_kerja = unit_kerja_ijk
			LEFT OUTER JOIN pejabat d ON c.kodebidang = d.kodebidang
			WHERE b.tahun=$tahun AND b.bulan='$bulan' AND SUBSTR(periode, 1, 2) = '$bulan_ijk' AND SUBSTR(periode, 7, 4) = '$tahun_ijk' AND flag_ajukan = 1
			ORDER BY c.kodebidang";
} else {
	//ambil data pemohon unit kerja
	$sql = "SELECT  DISTINCT a.nip, a.nama as nama, a.gol_gapok, unit_kerja_real, gol_gapok, d.nama as nama_pejabat, jabatan, c.kodebidang as kode_bidang, b.status
			FROM ijk a
			LEFT OUTER JOIN lembur_detail b ON a.nip=b.nip
			LEFT OUTER JOIN cek_unit_kerja c ON unit_kerja = unit_kerja_ijk
			LEFT OUTER JOIN pejabat d ON c.kodebidang = d.kodebidang
			WHERE b.tahun=$tahun AND b.bulan='$bulan' AND SUBSTR(periode, 1, 2) = '$bulan_ijk' AND SUBSTR(periode, 7, 4) = '$tahun_ijk' AND d.nip = '$nip_pejabat' AND flag_ajukan = 1";
}




/*
$sql = "SELECT * FROM lembur_pemohon 
WHERE flag_transaksi = 0 AND TAHUN = '$tahun' AND bulan = '$bulan' AND nip in (
	SELECT DISTINCT a.nip as nip
	FROM ijk a 
	LEFT JOIN TblPegawai b ON a.nip = b.nip
	LEFT JOIN cek_unit_kerja c ON unit_kerja = unit_kerja_ijk
	WHERE SUBSTR(periode, 1, 2) = '$bulan' AND SUBSTR(periode, 7, 4) = '$tahun' AND c.nip = '196606161993031004'
)";
*/
$stmt = $pdo->query($sql) ; //or die( $pdo->errorInfo()[2] );
$result = $pdo->resultset();
$nama_kolom = $pdo->column();
$jumlah_kolom = count($nama_kolom);
foreach($result as $row){
	$data_pemohon[$row['nip']] = $row;
}

#ambil data lembur
if ($_SESSION['user_nip'] == '100220310210019891' or $_SESSION['user_nip'] == '090613045' or $_SESSION['user_nip'] == '090613091') {
	$sql ="SELECT id, nip, tgl_lembur, presensi, uraian, waktu_lembur, waktu_lembur_disetujui, 
		status, keterangan, flag_libur, honor_lembur, TIME_TO_SEC(waktu_lembur_disetujui)/60 as jumlah_menit_disetujui,
		(TIME_TO_SEC(waktu_lembur_disetujui)/3600)*harga_satuan as honor_lembur_disetujui
		FROM lembur_detail
		WHERE flag_transaksi = 0 AND TAHUN = '$tahun' AND bulan = '$bulan' AND nip IN (
			SELECT DISTINCT a.nip as nip
			FROM ijk a 
			LEFT JOIN TblPegawai b ON a.nip = b.nip
			LEFT JOIN cek_unit_kerja c ON unit_kerja = unit_kerja_ijk
			WHERE SUBSTR(periode, 1, 2) = '$bulan_ijk' AND SUBSTR(periode, 7, 4) = '$tahun_ijk'
		)
		ORDER BY tgl_lembur";
} else {
	$sql ="SELECT id, nip, tgl_lembur, presensi, uraian, waktu_lembur, waktu_lembur_disetujui, 
		status, keterangan, flag_libur, honor_lembur, TIME_TO_SEC(waktu_lembur_disetujui)/60 as jumlah_menit_disetujui,
		(TIME_TO_SEC(waktu_lembur_disetujui)/3600)*harga_satuan as honor_lembur_disetujui
		FROM lembur_detail
		WHERE flag_transaksi = 0 AND TAHUN = '$tahun' AND bulan = '$bulan' AND nip IN (
			SELECT DISTINCT a.nip as nip
			FROM ijk a 
			LEFT JOIN TblPegawai b ON a.nip = b.nip
			LEFT JOIN cek_unit_kerja c ON unit_kerja = unit_kerja_ijk
			WHERE SUBSTR(periode, 1, 2) = '$bulan_ijk' AND SUBSTR(periode, 7, 4) = '$tahun_ijk' AND c.nip = '$nip_pejabat'
		)
		ORDER BY tgl_lembur";
}

$stmt = $pdo->query($sql) ; //or die( $pdo->errorInfo()[2] );
$result = $pdo->resultset();		
foreach($result as $row){
	$data_lembur[$row['nip']][] = $row;
}

//print_r($data_lembur['091625022']); exit();
#cetak data
//echo '<pre>';
header_table();

#cetak isi tabel

#ambil data flag closing untuk melock approval
$sql = "SELECT flag_closing FROM lembur_periode WHERE tahun = $tahun AND bulan = '$bulan'";
$pdo->query($sql);
$result = $pdo->single();
foreach ($result as $k => $v){
	$flag_closing = $v;
}
$label_approval = ($flag_closing==1) ? 'Detail': 'Approval';

#detail data
$total = 0;
$total_honor_lembur = 0;
$no = 1;
foreach ($data_pemohon as $key => $value){

	//keterangan status
	if ($v['status'] == 0 AND $v['flag_ajukan'] == 0){
		$ket_status = 'Belum Diajukan';
	} else if($v['status'] == 0 AND $v['flag_ajukan'] == 1){
		$ket_status = 'Menunggu Persetujuan Kepala Unit';
	} else if ($v['status'] == 1){
		$ket_status = 'Menunggu Persetujuan Manajer SDM';
	} else if ($v['status'] == 2){
		$ket_status = 'Disetujui';
	}

	$total = hitung_lembur($data_lembur[$key]);
	echo '
	<tr id="'.$value['id'].'" data-nip="'.$value['nip'].'">
		<td>'.$no.'</td>
		<td>'.$value['nip'].'</td>
		<td>'.$value['nama'].'</td>
		<!--<td>'.$value['unit_kerja'].'</td>-->		
		<td>'.$value['gol_gapok'].'</td>
		<!--<td>'.$ket_status.'</td>-->
		<td class="cell-total">'.$total['total_jam_hari_kerja'].'</td>
		<td class="cell-total">'.$total['total_jam_hari_kerja_disetujui'].'</td>
		<td class="cell-total">'.$total['total_jam_hari_libur'].'</td>
		<td class="cell-total">'.$total['total_jam_hari_libur_disetujui'].'</td>
		<td style="text-align:right">'.number_format($total['total_honor']).'</td>
		<td class="approval"><i class="btn btn-warning btn-xs">'.$label_approval.'</i></td>
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
		$waktu_lembur_disetujui = new DateTime( $v['waktu_lembur_disetujui'] );
		$array_selesai_lembur = explode(':', $array_waktu[1]);
		$menit_selesai = $array_selesai_lembur[0] * 60 + $array_selesai_lembur[1];
		$array_lembur = explode(':', $v['waktu_lembur']);
		$menit_lembur = $array_lembur[0] * 60 + $array_lembur[1];
		$mulai_lembur = date('H:i', mktime(0, $menit_selesai - $menit_lembur ));
		
		//waktu lembur disetujui
		$array_lembur_disetujui = explode(':', $v['waktu_lembur_disetujui']);
		$menit_lembur_disetujui = $array_lembur_disetujui[0] * 60 + $array_lembur_disetujui[1];
		
		
		if($v['status'] == 0){
			$status = 'Belum Disetujui';
			$honor_lembur = 0;
			$remove = '<i class="fa fa-trash" ></i>';
			$edit = '<i class="fa fa-edit" ></i>';
			$waktu_lembur_disetujui = '00:00';
		} else {
			$status = 'Disetujui';
			$honor_lembur = $v['honor_lembur_disetujui'];
			$remove = '';
			$edit = '';
			$waktu_lembur_disetujui = $waktu_lembur_disetujui->format("H:i");
		}
		/*
		if($v['status'] == 1 or $v['status'] == 2){
			$total_honor += $v['honor_lembur_disetujui'];
		}*/
		
		$test += $menit_lembur;
		# Hitung Total Jam Lembur
		if($v['flag_libur'] == 1){
			$total_menit_hari_libur += $menit_lembur;
		} else {
			$total_menit_hari_kerja += $menit_lembur;
		}
		
		# Hitung Total Jam Lembur disetujui
		if(($v['status'] == 1 or $v['status'] == 2) and $v['flag_libur'] == 1){
			$total_menit_hari_libur_disetujui += $menit_lembur_disetujui;
		} else if(($v['status'] == 1 or $v['status'] == 2) and $v['flag_libur'] == 0){
			$total_menit_hari_kerja_disetujui += $menit_lembur_disetujui;
		}
		
		$total_honor += $honor_lembur;
	}
	
	$total_jam_hari_kerja = convertToHoursMins($total_menit_hari_kerja, '%02d : %02d');
	$total_jam_hari_libur = convertToHoursMins($total_menit_hari_libur, '%02d : %02d');
	$total_jam_hari_kerja = ($total_jam_hari_kerja == '') ? '-' : $total_jam_hari_kerja;
	$total_jam_hari_libur = ($total_jam_hari_libur == '') ? '-' : $total_jam_hari_libur;
	
	$total_jam_hari_kerja_disetujui = convertToHoursMins($total_menit_hari_kerja_disetujui, '%02d : %02d');
	$total_jam_hari_libur_disetujui = convertToHoursMins($total_menit_hari_libur_disetujui, '%02d : %02d');
	$total_jam_hari_kerja_disetujui = ($total_jam_hari_kerja_disetujui == '') ? '-' : $total_jam_hari_kerja_disetujui;
	$total_jam_hari_libur_disetujui = ($total_jam_hari_libur_disetujui == '') ? '-' : $total_jam_hari_libur_disetujui;

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

function bulan($nama_bulan){
	$array_bulan = array("Januari"=>"01", "Februari"=>"02", "Maret"=>"03",
					   "April"=>"04", "Mei"=>"05", "Juni"=>"06",
					   "Juli"=>"07", "Agustus"=>"08", "September"=>"09",
					   "Oktober"=>"10", "November"=>"11", "Desember"=>"12");
	return $array_bulan[$nama_bulan];
}

function header_table($label_approval){
	echo '
	<table class="table table-bordered" id="pelaksanaan-lembur">
				<thead>
			 	<tr>
			 		<th rowspan="2">No</th>
			 		<th rowspan="2">NIP</th>
			 		<th rowspan="2">Nama</th>
					<!--<th rowspan="2">Unit Kerja</th>-->
					<th rowspan="2">Gol</th>
					<!--<th rowspan="2">Status Persetujuan</th>-->
			 		<th colspan="2">Jam Lembur<br>Hari Kerja</th>
					<th colspan="2">Jam Lembur<br>Hari Libur</th>
			 		<th rowspan="2">Honor</th>
					<th rowspan="2">'.$label_approval.'</th>
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
						<th colspan="8" style="border-left:1px solid #fff;border-bottom:1px solid #fff;"></th>
						<th>'.number_format($total_honor_lembur).'</th>
						<th style="border-righ:1px solid #fff;border-bottom:1px solid #fff;"></th>
					</tr>
				</tfoot>
			</table>';
}

function test_data($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}
?>
<style>
.cell-total {text-align:center;}
</style>