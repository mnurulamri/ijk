<?php
date_default_timezone_set('Asia/Jakarta');
if(!session_id()) session_start();
include('../models/conn.php');

if($_POST['nip']) $nip = $_POST['nip'];
if($_POST['tgl1']) $tgl1 = $_POST['tgl1'];
if($_POST['tgl2']) $tgl2 = $_POST['tgl2'];

/* testing...
$nip = '090613091';
$tgl1 = '01 Desember 2017';
$tgl2 = '31 Desember 2017';
*/

$tanggal1 = tanggalToDb($tgl1);
$tanggal2 = tanggalToDb($tgl2);

/* - variabel $nip = $nip_ijd
   - set nip IJK untuk menampilkan nama dan unit kerja terkini
   - cek dulu di tabel ijk ada apa nggak nipnya
   - kalo ada maka ga usah diapa2in, kalo nggak ada maka cari dulu di tabel perubahan nip
   - ambil informasi nama dan unit kerja berdasarkan nip/nup yang sudah dimanipulasi
*/
//cek nip di tabel IJK
$sql = "SELECT DISTINCT NIP as nip FROM ijk WHERE NIP = '$nip'";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)){
	$temp_nip_ijk = $row['nip'];
}
//jika gak ada maka set nip IJK
if (empty($temp_nip_ijk)) {
	//cari nip yang nggak ada di tabel perubahan nip
	$sql = "SELECT nup_ijk as nip
			FROM perubahan_nup
			WHERE nup_idp = '$nip'";
	$result = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)){
		$temp_nip_ijk = $row['nip'];
	}
	$nip_ijk = $temp_nip_ijk;
} else {
	$nip_ijk = $nip;
}
//ambil informasi nama dan unit kerja (diambil dari data yang paling terakhir tabel ijk) -> nup IJK sebagai acuan
$sql = "SELECT DISTINCT Unit_Kerja as unit_kerja, Nama as nama, Gol_Gapok as golongan
		FROM ijk
		WHERE substr(periode,-4) IN (
				SELECT MAX(substr(periode,-4)) as tahun
				FROM ijk
				WHERE NIP = '$nip_ijk')
			AND substr(periode, 1,2) IN (
				SELECT MAX(substr(periode, 1,2)) as bulan
				FROM ijk
				WHERE NIP = '$nip_ijk')	
			AND NIP = '$nip_ijk'";
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$info_pegawai = $row;
}

/* - modul manipulasi nip/nup untuk data kehadiran
   - khusus untuk user
   - cek dulu nup/nipnya ada apa nggak
   - kalo gak ada maka cari nup/nip di tabel perubahan_nup
   - ambil data presensi
*/
//cek perubahan nup menu user -> nup IDP sebagai acuan untuk mencetak data kehadiran
//if ($_SESSION['role_id'] == 2) {
	// set nip IDP
	$sql = "SELECT nup_idp as nip
			FROM perubahan_nup
			WHERE nup_ijk = '$nip'";
	$result = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)){
		$temp_nip_idp = $row['nip'];
	}
	if (!empty($temp_nip_idp)){
		$nip = $temp_nip_idp;
	}
//}

//ambil data presensi
$sql = "SELECT DISTINCT b.nip as nip, nama, a.pin, date_time, DATE(date_time) as tanggal, TIME_FORMAT(date_time, '%H:%i') as waktu
		FROM  TblHKDLoadData a
		LEFT JOIN TblHKUser b ON a.pin = b.pin
		LEFT JOIN TblPegawai c ON b.nip = c.nip
		WHERE b.nip = '$nip' AND DATE(date_time) BETWEEN '$tanggal1' AND '$tanggal2'
		UNION ALL
		(
			SELECT DISTINCT b.nip as nip, a.nama as nama, a.pin, tglwaktu, DATE(tglwaktu) as tanggal, TIME_FORMAT(tglwaktu, '%H:%i') as waktu
			FROM  TblAbsManual a
			LEFT JOIN TblHKUser b ON a.pin = b.pin
			LEFT JOIN TblPegawai c ON b.nip = c.nip
			WHERE b.nip = '$nip' AND DATE(tglwaktu) BETWEEN '$tanggal1' AND '$tanggal2' 
			ORDER BY tglwaktu
		)
		ORDER BY date_time";
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_object($result))
{
	$data[$row->tanggal][] = $row;
	$nama = $row->nama;
}

