<?
include('session_end.php');

//set tanggal
$d = date('d');
$m = date('n');
$y = date('Y');
//set hari
$nama_hari = array( '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
$hari = $nama_hari[$kd_hari];
//set bulan
$nama_bulan = array(' ','Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$bulan = $nama_bulan[$m];
$tanggal = $d.' '.$bulan.' '.$y;

?>
<div class="clearfix"></div>
<div class="container">

	<div class="row" >
		<div class="col-md-12 col-md-12 col-lg-12">
			<div class="container-daftarx" >		
					<div>
						<div class="box1">						
							<div class="row">
								<div class="col-sm-2 col-md-2 col-lg-2">Edit</div>
								<div class="col-md-8" style="text-align:left">
								 	<input type="hidden" name="edit_nip" id="edit_nip" placeholder="cari berdasarkan penggalan NIP/NUP atau penggalan Nama" class="form-control" value="<?=$_SESSION['user_nip']?>"/>
									<div class="row">
										<div class="col-sm-4 col-md-4 col-lg-4">
			    							<div class="input-group input-group-sm">
												<span class="input-group-addon">Tanggal Awal</span>
												<input type="text" class="form-control" name="edit_tgl1" id="edit_tgl1" class="edit_tgl1" data-date-format="dd MM yyyy" value="<?=$tanggal?>" />
											</div><!-- /input-group -->
										</div><!-- /.col-lg-6 -->
										
										<div class="col-sm-4 col-md-4 col-lg-4">
			    							<div class="input-group input-group-sm">
												<span class="input-group-addon">Tanggal Akhir</span>
												<input type="text" class="form-control" name="edit_tgl2" id="edit_tgl2" class="edit_tgl2" data-date-format="dd MM yyyy" value="<?=$tanggal?>" />
											</div><!-- /input-group -->
										</div><!-- /.col-lg-6 -->

									</div><!-- /.row -->					
								</div>
								<div class="col-md-2"></div>
							</div>
							<!--
							<div style="text-align:right; padding-right:15px">
								search: <input type="text" id="FilterTextBox" name="FilterTextBox" />
							</div>
							-->
						</div>				
					</div>			
			</div>	
		</div>
	</div>	
</div>  <!-- ./row -->

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10" id="edit_data"></div>
	<div class="col-md-1"></div>
</div>


<script>
$('#edit_tgl1, #edit_tgl2').datepicker({autoclose: true,language: "id"}).on('changeDate', function(){
	alert("test")
	var nip = $('#edit_nip').val();
	var tgl1 = $('#edit_tgl1').val();
	var tgl2 = $('#edit_tgl2').val();

	var first = tanggal(tgl1);
	var second = tanggal(tgl2);

	$('.pesan').html('');

	if(parseInt(first.replace(/-/g,""),10) > parseInt(second.replace(/-/g,""),10)){
		$('.pesan').html('<h1 class="label" style="background:#ED4337; font-size:11px">tanggal awal lebih besar dari tanggal akhir!</h1>');
		$('#edit_tgl1').hide().show();
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "views/form_lembur_presensi_temp.php",
			data: {nip:nip, tgl1:tgl1, tgl2:tgl2},
			success: function(data){
				$('#edit_data').html(data);
				clock.start();
			}
		});	
	}
});

function tanggal(tgl){
	var array = tgl.split(' ');
	var d = array[0];
	var month = array[1];
	var y = array[2];

	var months = {Januari:"01", Februari:"02", Maret:"03", April:"04", Mei:"05", Juni:"06", Juli:"07", Agustus:"08", September:"09", Oktober:"10", November:"11", Desember:"12"};
	var m = months[month];
	var tgl = y + '-' + m + '-' + d;
	return tgl;
}
</script>