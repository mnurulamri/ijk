<?php 
#include('fungsi_set_periode.php'); 
include "views/form_lembur_periode_set_periode.php";
?>
<!--<div class="blink_me">B E T A</div>
<div class="container">-->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">PELAKSANAAN LEMBUR</h3>
		</div>
		
		<div class="panel-body">
			<div class="row">
				<!--<form class="row" action="views/form_lembur_download_xlsx.php" method="post">-->
				<form class="row" action="views/test_xlsx.php" method="post">
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
				    <div class="btn-group" role="group" aria-label="...">
				    	<input type="submit" class="btn btn-success" value="Download Excel" />
					</div>
				    <div class="col-xs-2"></div>
				</form>

			</div>	
		</div>
		
		<div class="panel-body" style="overflow:auto">
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
				<h4 class="modal-title" id="approvalModalLabel">Form Approval</h4>
			</div>
			<div class="modal-body">
				<div id="form-approval"></div>
			</div>
			<div class="modal-footer">
				<span><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
				<span id="aksi"></span>
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
		
		//ambil data flag closing
		$.ajax({
        	type: 'POST',
        	url: 'views/form_lembur_periode_crud.php',
        	data: {tahun:tahun, bulan:bulan, crud:8},
        	success: function (data) {
    			//jika flag closing = 1 maka nonaktifkan fungsi tambah data
		    	if (data==1){
					$('#aksi').html('');
		    	} else {
					$('#aksi').html('<button type="button" class="btn btn-primary" id="approve">Ajukan</button>' + 
						'<button type="button" class="btn btn-danger" id="rollback">Tolak</button>');
		    	}
        	}
    	})
    
    	//refresh data
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_admin_get_data_pemohon_approved.php",
			data:{tahun:tahun, bulan:bulan},
	        success: function(data) {
				$("#data-pemohon").html(data)
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
	        url: "views/form_lembur_admin_approved_modal.php",
	        data: {id:id, nip:nip, tahun:tahun, bulan:bulan},
	        success: function(data) {
				$("#form-approval").html(data)
				//alert(data)
	        }    
	    })
	})
	
	$(document).on("click", "#approve", function()
	{
		clock.start();
		var r = confirm("Apakah anda yakin memberikan persetujuan pengajuan lembur?");
		if (r == true) {
			var id = $('.approval-check:checked').map(function(_, el) {
	            return $(el).val()
	        }).get()

			//$('#approvalModal').modal('show');
			var nip = $("#nip").val()
			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_crud.php",
		        data: {id:id, crud:9},
		        success: function(data) {
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
		        }    
		    })
		}
	})
	
	$(document).on("click", "#rollback", function()
	{
		clock.start();
		var r = confirm("Apakah anda yakin membatalkan persetujuan pengajuan lembur?");
		if (r == true) {
			var array = {'Januari':'01','Februari':'02','Maret':'03','April':'04','Mei':'05', 'Juni':'06','Juli':'07','Agustus':'08','September':'09','Oktober':'10','November':'11','Desember':'12'}
			var nip = $("#nip").val()
			var tahun = $("#tahun").val()
			var bulan = array[$("#bulan").val()]

			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_crud.php",
		        data: {tahun:tahun, bulan:bulan, nip:nip, crud:10},
		        success: function(data) {
		        	alert(data)
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
		        }    
		    })
		}
	})
	
	$(document).on("focusin", ".keterangan, .waktu_lembur_disetujui", function()
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
				alert(data)
				getDataPemohon()
				$(this).closest('td').find('div').remove()

			}  
		});
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
})
</script>

<style type="text/css">
/* modify modal*/
.modal-dialog {
    width: 90%;
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
</style>