//ambil kode jenis Cuti, Sakit dan izin
$array = array();
$sql = "SELECT KodeJenis, TglAwal, TglAkhir
			From TblCutiSakitIzin 
			WHERE NIP = '$nip' ";  //AND DATE(TglAwal) BETWEEN '$tanggal1' AND '$tanggal2' -> result cuti nggak lengkap?
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_object($result))
{
	$data_array_itm[$row->TglAwal][] = $row ;
}
//untuk masing-masing tanggal awal dan akhir pada baris data cuti, sakit dan izin masukkan array kode jenis ke variabel pembantu ($data_array_itm)
foreach($data_array_itm as $keys => $values){
	foreach($values as $k => $v){
		$iterasi_tgl_kd_jenis[] = iterasi_tgl($v->TglAwal, $v->TglAkhir, $v->KodeJenis);
	}
}
//masukkan ke variabel array_itm (menghilangkan array[0,1,1,...] untuk menampung kode jenis berdasarkan key tanggal 
foreach ($iterasi_tgl_kd_jenis as $key => $value) {
	foreach ($value as $k => $v) {
		$array_itm[$k] = $v;
	}
}

//ambil data hari libur
$sql = "SELECT * FROM TblHariLibur WHERE YEAR(TglMulai) = YEAR(CURDATE())";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)){
	$array_hari_libur[] = $row;
}
//set key sebagai tanggal dan valuenya
foreach ($array_hari_libur as $k => $v) {
	//untuk masing-masing record pecah lagi menjadi array karena adanya interval tanggal. Masing-masing interval tanggal 1 record akan menjadi key
	$array_libur_perhari[] = iterasi_tgl_libur($v['TglMulai'], $v['TglAkhir'], $v['Uraian']);
}
//menghilangkan array level 1
foreach ($array_libur_perhari as $key => $value) {
	foreach ($value as $k => $v) {
		$array_libur[$k] = $v;
	}
}

//ambil data shift
$sql = "SELECT TglAwal, TglAkhir, H01, H02, H03, H04, H05, H06, H07
		FROM TblShift
		WHERE KodeShift = '$nip'";
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_assoc($result))
{
	$array_shift = $row;
}

//Ambil data waktu kerja
$sql = "SELECT KodeWaktuKerja, JadwalMasuk, JadwalKeluar
		FROM TblWaktuKerja";
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_assoc($result))
{
	$array_waktu_kerja[$row['KodeWaktuKerja']] = $row;
}

//set waktu
foreach ($data as $kTanggal => $vTanggal) {
	$i = 0;
	foreach ($vTanggal as $k => $v) {
		//set array waktu supaya waktu dapat dipisah berdasarkan kolom
		//dan array yg digunakan untuk mencetak baris pada report kehadiran
		$array_waktu[$kTanggal][$i] = $v->waktu;
		$i++;
	}
}

//iterasi tanggal
$begin = new DateTime( $tanggal1 ); 
$end = new DateTime( $tanggal2 ); 
for($i = $begin; $i <= $end; $i->modify('+1 day')){ 
    //echo $i->format("Y-m-d");
    $item_tgl[$i->format("Y-m-d")] = $array_waktu[$i->format("Y-m-d")];
}

/*
echo '<pre>';
print_r($array_waktu_kerja);
echo '</pre>';
*/

include('../../assets/css/table_presensi.php');
$html = '
<br>
<style>
table tr th {text-align:center; vertical-align:middle;}
table tr td {text-align:center; vertical-align:middle;}
</style>

