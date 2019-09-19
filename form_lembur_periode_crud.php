<?php
ini_set('display_errors', 1);
include "pdo.class.php";
//New PDO object
$pdo = new Database();

$array_bulan = array(
			'Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05', 'Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12'
		);
		
$crud = $_POST['crud'];

if($crud == 0){
	echo 'test
		<form class="form-horizontal">
			<div class="form-group">
				<label for="periode" class="col-sm-3 control-label">Periode</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="periode" placeholder="Periode">
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_cutoff" class="col-sm-3 control-label">Tanggal Cut Off</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="tgl_cutoff" placeholder="Tanggal Cut Off">
				</div>
			</div>
			<div class="form-group">
				<label for="status" class="col-sm-3 control-label">Status</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="status" placeholder="Status">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button class="simpan btn btn-info">simpan</button>
				</div>
			</div>
		</form>
	';
} else if ($crud == 1){  // modal view tanggal cut off
	$periode = $_POST['periode'];
	$array = explode(' ', $periode);
	$bulan = $array_bulan[$array[0]];
	$tahun = $array[1];
	
	$_tgl_cutoff = trim($_POST['tgl_cutoff']);
	$tgl_cutoff = tanggalToDb($_tgl_cutoff, $array_bulan);
	
	$status = $_POST['status'];
	$flag = ($status == 'closed') ? 1 : 0;
	
	echo '
		<form class="form-horizontal">
			<div class="form-group">
				<label for="periode" class="col-sm-3 control-label">Periode</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="periode" placeholder="Periode" value="'.$periode.'" disabled >
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_cutoff" class="col-sm-3 control-label">Tanggal Cut Off</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="tgl_cutoff" placeholder="Tanggal Cut Off" value="'.$_tgl_cutoff.'">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button class="simpan-cutoff btn btn-info">simpan</button>
				</div>
			</div>
		</form>';
} 
else if ($crud == 2){  //update tanggal cut off
	$periode = $_POST['periode'];
	$array = explode(' ', $periode);
	$bulan = $array_bulan[$array[0]];
	$tahun = $array[1];
	
	$tgl_cutoff = trim($_POST['tgl_cutoff']);
	$tgl_cutoff = tanggalToDb($tgl_cutoff, $array_bulan);
	echo $sql = "UPDATE lembur_periode SET tgl_cutoff = '$tgl_cutoff' WHERE tahun = $tahun AND bulan = '$bulan'";
	$pdo->query($sql);
	$pdo->execute();
} 
else if ($crud == 3){  //modal view update closing
	$periode = $_POST['periode'];
	$array = explode(' ', $periode);
	$bulan = $array_bulan[$array[0]];
	$tahun = $array[1];

	$status = $_POST['status'];
	$flag = ($status == 'closed') ? 1 : 0;
	
	if ($status == 'closed') {
		$option = '
			<option value="1" checked >Closed</option>
			<option value="0">Unlosed</option>';
	} else {
		$option = '
			<option value="1" >Closed</option>
			<option value="0" checked >Unlosed</option>';
	}
	
	$form_select = '
	<select name="status" id="status" class="form-control">
		'.$option.'
	</select>';

	echo '
		<form class="form-horizontal">
			<div class="form-group">
				<label for="periode" class="col-sm-3 control-label">Periode</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="periode" placeholder="Periode" value="'.$periode.'" disabled >
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_cutoff" class="col-sm-3 control-label">Closing Periode</label>
				<div class="col-sm-3">
					'.$form_select.'
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button class="simpan-closing btn btn-info">simpan</button>
				</div>
			</div>
		</form>';
}
else if ($crud == 4){  
	/* 
		update untuk open closed periode
		jika user melakukan closing transaksi maka tambah record bulan berikutnya 
		untuk persiapan closing transaksi pada bulan berikutnya
			jika recordnya sudah ada maka diemin ajah
		jika user membuka transaksi yg sudah di closing maja diemin ajah
	*/
	
	#set variabel
	$periode = $_POST['periode'];
	$array = explode(' ', $periode);
	$bulan = $array_bulan[$array[0]];
	$tahun = $array[1];
	$flag_closing = ($_POST['flag_closing'] == 'true') ? 1 : 0 ;
	
	#eksekusi dulu update closing transaksi
	$sql = "UPDATE lembur_periode SET flag_closing = $flag_closing WHERE tahun = $tahun AND bulan = '$bulan'";
	$pdo->query($sql);
	$pdo->execute();
			
	#jika user melakukan closing transaksi maka tambah record bulan berikutnya
	if($flag_closing == 1){
		#set tahun dan bulan berikutnya
		#$bulan = '12'; #tes
		$next_bulan = (int) $bulan + 1;
		if (strlen($next_bulan) == 1) 
			$next_bulan = '0'.$next_bulan;
			
		#jika jatuh pada bulan desember maka set bulan berikutnya menjadi '01' atau bulan januari dan rubah tahun ke tahun berikutnya
		if ($next_bulan == 13) {
			$next_bulan = '01';
			$next_tahun = $tahun + 1;
		} else {
			$next_tahun = $tahun;
		}
		
		#cek dulu data pada bulan berikutnya ada apa nggak
		$sql = "SELECT id FROM lembur_periode WHERE tahun = $next_tahun AND bulan = '$next_bulan' ";
		$pdo->query($sql);
		$result = $pdo->resultset();
		$row = count($result);

		#echo 'test'; print_r($row);exit();
		#jika tidak ada datanya maka tambah record baru
		if (empty($row)){  
			#set tanggal cut off bulan berikutnya
			$tgl_cutoff = next_tgl_cutoff($next_tahun, $next_bulan);
			$periode = $next_tahun.$next_bulan;
			
			#eksekusi ke database
			echo $sql = "INSERT INTO lembur_periode (tahun, bulan, periode, tgl_cutoff, flag_closing)
			VALUES ($next_tahun, '$next_bulan', '$periode', '$tgl_cutoff', 0)";
			$pdo->query($sql);
			$pdo->execute();
		}
		
	}
}
else if ($crud == 5){ 
	#set flag cutoff
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	$flag_cutoff = ($_POST['flag_cutoff'] == 'true') ? 1 : 0 ;
	$sql = "UPDATE lembur_periode SET flag_cutoff = $flag_cutoff WHERE tahun = $tahun AND bulan = '$bulan'";
	$pdo->query($sql);
	$pdo->execute();
}
else if ($crud == 6){ 
	#set flag closing
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	$flag_closing = ($_POST['flag_closing'] == 'true') ? 1 : 0 ;
	echo $sql = "UPDATE lembur_periode SET flag_closing = $flag_closing WHERE tahun = $tahun AND bulan = '$bulan'";
	$pdo->query($sql);
	$pdo->execute();
}
else if ($crud == 20){  //update tanggal cut off
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	echo $sql = "UPDATE lembur_detail SET status = 2 WHERE tahun = $tahun AND bulan = '$bulan' AND flag_ajukan = 1";
}  
 
function tanggalToDb($tgl_kegiatan, $array_bulan)
{
	//$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
	$tgl_array = explode(" ", $tgl_kegiatan);
	$d = $tgl_array[1];
	$m = $array_bulan[$tgl_array[2]];
	$y = $tgl_array[3];
	$tgl = $y."-".$m."-".$d;
	$tgl_kegiatan = $tgl;
	return $tgl;
}

function next_tgl_cutoff($next_tahun, $next_bulan)
{
	#set tgl cut off
	$d = '10';
	$m = (int) $next_bulan;
	$y = $next_tahun;
	$date = $y.'-'.$m.'-'.$d;
	return $date;
}
?>