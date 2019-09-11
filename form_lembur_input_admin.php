<?php
include('session_end.php');
include_once('assets/css/blink_me.php');

$array_bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$array_bulan1 = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05', 'Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
$array_bulan2 = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
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
<input type="hidden" id="periode_berjalan" value="<?=$tahun.$array_bulan1[$bulan]?>">
<div></div>
<!--<div class="blink_me">B E T A</div>-->
<!--<div class="container">-->
	
	<div class="panel panel-default">
		<!-- data ketentuan -->
		<div class="panel-heading" style="background:#fa0 !important; color:#555 !important">
			<h3 class="panel-title text-center" style="line-height:5px !important">KETENTUAN</h3>
		</div>
		<div class="panel-body">
			<div class="row">
					<? include 'ketentuan.php' ?>
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
				<form class="row" action="dokumen/form_pengajuan_lembur.php" method="post">
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
				    <div class="btn-group" role="group" aria-label="...">
				    	<!--<input type="submit" class="fa fa-file-word-o btn btn-primary" style="font-size:17px;color:#fff" value="download" />-->
					</div>
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
				        <input class="form-control" type="text" name="nama" id="nama" placeholder="type keywords to search"/>							
						<div id="kotaksugest"></div>
				    </div>
					<div class="col-xs-2 form-group">
				        <label>Golongan</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="golongan" id="golongan"/>
				    </div>

				    <div class="clearfix"></div>

				    <div class="col-xs-2 form-group">
				        <label>NPM/NIP/NUP</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="nip" id="nip"/>
				    </div>
					<div class="col-xs-2 form-group">
				        <label>PAF/Dept/Prodi</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="unit_kerja" id="unit_kerja"/>
				    </div>
				    <div class="clearfix"></div>
				    <div class="col-xs-4 form-group">
				    </div>
				    <div class="col-xs-2 form-group">
				        <input type="reset" value="clear to search" id="clear-to-search" class="btn btn-info"/>
				    </div>					
				</form>

			</div>	
		</div>
	</div>

	<!-- Data Penugasan -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title text-center" style="line-height:5px !important">PELAKSANAAN LEMBUR</h3>
		</div>
		<div class="panel-body" style="overflow:auto">
			<div id="table-data"></div>
			<div class="container">
				<!--
				<div class="row">
					<div class="col-xs-12" id="table-data"></div>
				</div>
				-->
				<div class="row">
					<div class="col-xs-8 pull-left" id="info">
						
					</div>
					<div class="col-xs-4 pull-right">
						<div class="btn-group" role="group" aria-label="..." id="flag-tambah">
							<!--<a href="dokumen/form_pengajuan_lembur.php" type="button" class="btn btn-primary" id="msword">
								<i class="fa fa-file-word-o" style="font-size:17px;color:#fff"></i>&nbsp;download
							</a>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#inputModal" id="tambah">tambah</button>-->
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<!-- Data Deskripsi -->
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
						<label for="tgl_lembur" class="text-primary">Silahkan pilih hari dan waktu lembur berdasarkan tanggal presensi</label>
						<?include 'views/form_lembur_presensi_perperiode_form.php';?>
					</div>
					<hr>
					<div class="col-xs-4 form-group">
						<label for="tgl_lembur">Hari/Tanggal</label>
						<input name="tgl_lembur" id="tgl_lembur" type="text"  class="form-control"value="" placeholder="Tanggal Lembur" disabled style="background-color:#fbfbfb"/>
					</div>
					<div class="col-xs-3 form-group">
						<label for="waktu">Presensi</label>
						<input name="waktu" id="waktu" type="text"  class="form-control"value="" placeholder="Waktu" disabled style="background-color:#fbfbfb"/>
					</div>
					<div class="col-xs-3 form-group">
						<label for="waktu_lembur">Waktu Lembur Lembur</label>
						<input name="waktu_lembur" id="waktu_lembur" type="text" class="form-control"value="" placeholder="Waktu Lembur" disabled style="background-color:#fbfbfb"/>
					</div>
					<div class="clearfix"></div>	
					<div class="form-group">
						<label for="uraian">Uraian Pekerjaan</label>
						<textarea id="uraian" name="uraian" rows="5" cols="80"></textarea>
						<!--<input name="uraian" id="uraian" type="text"  class="form-control"value="" placeholder="Uraian Pekerjaan yang Dilakukan"/>-->
					</div>

					<input type="reset" value="clear" id="clear" class="btn btn-info"/>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="ok">Simpan</button>
			</div>
		</div>
	</div>