<div class="row">
	<div class="col-md-12">
			<div class="well well-sm" style="font-size:14px; font-weight:bold; text-align:center; color:#888">'.$tgl1.' s/d '.$tgl2.'</div>
			<!-- Table -->
			<table class="table-presensi">
			<caption style="text-align:right; color:#fa0; font-weight:bold; font-size:14px">'.$nama.'</caption>';
			//cetak header tabel
			$html.= '<tr>
						<th rowspan="2" style="vertical-align:middle !important">Tanggal</th>
						<th rowspan="2" colspan="2">Ket</th>
						<th colspan="2">Jam</th>
						<th colspan="2">Telat Masuk</th>
						<th colspan="2">Cepat Plg</th>
						<th colspan="2">Lebih</th>
						<th colspan="2">Aktual</th>
						<th colspan="2">Beban</th>
					</tr>
					<tr>
						<!--<th></th>
						<th>Ket</th>-->
						<th>Datang</th>
						<th>Pulang</th>
						<th>Jam</th>
						<th>Menit</th>
						<th>Jam</th>
						<th>Menit</th>
						<th>Jam</th>
						<th>Menit</th>
						<th>Jam</th>
						<th>Menit</th>
						<th>Jam</th>
						<th>Menit</th>
					</tr>';

			//cetak data log handkey
			$total_aktual = '';
			$jml_hadir = 0;
			$ket = '';
			$waktu_masuk = '00:00';
			$shift = shift($array_shift);
			
			
			//tambah shift staf pasca utk tgl sebelum diajukan jam kerja yg baru
			if($nip=='090713008' or $nip=='090613004' or $nip=='090613052'){
				$tgl_mulai = new DateTime( '2018-10-11' ); 
				$tgl_akhir = new DateTime( '2018-10-31' ); 
				$shift_pasca[0] = '20';
				$shift_pasca[1] = '20';
				$shift_pasca[2] = '00';
				$shift_pasca[3] = '00';
				$shift_pasca[4] = '20';
				$shift_pasca[5] = '20';
				$shift_pasca[6] = '20';
				//set shift ke dalam tanggal
				$j=0;
				for($i = $tgl_mulai; $i <= $tgl_akhir; $i->modify('+1 day'))
				{    
	    			if ($j > 6) {
	    				$j = 0;
	    			}
	    			$shift[$i->format("Y-m-d")] = $shift_pasca[$j];
	    			$j++;
				}
		
			}
			
			foreach ($item_tgl as $kDate => $vDate) {
				$jml_kolom = 1; //buat nampilin garis di cell yang ga ada datanya
				$itm = $array_itm[$kDate];
				$color_tgl = '';
				if(namaHari($kDate) == 'Sabtu' or namaHari($kDate)== 'Minggu'){
					$background_color = 'background-color:#eebbf0;';
				} elseif(isset($array_libur[$kDate])){
					$color_tgl = 'color:#A901DB;';
				} else {
					$background_color = '';
				}
				
				$html.= '<tr><td style="'.$background_color.$color_tgl.'">'.tanggal($kDate).'</td>';
				foreach ($vDate as $k => $v) {
					//$html.= '<td>'.$v.'</td>';
					$jml_kolom+=1;
				}

				$kolom_kosong = 5 - $jml_kolom;
				for ($j=0; $j <= $kolom_kosong; $j++) { 
					//$html.= '<td></td>';
				}

				$j = $jml_kolom-2;

				$masuk 		= $kDate.' '.$array_waktu[$kDate][0];
				$pulang 	= $kDate.' '.$array_waktu[$kDate][$j];
				$waktu_masuk = $array_waktu_kerja[$shift[$kDate]]['JadwalMasuk'];
				$waktu_pulang = $array_waktu_kerja[$shift[$kDate]]['JadwalKeluar'];
				$temp_masuk = $kDate.' '.$waktu_masuk;
				$temp_pulang = $kDate.' '.$waktu_pulang;
				//$temp_masuk = $kDate.' 08:00';
				//$temp_pulang = $kDate.' 16:00';

				$masuk 		= new DateTime( $masuk );
				$pulang 	= new DateTime( $pulang );
				$temp_masuk = new DateTime( $temp_masuk );
				$temp_pulang = new DateTime( $temp_pulang );
				//$aturan_masuk = $temp_masuk->format('Y-m-d H:i');

				$jam_masuk = $array_waktu[$kDate][0];
				$jam_pulang = ($j > 0) ? $array_waktu[$kDate][$j] : '' ;

				$aktual 		 = $masuk->diff($pulang);
				$telat_masuk 	 = $masuk->diff($temp_masuk);
				$lebih 			 = $pulang->diff($temp_pulang);
				$cepat_plg 		 = $temp_pulang->diff($pulang);

				//telat masuk
				if($itm != 'ITM'){
					$telat_masuk_jam = ( $masuk > $temp_masuk AND (namaHari($kDate) != 'Sabtu' AND namaHari($kDate) != 'Minggu') ) ? $telat_masuk->h : '' ;
					$telat_masuk_menit = ( $masuk > $temp_masuk AND (namaHari($kDate) != 'Sabtu' AND namaHari($kDate) != 'Minggu') ) ? $telat_masuk->i : '' ;
				} else {
					$telat_masuk_jam = 0;
					$telat_masuk_menit = 0;
				}
				
				//pulang cepat
				//selain hari sabtu dan minggu
				$cepat_plg_jam	 = ( ($pulang < $temp_pulang) AND ($pulang > $temp_masuk)  AND (namaHari($kDate) != 'Sabtu' AND namaHari($kDate) != 'Minggu' AND $array_libur[$kDate] != 'LN') ) ? $cepat_plg->h : '' ;  
				$cepat_plg_menit = ( ($pulang < $temp_pulang) AND ($pulang > $temp_masuk)  AND (namaHari($kDate) != 'Sabtu' AND namaHari($kDate) != 'Minggu' AND $array_libur[$kDate] != 'LN') ) ? $cepat_plg->i : '' ;

				//lebih jam kerja
				$lebih_jam_hari_kerja 	= ( ($pulang > $temp_pulang) ) ? $lebih->h : '' ;
				$lebih_menit_hari_kerja = ( ($pulang > $temp_pulang) ) ? $lebih->i : '';
				$lebih_jam_hari_libur	= $aktual->h;
				$lebih_menit_hari_libur	= $aktual->i;
				if ((namaHari($kDate) != 'Sabtu' AND namaHari($kDate) != 'Minggu')) {
					$lebih_jam = $lebih_jam_hari_kerja;
					$lebih_menit = $lebih_menit_hari_kerja;
				} else {
					$lebih_jam = $lebih_jam_hari_libur;
					$lebih_menit = $lebih_menit_hari_libur;
				}
				
				//beban kerja
				//$beban_jam = ( $aktual > 0  AND (namaHari($kDate) != 'Sabtu' AND namaHari($kDate) != 'Minggu') ) ? 8  :  0 ;
				if($itm == 'DL') {
					$beban_jam = 8;
				} else if($jam_masuk == '' and $jam_pulang == '' ){
					$beban_jam = 0;
				} else if(  (namaHari($kDate) == 'Sabtu' or namaHari($kDate) == 'Minggu')){
					$beban_jam = 0;
				} else if($itm == ' DL') {
					$beban_jam = 8;
				} else {
					$beban_jam = 8;
				}
				$beban_menit = 0;  //sementara aja
				
				//set keterangan
				$warna = 'magenta;'; //#ed4337
				if( 
					$shift[$kDate] != '00' and ($telat_masuk_jam and $telat_masuk_menit and $cepat_plg_jam and $cepat_plg_menit) == '' and
					( $jam_masuk != '' and $jam_pulang != '' and $shift[$kDate] != 00 and $itm == '')
				){
					$ket_hn = 'HN';
					$color_tm = 'color:'.$warna;
				} else {
					$ket_hn = '';
					$color_hn = '';
					$color = '';
				}
				
				if( $shift[$kDate] == '00' ){
					$ket_lj = '<font style="color:#7D3C98">&nbsp;LJ</font>';
					$color_lj = 'color:'.$warna;
				} else {
					$ket_lj = '';
					$color_lj = '';
					$color = '';
				}
				
				if( ($telat_masuk_jam or $telat_masuk_menit) != '' ){
					$ket_tm = '<font style="color:#2980B9">&nbsp;TM</font>';
					$color_tm = 'color:'.$warna;
				} else {
					$ket_tm = '';
					$color_tm = '';
					$color = '';
				}
				
				if( ($cepat_plg_jam or $cepat_plg_menit) > 0 ){
					$ket_pc = '<font style="color:#2980B9">&nbsp;PC</font>';
					$color_pc = 'color:'.$warna;
				} else {
					$ket_pc = '';
					$color_pc = '';
					$color = '';
				}
				
				$ket_libur = '';
				$ket_alpa = '';
				if(isset($array_libur[$kDate])){
					$ket_libur = '<font style="color:#A901DB">&nbsp;LN</font>';
				} else {
					$ket_libur = '';
					if( $jam_masuk == '' and $jam_pulang == '' and $shift[$kDate] != 00 and $itm == ''){
						$ket_alpa = '<font style="color:red">A</font>';
						$color_alpa = 'color:'.$warna;
					} else {
						$ket_alpa = '';
						$color_alpa = '';
						$color = '';
					}
				}

				//total hadir
				if( $beban_jam > 0 or ($jam_masuk > 0 or $jam_pulang > 0) ){
					$jml_hadir += 1;
				}
				

				//menghitung total jam
				$total_telat_masuk_jam += $telat_masuk_jam;
				$total_telat_masuk_menit += $telat_masuk_menit;
				$temp_jam = floor($total_telat_masuk_menit/60);
				$temp_menit = $temp_jam * 60;
				$total_telat_masuk_jam += $temp_jam;
				$total_telat_masuk_menit -= $temp_menit;

				$total_cepat_plg_jam += $cepat_plg_jam;
				$total_cepat_plg_menit += $cepat_plg_menit;
				$temp_jam = floor($total_cepat_plg_menit/60);
				$temp_menit = $temp_jam * 60;
				$total_cepat_plg_jam += $temp_jam;
				$total_cepat_plg_menit -= $temp_menit;

				$total_lebih_jam += $lebih_jam;
				$total_lebih_menit += $lebih_menit;
				$temp_jam = floor($total_lebih_menit/60);
				$temp_menit = $temp_jam * 60;
				$total_lebih_jam += $temp_jam;
				$total_lebih_menit -= $temp_menit;

				$total_aktual_jam += $aktual->h;
				$total_aktual_menit += $aktual->i;
				$temp_jam = floor($total_aktual_menit/60);
				$temp_menit = $temp_jam * 60;
				$total_aktual_jam += $temp_jam;
				$total_aktual_menit -= $temp_menit;

				$total_beban_jam += $beban_jam;
				$total_beban_menit += $beban_menit;

				$keterangan = $ket_hn.$ket_alpa.$ket_tm.$ket_pc. $array_itm[$kDate].$ket_lj.$ket_libur;

				$html.= '
					<!--<td>'.$waktu_masuk.'-'.$waktu_pulang.'</td>-->
					<td style="'. $color.$background_color .'; font-size:10px; padding:2px 0 2px 0; vertical-align:middle; color:#E67E22">'. $shift[$kDate] .'</td>
					<td style="'.$background_color.'; font-size:10px; vertical-align:middle; color:green"> '.$keterangan.'</td>
					<td style="'. $color_tm.$background_color .'">'. $jam_masuk. '</td>
					<td style="'. $color_pc.$background_color .'">'. $jam_pulang. '</td>
					<td style="'. $color.$background_color .'">'. $telat_masuk_jam.' </td>
					<td style="'. $color.$background_color .'">'. $telat_masuk_menit .'</td>
					<td style="'. $color.$background_color .'">'. $cepat_plg_jam.'</td>
					<td style="'. $color.$background_color .'">'. $cepat_plg_menit .'</td>
					<td style="'. $color.$background_color .'">'. $lebih_jam .'</td>
					<td style="'. $color.$background_color .'">'. $lebih_menit .'</td>
					<td style="'. $color.$background_color .'">'. $aktual->h. '</td>
					<td style="'. $color.$background_color .'">'. $aktual->i. '</td>
					<td style="'. $color.$background_color .'">'.$beban_jam.'</td>
					<td style="'. $color.$background_color .'">'.$beban_menit.'</td>
				</tr>';
			}
			
			$html.= '
					<tr>
						<td colspan="5">Hadir : '. $jml_hadir .'</td>
						<td>'. $total_telat_masuk_jam .'</td>
						<td>'. $total_telat_masuk_menit .'</td>
						<td>'. $total_cepat_plg_jam .'</td>
						<td>'. $total_cepat_plg_menit .'</td>
						<td>'. $total_lebih_jam .'</td>
						<td>'. $total_lebih_menit .'</td>
						<td>'. $total_aktual_jam .'</td>
						<td>'. $total_aktual_menit .'</td>
						<td>'. $total_beban_jam.'</td>
						<td>'. $total_beban_menit.'</td>
					</tr>
				</table>
		</div>
