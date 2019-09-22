<?php
/*
include('fungsi_set_periode.php');
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
*/
include "views/form_lembur_periode_set_periode.php";

?>
<input type="hidden" id="periode_berjalan" value="<?=$tahun.$array_bulan1[$bulan]?>">
<!--<div class="blink_me">B E T A</div>
<div class="container">-->
	
	<div class="panel panel-default">
		<!-- data ketentuan -->
		<div class="panel-heading" style="background:#fa0 !important; color:#555 !important; text-align:center">
			<h3 class="panel-title text-center" style="line-height:5px !important">KETENTUAN</h3>
		</div>
		<div class="panel-body">
			<div class="row">
					<? include 'ketentuan.php' ?>
			</div>	
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading" style="text-align:center">
			<h3 class="panel-title">REKAP PELAKSANAAN LEMBUR</h3>
		</div>
		
		<div class="panel-body">
			<div class="row">
				<form class="row" action="views/form_lembur_download_xlsx.php" method="post">
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
					<!--
				    <div class="btn-group" role="group" aria-label="...">
				    	<input type="submit" class="btn btn-success" value="Download Excel" />
					</div>
					-->
				    <div class="col-xs-2"></div>
				</form>

			</div>	
		</div>
		
		<div class="panel-body" style="overflow:auto">
			<div class="col-xs-12 pull-left" id="info"></div>
			<!--<div class="row">
				<div class="col-xs-3 pull-right">
					<div class="btn-group" role="group" aria-label="...">
						<a href="views/form_lembur_download_xlsx.php" type="button" class="btn btn-success" id="excel">
							<i class="fa fa-file-excel-o" style="font-size:17px;color:#fff"></i>&nbsp;download
						</a>
					</div>
				</div>
			</div>-->
			<br>	
			<div id="data-pemohon"></div>			
		</div>
	</div>
<!--</div>-->


<!-- modal approval -->
<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="approvalModalLabel">Form Persetujuan Kepala Unit</h4>
			</div>
			<div class="modal-body">
				<div id="form-approval"></div>
			</div>
			<div class="modal-footer">
				<span>
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
				</span>
				<span id="aksi">
					<button type="button" class="btn btn-primary" id="approve" disabled="disabled">Ajukan</button>
					<button type="button" class="btn btn-danger" id="rollback" disabled="disabled">Tolak</button>
				</span>
			</div>
		</div>
	</div>
</div>


