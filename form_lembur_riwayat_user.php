<?php
include('session_end.php');

include_once('assets/css/blink_me.php');

$array_bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$array_bulan2 = array('O1'=>'Januari','O2'=>'Februari','O3'=>'Maret','O4'=>'April','O5'=>'Mei', 'O6'=>'Juni','O7'=>'Juli','O8'=>'Agustus','O9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$m = date('n')-1;
$day = date('d');
$tahun = date('Y');
$tahun_1 = date('Y')-1;
$tahun_2 = date('Y')+1;

if ($day <= 11){
	$bulan = $array_bulan[ $m-1 ];
} else {
	$bulan = $array_bulan[ $m ];
}

$opt_bulan = '';
foreach($array_bulan as $k => $v){
	$selected = ($v == $bulan) ? 'selected' : '' ;
	$opt_bulan .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
}

$opt_tahun = '';
for($i=$tahun_1; $i <= $tahun_2; $i++ ){
	$selected = ($i == $tahun) ? 'selected' : '' ;
	$opt_tahun .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
}
?>
	
<div class="blink_me">B E T A</div>
<!--<div class="container">-->
	
	<div class="panel panel-default">
		<!-- data pemohon -->
		<div class="panel-heading" style="background:#fa0 !important; color:#555 !important">
			<h3 class="panel-title text-center" style="line-height:5px !important">KETENTUAN</h3>
		</div>
		<div class="panel-body">
			<div class="row">
					<div class="col-xs-2"></div>
				    <div class="col-xs-8 text-left" style="text-align:center; font-size:13px; font-weight:bold; color:#666">
				    	<p>- Pemohon lembur adalah tenaga kependidikan yang akan melakukan kerja lembur -</p>
				    	<p>- Kerja lembur hanya bisa dilakukan di luar jam kerja operasional -</p>
				    	<p>- Formulir pengajuan lembur wajib disetujui dan ditandatangai oleh atasan langsung -</p>
				    	<p>- Formulir pengajuan lembur harus disampaikan ke Unit SDM sebelum tugas lembur (maksimal di hari saat lembur dilaksanakan) -</p>
				    	<p>- Pembayaran lembur mengikuti pembayaran gaji -</p>
				    	<p>- Penugasan lembur yang diberikan tidak melebihi <b>14 jam</b> per minggu atau <b>50 jam</b> per bulan -</p>
				    	<p>- Tenaga Kependidikan yang melakukan paling sedikit 1 jam penuh pada hari kerja atau 2 jam pada hari libur dapat diberikan uang makan lembur -</p>
						<p>- Pemberian uang lembur pada hari libur kerja adalah sebesar <b>200%</b> dari besarnya uang lembur -</p>
						<p>- Besaran uang lembur adalah sebagai berikut:</p>
						<p>
							<table class="ketentuan" cellspacing="0" border="1" style="margin:auto">
								<tr><th colspan="4">Golongan</th><tr>
								<tr><th>I</th><th>II</th><th>III</th><th>IV</th><tr>
								<tr><td>Rp. 13.000,-</td><td>Rp. 17.000,-</td><td>Rp. 20.000,-</td><td>Rp. 25.000,-</td><tr>
							</table>
						</p>
						<p>- Uang transport lembur hari libur Rp. 35.000,-/per hari -</p>
					</div>
				    <div class="col-xs-2"></div>
			</div>	
		</div>
	</div>
	
	<div class="panel panel-default">
		<!-- data pemohon -->
		<div class="panel-heading">
			<h3 class="panel-title text-center" style="line-height:5px !important">PERIODE</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<form class="row">
					<div class="col-xs-4"></div>
				    <div class="col-xs-2 form-group text-left">
				    	<select class="form-control" name="bulan" id="bulan">
							<?=$opt_bulan;?>
						</select>
					</div>
					<div class="col-xs-2 form-group text-left">
						<select class="form-control" name="tahun" id="tahun">
							<?=$opt_tahun;?>
						</select>
				    </div>
				    <div class="col-xs-2"></div>
				</form>

			</div>	
		</div>
	</div>

	<div class="panel panel-default">
		<!-- data pemohon -->
		<div class="panel-heading">
			<h3 class="panel-title text-center" style="line-height:5px !important">DATA PEMOHON</h3>
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
				    <!--<div class="col-xs-2 form-group">
				        <input type="reset" value="clear" id="clear"/>
				    </div>-->					
				</form>

			</div>	
		</div>
	</div>

	<!-- Data Penugasan -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title text-center" style="line-height:5px !important">PELAKSANAAN LEMBUR</h3>
		</div>
		<div class="panel-body">
			<div id="table-data"></div>
			<div class="container">
				<!--
				<div class="row">
					<div class="col-xs-12" id="table-data"></div>
				</div>
				-->
				<div class="row">
					<div class="col-xs-4 pull-right">
						<div class="btn-group" role="group" aria-label="...">
							<a href="dokumen/form_pengajuan_lembur.php" type="button" class="btn btn-primary" id="msword">
									<i class="fa fa-file-word-o" style="font-size:18px;color:#fff"></i>&nbsp;download
							</a>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#inputModal" id="tambah">tambah</button>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<!-- Data Penugasan -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title text-center" style="line-height:5px !important">DESKRIPSI PELAKSANAAN LEMBUR</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 form-group">
					<!--<label for="deskripsi">Deskripsi Pelaksanaan Kerja Lembur</label>-->
					<textarea id="deskripsi" name="deskripsi" rows="5" cols="80"></textarea>
				</div>
			</div>
			<div class="row">
					<div class="col-xs-2 pull-right">
						<button type="button" class="btn btn-primary" id="simpan-deskripsi"><b>simpan</b></button>
					</div>
				</div>			
		</div>
	</div>
<!--</div>-->

<!-- modal tambah data -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="inputModalLabel">Data Lembur</h4>
			</div>
			<div class="modal-body">
				<form id="input-lembur">
					<div class="form-group">
						<label for="tgl_lembur">Silahkan pilih hari dan waktu lembur berdasarkan tanggal presensi</label>
						<?include 'views/form_lembur_presensi_perperiode_form.php';?>
					</div>
					<hr>
					<div class="col-xs-4 form-group">
						<label for="tgl_lembur">Hari/Tanggal</label>
						<input name="tgl_lembur" id="tgl_lembur" type="text"  class="form-control"value="" placeholder="Tanggal Lembur"/>
					</div>
					<div class="col-xs-3 form-group">
						<label for="waktu">Presensi</label>
						<input name="waktu" id="waktu" type="text"  class="form-control"value="" placeholder="Waktu"/>
					</div>
					<div class="col-xs-3 form-group">
						<label for="waktu_lembur">Waktu Lembur Lembur</label>
						<input name="waktu_lembur" id="waktu_lembur" type="text" class="form-control"value="" placeholder="Waktu Lembur"/>
					</div>
					<div class="clearfix"></div>	
					<div class="form-group">
						<label for="uraian">Uraian Pekerjaan</label>
						<input name="uraian" id="uraian" type="text"  class="form-control"value="" placeholder="Uraian Pekerjaan yang Dilakukan"/>
					</div>

					<input type="reset" value="clear" id="clear"/>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="ok">tambah</button>
			</div>
		</div>
	</div>
</div>
<!--<div id="test"></div>-->
<script src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	
$(document).ready(function()
{
	
	CKEDITOR.replace('deskripsi')
	
	function fetch_data()  
      {  
    	$.ajax({
        	type: 'POST',
        	url: 'views/form_lembur_get_data.php',
        	//data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        	//beforeSend: function () {
            //	$('.loading-overlay').show();
        	//},
        	success: function (html) {
        		//alert('test')	
            	$('#table-data').html(html);
        	}
    	})
      }
      
	function getDataPemohon()
	{
		clock.start();
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_data_pemohon_json.php",
			dataType: "json",
	        success: function(data) {
				$("#nip").val(data.nip)
				$("#nama").val(data.nama)
				$("#golongan").val(data.golongan)
				$("#unit_kerja").val(data.unit_kerja)
				CKEDITOR.instances["deskripsi"].setData(data.deskripsi)				
				//CKEDITOR.instances["deskripsi"].insertHtml(data.deskripsi)
				//$("#deskripsi").insertHtml(data.deskripsi)
	            console.log(data.deskripsi)
				//$("#test").html(data.deskripsi)
	        }
	    })
	    
	}
	getDataPemohon()
	
    fetch_data();
	
	$(document).on("click", "table.table-presensi tr", function()
	{
		clock.start();
		var tds = $(this).find('td')
		var tanggal = tds.eq(0).text()
		var mulai = tds.eq(3).text()
		var selesai = tds.eq(4).text()
		var lebih_jam = tds.eq(9).text()
		var lebih_menit = tds.eq(10).text()
		var waktu = mulai + " - " + selesai
		var waktu_lembur = lebih_jam + ":" + lebih_menit
		$("#ok").prop('disabled', false)
		
		$("#tgl_lembur").val(tanggal)
		$("#waktu").val(waktu)
		$("#waktu_lembur").val(waktu_lembur)
		$("#data").html("")
		//alert('Tanggal: ' + tanggal + 'Mulai: ' + mulai + 'Jam Selesai: ' + selesai);
		
		//cek data double
		$(".tgl-lembur").each(function(){
			//alert($("#tgl_lembur").val())
			if($("#tgl_lembur").val() == $(this).text()){
				//alert("sudah ada data yang sama")
				$("#ok").prop('disabled', true)
			} else {
				$("#ok").prop('disabled', false)
				//$('#edit_data').hide();
			}
		})
	})
	
	$(document).on("click", "#ok", function()
	{
		
		//set variabel
		var tahun = $("#tahun").val()
		var bulan = $("#bulan").val()
		var nip = $("#nip").val()
		var nama = $("#nama").val()
		var golongan = $("#golongan").val()
		var unit_kerja = $("#unit_kerja").val()
		var tgl_lembur   = $("#tgl_lembur").val()
		var uraian   	 = $("#uraian").val()
		var waktu 	  	 = $("#waktu").val()
		var waktu_lembur = $("#waktu_lembur").val()
		var i=0
		
		//hitung lama lembur (jam)
		//var jml_menit = getMenit(waktu_lembur)
		//var jml_jam = getMenit(waktu_lembur) / 60
		//var honor_lembur = jml_jam * 0

		$.ajax({
            type: "POST",
            url: "views/form_lembur_crud.php",
            data: {
            	tahun:tahun,
            	bulan:bulan,
            	nip:nip,
            	nama:nama,
            	golongan:golongan,
            	unit_kerja,
				tgl_lembur:tgl_lembur,
				uraian:uraian,
				waktu:waktu,
				waktu_lembur:waktu_lembur,
				crud:2
			},
            
            success: function(data) {
                //console.log(data)
                $("#test").html(data)
                fetch_data()
                clock.start();
            }
        })
		
		$(".modal").modal('hide')
	})
	
	$(document).on("click", ".remove", function()
	{
		clock.start();
		var id = $(this).closest("tr").attr("id")
		
		$.ajax({
            type: "POST",
            url: "views/form_lembur_crud.php",
            data: {id:id, crud:3},
            success: function(data) {
                fetch_data()
            }
        })
	})
	
	$(document).on("click", "#simpan-deskripsi", function()
	{
		clock.start();
		var nip = $("#nip").val()
		var deskripsi       = CKEDITOR.instances.deskripsi.getData()
		alert(nip+' '+deskripsi)
		$.ajax({
            type: "POST",
            url: "views/form_lembur_crud.php",
            data: {nip:nip, deskripsi:deskripsi, crud:4},
            success: function(data) {
                $("#test").html(data)
            }
        })
	})
	
	$(document).on('focusin', '.uraian', function()
	{
		clock.start();
		$(this).closest('td').find('span').remove()
		$(this).closest('td').append('<div><span class="cancel btn btn-xs btn-danger glyphicon glyphicon-remove"></span><span class="simpan btn btn-xs btn-success glyphicon glyphicon-ok" ></span></div>')
	});
	
	$(document).on('click', '.simpan', function()
	{
		clock.start();
		var id = $(this).closest("td").parent().attr("id")
		var field = $(this).closest("td").attr("class")
		var value = $(this).closest("td").text()

		$.ajax({  
			url:"views/form_lembur_crud.php",  
			method:"POST",  
			data:{id:id, field:field, value:value, crud:7},  
			dataType:"text",  
			success:function(data){  
				alert(data);
				//$(this).closest('td').find('div').remove()

			}  
		});
	});
	
	$(document).on('click', '.cancel', function(e){
		clock.start();
		$(this).closest('td').find('div').remove()
	});

	$(document).on('click', '#tambah', function(e){
		clock.start();
	});
})
</script>

<style type="text/css">
table.ketentuan tr td {
	padding: 3px;
}
table.ketentuan tr th{
	background-color: #eee;
	text-align:center;
}
.panel-heading {
	background: gray !important;
	color: #fff !important;
}
table#pelaksanaan-lembur{
	font-size: 13px;
}
pre {
	background-color: #fbfbfb !important;
}
span.total-label{
	font-weight: bold;
	background-color: #ddd;
	border: 1px solid #ddd;
	color: #666;
	padding: 3px;
}
span.total-value{
	border: 1px solid #ddd;
	padding: 0 2px;
	color: #444;
	padding: 3px 10px;
}
</style>