</div>'; 

echo $html;

function shift($array_shift){
	$end = new DateTime( date('Y-m-d') ); 
	if(!empty($array_shift)){
		$begin = new DateTime( $array_shift['TglAwal'] ); 
		
		$shift[0] = $array_shift['H01'];
		$shift[1] = $array_shift['H02'];
		$shift[2] = $array_shift['H03'];
		$shift[3] = $array_shift['H04'];
		$shift[4] = $array_shift['H05'];
		$shift[5] = $array_shift['H06'];
		$shift[6] = $array_shift['H07'];
	} else {
		
		$begin = new DateTime( '2017-01-02' ); 
		
		$shift[0] = '01';
		$shift[1] = '01';
		$shift[2] = '01';
		$shift[3] = '01';
		$shift[4] = '02';
		$shift[5] = '00';
		$shift[6] = '00';
	}
	//iterasi tanggal
	$j=0;
	for($i = $begin; $i <= $end; $i->modify('+1 day'))
	{    
	    if ($j > 6) {
	    	$j = 0;
	    }
	    $shift_tgl[$i->format("Y-m-d")] = $shift[$j];
	    $j++;
	}
	return $shift_tgl;
	
}

function namaHari($tgl){
	$array_hari = array('Sun'=>'Minggu', 'Mon'=>'Senin', 'Tue'=>'Selasa', 'Wed'=>'Rabu', 'Thu'=>'Kamis', 'Fri'=>'Jumat', 'Sat'=>'Sabtu');
	$tgl_arr = explode('-',$tgl);
	$tahun = $tgl_arr[0]; 
	$bulan = $tgl_arr[1]; 
	$hari   = $tgl_arr[2]; 
	$kd_hari  = date('D', strtotime($tgl));
	$nama_hari = $array_hari[$kd_hari];
	return $nama_hari;
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

function tanggalToDb($tgl_kegiatan)
{
	$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
	$tgl_array = explode(" ", $tgl_kegiatan);
	$d = $tgl_array[0]; 
	$month = array_search($tgl_array[1], $bulan) + 1;
	$m = (strlen($month)==2) ? $month : '0'.$month; 
	$y = $tgl_array[2];
	$tgl = $y."-".$m."-".$d;
	$tgl_kegiatan = $tgl;
	return $tgl;
}

function iterasi_tgl($tanggal1, $tanggal2, $KodeJenis)
{
	$begin = new DateTime( $tanggal1 ); 
	$end = new DateTime( $tanggal2 ); 
	for($i = $begin; $i <= $end; $i->modify('+1 day')){ 
    	//echo $i->format("Y-m-d").'<br>';
    	$array[$i->format("Y-m-d")] = $KodeJenis;
    	//$item_tgl[$i->format("Y-m-d")] = $array_waktu[$i->format("Y-m-d")];
	}
	return $array;
}

function iterasi_tgl_libur($tanggal1, $tanggal2, $uraian)
{
	$begin = new DateTime( $tanggal1 ); 
	$end = new DateTime( $tanggal2 ); 
	for($i = $begin; $i <= $end; $i->modify('+1 day')){ 
    	$array[$i->format("Y-m-d")] = 'LN';
	}
	return $array;
}
?>