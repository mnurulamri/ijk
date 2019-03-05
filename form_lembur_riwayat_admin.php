<div class="blink_me">B E T A</div>
<!--<div class="container">-->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">PELAKSANAAN LEMBUR</h3>
		</div>
		<div class="panel-body">
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="approve">approve</button>
				<button type="button" class="btn btn-warning" id="rollback">rollback</button>
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
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_admin_get_data_pemohon.php",
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
		$('#approvalModal').modal('show');
		//tampilkan detail lembur untuk pemohon yg dipilih
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_admin_approval.php",
	        data: {id:id, nip:nip},
	        success: function(data) {
				$("#form-approval").html(data)
				//alert(data)
	        }    
	    })
	})
	
	$(document).on("click", "#approve", function()
	{
		clock.start();
		var id = $('.approval-check:checked').map(function(_, el) {
            return $(el).val()
        }).get()

		//$('#approvalModal').modal('show');
		var nip = $("#nip").val()
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_crud.php",
	        data: {id:id, crud:5},
	        success: function(data) {
				var nip = $("#nip").val()
				$.ajax({
			        type: "POST",
			        url: "views/form_lembur_admin_approval_refresh.php",
			        data: {nip:nip},
			        success: function(res) {
						$("#table-data").html(res)
			        }    
			    })
	        }    
	    })
	})
	
	$(document).on("click", "#rollback", function()
	{
		clock.start();
		var id = $('.rollback:checked').map(function(_, el) {
            return $(el).val()
        }).get()

		var nip = $("#nip").val()
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_crud.php",
	        data: {id:id, crud:6},
	        success: function(data) {
				var nip = $("#nip").val()
				$.ajax({
			        type: "POST",
			        url: "views/form_lembur_admin_approval_refresh.php",
			        data: {nip:nip},
			        success: function(res) {
						$("#table-data").html(res)
			        }    
			    })
	        }    
	    })
	})
	
	$(document).on('focusin', '.keterangan', function()
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

	$('#approvalModal').on('hidden.bs.modal', function () {
		clock.start();
		getDataPemohon()
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
</style>