<!--<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<pre style="background:#fff">-->
<link href="../../../bootstrap/dist/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../../../bootstrap/dist/js/bootstrap-toggle.min.js"></script>
<?php
ini_set('display_errors', 1);
include "pdo.class.php";
//New PDO object
$pdo = new Database();

//test pdo
//$sql = "SELECT periode as Periode, start_date as 'Tanggal Awal', end_date as 'Tanggal Akhir', flag as 'Status' FROM lembur_periode";
$sql = "SELECT * FROM lembur_periode";
$pdo->query($sql);
$result = $pdo->resultset();

cetak_tabel($result);

function cetak_tabel($result){
	//set array bulan
	$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	//rubah tahun dan bulan menjadi periode
	
	//Give each table column same name is db column name
	echo '
	<table class="table1">
		<tr>
			<th>No</th>
			<th>Periode</th>
			<th>Inputan User</th>
			<th>Transaksi</th>
		</tr>';
		
		$i=1;
		
		foreach ($result as $k => $v){
			//rubah tahun dan bulan menjadi periode
			$periode = $nama_bulan[ $v['bulan'] ].' '.$v['tahun'];
			
			//rubah flag menjadi keterangan status
			$checked_cutoff = ($v['flag_cutoff'] == 0) ? '': 'checked';
			$checked_closing = ($v['flag_closing'] == 0) ? '': 'checked';
			
			echo '
				<tr id=" '.$v['id']. '">
					<td>'.$i.'</td>
					<td>'.$periode.'</td>
					<td>
						<div class="checkbox">
							<label>
								<input type="checkbox" '.$checked_cutoff.' class="cutoff" data-toggle="toggle" data-on="LOCK" data-off="UNLOCK" data-onstyle="danger" data-style="slow" data-id="'.$v['id'].'" data-tahun="'.$v['tahun'].'" data-bulan="'.$v['bulan'].'">
							</label>
						</div>
					</td>
					<td>
						<div class="checkbox">
							<label>
								<input type="checkbox" '.$checked_closing.' class="closing" data-toggle="toggle" data-on="CLOSED" data-off="UNCLOSED" data-onstyle="danger" data-style="slow" data-id="'.$v['id'].'" data-tahun="'.$v['tahun'].'" data-bulan="'.$v['bulan'].'">
							</label>
						</div>
					</td>
				</tr>';
			$i++;
			
		}
		
		
	echo '
	</table>';
echo '<div id="test">test</div>';
	//print_r($result);
}

/* script V1
function cetak_tabel($result){
	//set array bulan
	$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	//rubah tahun dan bulan menjadi periode
	
	//Give each table column same name is db column name
	echo '
	<table class="table1">
		<tr>
			<th>No</th>
			<th>Periode</th>
			<th>Tanggal Cut Off</th>
			<th>Status</th>
			<th>Ubah Cut Off</th>
			<th>Closing</th>
		</tr>';
		
		$i=1;
		
		foreach ($result as $k => $v){
			//rubah tahun dan bulan menjadi periode
			$periode = $nama_bulan[ $v['bulan'] ].' '.$v['tahun'];
			
			//rubah flag menjadi keterangan status
			$status = ($v['flag'] == 0) ? 'Unclosed': 'closed';
			
			echo '
				<tr id=" '.$v['id']. '">
					<td>'.$i.'</td>
					<td>'.$periode.'</td>
					<td> '.dbToTanggal($v['tgl_cutoff']).'</td>
					<td>'.$status.'</td>
					<td><span class="edit fa fa-edit"></span></td>
					<td><span class="edit-closing fa fa-edit"></span></td>
				</tr>';
			$i++;
			
		}
		
		
	echo '
	</table>';
	//print_r($result);
}
*/
function dbToTanggal($tanggal)
{
	$array = explode('-', $tanggal);
	//set tanggal
    $d = $array[2];
    $m = $array[1];
    $y = $array[0];
	//set hari
	$nama_hari = array( '0' => 'Minggu', '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
	$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
	$hari = $nama_hari[$kd_hari];
	//set bulan
	$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$bulan = $nama_bulan[$m];
    $tanggal = $hari.', '.$d.' '.$bulan.' '.$y;
    return $tanggal;
}
?>
<!--</pre>-->

<style type="text/css">
/*design table 1*/
.table1 {
    font-family: sans-serif;
    color: #444;
    border-collapse: collapse;
    width: 50%;
    border: 1px solid #f2f5f7;
}

.table1 tr th{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}

.table1, th, td {
    padding: 8px 20px;
    text-align: center;
}

.table1 tr:hover {
    background-color: #f5f5f5;
}

.table1 tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* switch */
  .slow .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
  .fast .toggle-group { transition: left 0.1s; -webkit-transition: left 0.1s; }
  .quick .toggle-group { transition: none; -webkit-transition: none; }

</style>