<?php
include_once('assets/css/blink_me.php');
?>
<script type="text/javascript">
$(document).ready(function(){
	function getDataPemohon()
	{
		var tahun = $("#tahun").val()
		var bulan = $("#bulan").val()
		var array = {'Januari':'01','Februari':'02','Maret':'03','April':'04','Mei':'05', 'Juni':'06','Juli':'07','Agustus':'08','September':'09','Oktober':'10','November':'11','Desember':'12'}
		var periode = tahun+array[bulan];
		var periode_berjalan = $("#periode_berjalan").val()
    
		//refresh data
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_unit_get_data_pemohon.php",
			data:{tahun:tahun, bulan:bulan},
	        success: function(data) {
				$("#data-pemohon").html(data)
				//alert(data)
	        }    
	    })
	}
	getDataPemohon()

	$(document).on("click", ".approval", function()
	{
		clock.start();
		var id = $(this).closest("tr").attr("id")
		var nip = $(this).closest("tr").data("nip")
		var tahun = $("#tahun").val()
		var bulan = $("#bulan").val()
		$('#approvalModal').modal('show');
		
		//tampilkan detail lembur untuk pemohon yg dipilih
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_unit_approval.php",
	        data: {nip:nip, tahun:tahun, bulan:bulan},
	        success: function(data) {
				$("#form-approval").html(data)
				//alert(data)
	        }    
	    })

		//ambil data flag closing
		$.ajax({
        	type: 'POST',
        	url: 'views/form_lembur_periode_crud.php',
        	data: {tahun:tahun, bulan:bulan, crud:8},
        	success: function (data) {
    			//jika flag closing = 1 maka nonaktifkan fungsi tambah data
		    	if (data==1){
			    	$('#info').html('');
					$('#aksi').html('');
		    	} else {
		    		$('#info').html('<ul style="font-size:12px;" class="text-info">'+
								'<li>Data yang muncul adalah data lembur yang sudah diajukan oleh staf</li>' +
								'<li>Tekan tombol <font class="label label-warning">Approval</font> untuk melihat detail lembur pegawai</li>' + 
							'</ul>')
					$('#aksi').html('<button type="button" class="btn btn-primary" id="approve">Ajukan</button>' + 
						'<button type="button" class="btn btn-danger" id="rollback">Ditolak</button>');
		    	}
        	}
    	})	    
        
		//jika sudah disetujui nonaktifkan fungsi persetujuan
		$.ajax({
	        type: "POST",
	        url: "views/cek_status_lembur.php",
	        data: {nip:nip, tahun:tahun, bulan:bulan},
	        success: function(data) {
				if(data==1 || data==2 ){
					$('#aksi').html('')
				} /*else {
					
					$('#aksi').html('<button type="button" class="btn btn-primary" id="approve">Ajukan</button>' + 
								'<button type="button" class="btn btn-danger" id="rollback">Ditolak</button>')
				} */
				
	        }    
	    })
		
	})

	/*
	$(document).on("click", "#approve", function()
	{
		clock.start();
		var r = confirm("Anda yakin akan Memberikan Persetujuan");
		if (r == true) {
			//$('#approvalModal').modal('show');
			var nip = $("#nip").val()
			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_crud.php",
		        data: {nip:nip, crud:5},
		        success: function(data) {
					var nip = $("#nip").val()
					var tahun = $("#tahun").val()
					var bulan = $("#bulan").val()
					$.ajax({
				        type: "POST",
				        url: "views/form_lembur_unit_approval_refresh.php",
				        data: {nip:nip, tahun:tahun, bulan:bulan},
				        success: function(res) {
							$("#table-data").html(res)
				        }    
				    })
					$('#aksi').html('');
		        }    
		    })
		}
	})
	*/
	
	$(document).on("click", "#approve", function()
	{
		clock.start();
		var id = $('.approval-check:checked').map(function(_, el) {
            return $(el).val()
        }).get()
		
		//$('#approvalModal').modal('show');
		var nip = $("#nip").val()
		var r = confirm("Apakah anda yakin memberikan persetujuan pengajuan lembur?");
		if (r == true) {
			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_crud.php",
		        data: {id:id, crud:5},
		        success: function(data) {
					var nip = $("#nip").val()
					var tahun = $("#tahun").val()
					var bulan = $("#bulan").val()
					$.ajax({
				        type: "POST",
				        url: "views/form_lembur_unit_approval_refresh.php",
				        data: {nip:nip, tahun:tahun, bulan:bulan},
				        success: function(res) {
							$("#table-data").html(res)
				        }    
				    })
		        }    
		    })
		}
	})
	
	/*
	$(document).on("click", "#rollback", function()
	{
		clock.start();
		var nip = $("#nip").val()
		
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_crud.php",
	        data: {nip:nip, crud:6},
	        success: function(data) {
				var nip = $("#nip").val()
				var tahun = $("#tahun").val()
				var bulan = $("#bulan").val()
				$.ajax({
			        type: "POST",
			        url: "views/form_lembur_unit_approval_refresh.php",
			        data: {nip:nip, tahun:tahun, bulan:bulan},
			        success: function(res) {
						$("#table-data").html(res)
			        }    
			    })
	        }    
	    })
	})
	*/
	
	$(document).on("click", "#rollback", function()
	{
		clock.start();
		var id = $('.rollback-check:checked').map(function(_, el) {
            return $(el).val()
        }).get()

		var nip = $("#nip").val()
		
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_crud.php",
	        data: {id:id, crud:6},
	        success: function(data) {
				//refresh data 
				var nip = $("#nip").val()
				var tahun = $("#tahun").val()
				var bulan = $("#bulan").val()
				$.ajax({
			        type: "POST",
			        url: "views/form_lembur_unit_approval_refresh.php",
			        data: {id:id, nip:nip, tahun:tahun, bulan:bulan},
			        success: function(res) {
						$("#table-data").html(res)
			        }    
			    })
	        }    
	    })
	})
	
	
	$(document).on("focusin", ".keterangan, .waktu_lembur_disetujui", function()
	{
		clock.start();
		$(this).closest('td').find('span').remove()
		$(this).closest('td').append('<div><span class="loading"></span><span class="cancel btn btn-xs btn-danger glyphicon glyphicon-remove"></span><span class="simpan btn btn-xs btn-success glyphicon glyphicon-ok" ></span></div>')
	});

	$(document).on('click', '.simpan', function()
	{
		clock.start();
		var r = confirm("Apakah anda menyimpan data?");
		if (r == true) {
			var id = $(this).closest("td").parent().attr("id")
			var field = $(this).closest("td").attr("class")
			var value = $(this).closest("td").text()
			$(this).siblings().text("loading...")
			
			$.ajax({  
				url:"views/form_lembur_crud.php",  
				method:"POST",  
				data:{id:id, field:field, value:value, crud:7},  
				dataType:"text",  
				success:function(data){  
					//getDataPemohon()
					//$(this).closest('td').find('div').remove()
					//refresh data 
					var nip = $("#nip").val()
					var tahun = $("#tahun").val()
					var bulan = $("#bulan").val()
					$.ajax({
				        type: "POST",
				        url: "views/form_lembur_unit_approval_refresh.php",
				        data: {id:id, nip:nip, tahun:tahun, bulan:bulan},
				        success: function(res) {
							$("#table-data").html(res)
				        }    
				    })
				}  
			});
		} else {
			$(this).closest('td').find('div').remove()
		}
		
	});

	$(document).on('click', '.cancel', function(e){
		clock.start();
		$(this).closest('td').find('div').remove()
	});

	$('#approvalModal').on('hidden.bs.modal', function () {
		clock.start();
		getDataPemohon()
	})
	
	$(document).on("change", "#tahun, #bulan", function(e){
		clock.start()
		getDataPemohon()
	});

	$(document).on("click", ".approval-check-all", function(){
        $(".approval-check:checkbox").not(this).prop('checked', this.checked);
    })
    
     $(document).on("click", ".rollback-check-all", function(){
        $(".rollback-check:checkbox").not(this).prop('checked', this.checked);
    })
    
	//jika check disetujui dipilih maka aktifkan tombol ajukan
	$(document).on("change", ".approval-check, .approval-check-all", function(){
		
		var count_check = $('.approval-check:checked').map(function(_, el) {
           return $(el).val() 
        }).get()
        
        if (count_check.length > 0){
        	$("#approve").prop("disabled", false)
		} else {
			$("#approve").prop("disabled", true)
		}
    })
    
    //jika check tolak dipilih maka aktifkan tombol Tolak
	$(document).on("change", ".rollback-check, .rollback-check-all", function(){
		
		var count_check = $('.rollback-check:checked').map(function(_, el) {
           return $(el).val() 
        }).get()
        
        if (count_check.length > 0){
        	$("#rollback").prop("disabled", false)
		} else {
			$("#rollback").prop("disabled", true)
		}
    })
    
})
</script>

<style type="text/css">
/* modify modal*/
.modal-dialog {
    width: 90%;
}

/* ketentuan */
table.ketentuan tr td {
	padding: 3px;
}
table.ketentuan tr th{
	background-color: #eee;
	text-align:center;
}

/* panel */
.panel-heading {
	background: gray !important;
	color: #fff !important;
}
pre {
	background-color: #fefefe !important;
}
table#pelaksanaan-lembur{
	font-size: 13px;
}
/*
table#pelaksanaan-lembur thead th, table#pelaksanaan-lembur tbody td{
	font-size: 12px;
	border: 1px solid #aaa;*/
}
#data-pemohon{
	overflow: auto;
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

table#pelaksanaan-lembur thead tr th {
	background-color:#eee !important;
}

.table#pelaksanaan-lembur tr:nth-child(even) {
    background-color: #fcfcfc;
}
</style>