</div>

<!-- modal Edit Presensi / Tanggal atau jam lembur -->
<div class="modal fade" id="presensiModal" tabindex="-1" role="dialog" aria-labelledby="presensiModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="presensiModalLabel">Data Presensi</h4>
			</div>
			<div class="modal-body">
				<div id="data-presensi"></div>
			</div>
		</div>
	</div>
</div>
<pre><div id="test"></div></pre></pre>
<script src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	
$(document).ready(function()
{
	CKEDITOR.replace('uraian')
	CKEDITOR.replace('deskripsi')
	
	function fetch_data()  
      { 
		var tahun = $("#tahun").val()
		var bulan = $("#bulan").val()
		var array = {'Januari':'01','Februari':'02','Maret':'03','April':'04','Mei':'05', 'Juni':'06','Juli':'07','Agustus':'08','September':'09','Oktober':'10','November':'11','Desember':'12'}
		var periode = tahun+array[bulan];
		var periode_berjalan = $("#periode_berjalan").val()
		var nip = $("#nip").val()

		if (periode<periode_berjalan) {
			$('#flag-tambah').html('')
			$('#info').html('');
		} else {
			$('#info').html('<div style="font-size:10px;" class="text-info">Tekan tombol <font class="label label-success">Tambah</font> untuk menginput data lembur</div>' + 
							'<div style="font-size:10px;" class="text-info"> Setelah melakukan penambahan data, silahkan menekan tombol <font class="label label-primary">Ajukan</font> untuk menaikkan status Menunggu Persetujuan Kepala Unit </div>')
			$('#flag-tambah').html('<button type="button" class="btn btn-success" data-toggle="modal" data-target="#inputModal" id="tambah">Tambah</button>'+
									'<button class="btn btn-primary" id="ajukan">Ajukan</button>'
									)
		}

    	$.ajax({
        	type: 'POST',
        	url: 'views/form_lembur_get_data.php',
        	data: {nip:nip, tahun:tahun, bulan:bulan, periode:periode, periode_berjalan:periode_berjalan},
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
				alert("tanggal pengajuan lembur " + $("#tgl_lembur").val() + " sudah terdaftar")
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
		var uraian = CKEDITOR.instances["uraian"].getData();
		//var uraian   	 = $("#uraian").val()
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
		var tanggal = $(this).parent().children(":first").text()
		clock.start();
		var r = confirm("Anda yakin akan menghapus pengajuan lembur tanggal: " + tanggal);
		if (r == true) {
			var id = $(this).closest("tr").attr("id")		
			$.ajax({
	            type: "POST",
	            url: "views/form_lembur_crud.php",
	            data: {id:id, crud:3},
	            success: function(data) {
	                fetch_data()
	            }
	        })			
		}
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
				fetch_data()
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
	
	//cek data double
	$(".tgl-lembur").each(function(){
		alert($("#tgl_lembur").val())
		if($("#tgl_lembur").val() == $(this).text()){
			alert("sudah ada data yang sama")
			$("#ok").prop('disabled', true)
		} else {
			$("#ok").prop('disabled', false)
			$("#edit_ok").prop('disabled', false)
		}
	})
	
	//edit tanggal lembur
	$(document).on("click", ".tgl-lembur,.mulai-lembur.selesai-lembur,.waktu-lembur", function(e){
		$("#presensiModal").modal('show')
		clock.start()
		var id = $(this).closest("td").parent().attr("id")
		$("#edit_id").val(id)
		var nip = $("#nip").val()
		$.ajax({
            type: "POST",
            url: "views/form_lembur_presensi.php",
            data: {nip:nip},
            success: function(data) {
            	$("#data-presensi").html(data)
            }
        })
	});
	
	$(document).on('click', 'div#data-presensi>div.row>div>table.table-presensi tr', function(e){
		clock.start();
		var tahun = $("#tahun").val()
		var bulan = $("#bulan").val()
		var nip = $("#nip").val()
		var nama = $("#nama").val()
		var golongan = $("#golongan").val()
		var unit_kerja = $("#unit_kerja").val()
		var tgl_lembur   = $("#tgl_lembur").val()
		var uraian   	 = $("#uraian").val()
		var id = $("#edit_id").val()
		var tds = $(this).find('td')
		var tanggal = tds.eq(0).text()
		var mulai = tds.eq(3).text()
		var selesai = tds.eq(4).text()
		var lebih_jam = tds.eq(9).text()
		var lebih_menit = tds.eq(10).text()
		var waktu = mulai + " - " + selesai
		var waktu_lembur = lebih_jam + ":" + lebih_menit
		
		var txt;
		var r = confirm("Anda yakin akan merubah tanggal pengajuan lembur!");
		if (r == true) {
			$.ajax({
	            type: "POST",
	            url: "views/form_lembur_crud.php",
	            data: {
	            	id:id,
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
					crud:8
				},	            
	            success: function(data) {
	                fetch_data()
	                clock.start();
	            }
	        })
		}
		
		$(".modal").modal('hide')
		
		//alert('id: ' + id + 'Tanggal: ' + tanggal + 'Mulai: ' + mulai + 'Jam Selesai: ' + selesai);
		
	});
	
	$(document).on("change", "#tahun, #bulan", function(e){
		clock.start();
		fetch_data();
	});

	$(document).on("click", "#ajukan", function(){
		var array = {'Januari':'01','Februari':'02','Maret':'03','April':'04','Mei':'05', 'Juni':'06','Juli':'07','Agustus':'08','September':'09','Oktober':'10','November':'11','Desember':'12'}
		var tahun = $("#tahun").val()
		var bulan = array[$("#bulan").val()]
		var nip = $("#nip").val()
		console.log(tahun + bulan + nip)
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_crud.php",
	        data: {tahun:tahun, bulan:bulan, nip:nip, crud:11},
	        success: function(data) {
				var bulan = $("#bulan").val()
	        	
				$.ajax({
			        type: "POST",
			        url: "views/form_lembur_get_data.php",
			        data: {nip:nip, tahun:tahun, bulan:bulan},
			        success: function(res) {
						$("#table-data").html(res)
			        }    
			    })
	        }    
	    })
	})
	
	$(document).on("keyup", "#nama", function(){
		var kata = $("#nama").val()
		$.ajax({
			type: "POST",             // Type of request to be send, called as method
			url: "views/form_lembur_cari_nama.php", // Url to which the request is send			
			data: {q:kata}, 	//  -> Data sent to server, a set of key/value pairs (i.e. form fields and values)
			success: function(data)   // A function to be called if request succeeds
			{
				$("#kotaksugest").html(data);
			}					
		})
	})

	$(document).on("click", ".isi", function(){
		var nip = $(this).attr("id")
		var nama = $(this).children().first().text()
		$("#kotaksugest").text("")
		var tds = $(this).find('td')
		$("#nip").val(tds.eq(0).text())
		$("#nama").val(tds.eq(1).text())
		$("#golongan").val(tds.eq(2).text())
		$("#unit_kerja").val(tds.eq(3).text())
		
		var tahun = $("#tahun").val()
		var bulan = $("#bulan").val()
		
		$.ajax({
        	type: 'POST',
        	url: 'views/form_lembur_get_data.php',
        	data:{nip:nip, tahun:tahun, bulan:bulan},
        	success: function (html) {	
            	$('#table-data').html(html);
        	}
    	})
    
    	$.ajax({
	        type: "POST",
	        url: "views/form_lembur_data_pemohon_json.php",
			data:{nip:nip},
			dataType: "json",
	        success: function(data) {
				CKEDITOR.instances["deskripsi"].setData(data.deskripsi)
	        }
	    })
	})
	/*
	$(document).on("click", "#clear", function(){
		$("#nama").focus()
		$("#kotaksugest").text("")
	})*/
	
	$(document).on("click", "#clear-to-search", function(){
		$("#nama").focus()
		$("#kotaksugest").text("")
	})
	
	$(document).on("change", "#nama", function(){
		var nama = $("#nama").val()
		if(nama==''){
			var string = "type keywords to search"
			$("#nama").val(string)
		}
		
	})
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