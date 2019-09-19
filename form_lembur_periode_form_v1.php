<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../assets/images/favicon.ico">

<title>Test Periode Penutupan</title>

<!-- Bootstrap core CSS -->
<link href="../../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../../bootstrap/css/justified-nav/justified-nav.css" rel="stylesheet">
<link href="../../../assets/css/fontawesome.css" rel="stylesheet">
<script type="text/javascript" src="../../../lib/js/jquery-1.11.2.min.js"></script>	
<link rel="stylesheet" href="../../../assets/font-awesome-4.6.1/css/font-awesome.css"/>
<link rel="stylesheet" href="../../../assets/font-awesome-4.6.1/css/font-awesome-animation.css"/>
<!--<script src="../../lib/js/jquery.countdown360.min.js" type="text/javascript" charset="utf-8"></script>-->

</head>

<body>
<section>
	<div class="panel panel-default">
		<!-- data ketentuan -->
		<div class="panel-heading bg-info">
			<h3 class="panel-title text-center" style="line-height:5px !important">CLOSING TRANSAKSI DATA LEMBUR</h3>
		</div>
		<div class="panel-body">
			<div class="row">
					<div class="col-md-12">
						<div id="data"></div>
					</div>
			</div>	
		</div>
	</div>	
</section>

<!-- modal Edit Presensi / Tanggal atau jam lembur -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit-label">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background:#eee">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="presensiModalLabel">Update</h4>
			</div>
			<div class="modal-body">
				<div id="data-edit">
					<!--
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
					-->
				</div>
			</div>
		</div>
	</div>
</div>

</body>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../../bootstrap/js/jquery.min.js"></script>
<script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../bootstrap/assets/js/docs.min.js"></script>
<script src="../../bootstrap/js/bootstrap3-typeahead.min.js"></script>

<script src="../../../assets/datepicker/bootstrap-datepicker.js"></script>
<script src="../../../assets/datepicker/locales/bootstrap-datepicker.id.js"></script>
<link href="../../../assets/datepicker/datepicker3.css" rel="stylesheet">
<!--
<script src="../../lib/js/jquery.countdown360.min.js" type="text/javascript" charset="utf-8"></script>

<script src="../../../DataTables/media/js/jquery.dataTables.min.js"></script>
<link href="../../../DataTables/media/css/jquery.dataTables.min.css" rel="stylesheet">
-->
<script type="text/javascript">
$(document).ready(function(){
	
	//rubah ke format indonesia
    $.fn.datepicker.defaults.autoclose = 'TRUE';
    $.fn.datepicker.defaults.language = 'id';
    $.fn.datepicker.defaults.format = "DD, dd MM yyyy";

	$(document).on('focus', '#tgl_cutoff', function(e){
        $("#tgl_cutoff").datepicker()
    })

	//refresh data
	fetchData();
	function fetchData(){
		$.ajax({
	        type: "POST",
	        url: "form_lembur_periode_data.php",
	        success: function(data) {
	        	$("#data").html(data)
	        }
	    })
	}
	
	$(document).on("click", ".edit", function(){

		//set variabel
		var id = $(this).parent().parent().attr("id")
		var periode = $(this).parent().parent().find("td").eq(1).text()
		var tgl_cutoff = $(this).parent().parent().find("td").eq(2).text()
		var status = $(this).parent().parent().find("td").eq(3).text()
		
		$("#periode").val(periode)
		$("#tgl_cutoff").val(tgl_cutoff)
		$("#status").val(status)
		
		$.ajax({
            type: "POST",
            url: "form_lembur_periode_crud.php",
            data: {
            	periode:periode,
            	tgl_cutoff:tgl_cutoff,
				status:status,
				crud:1
			},            
            success: function(data) {
                $("#data-edit").html(data)
            }           
        })

		$("#modal-edit").modal("show")
	})
	
	$(document).on("click", ".simpan-cutoff", function(e){
		e.preventDefault()
		
		//set variabel
		periode = $("#periode").val()
		tgl_cutoff = $("#tgl_cutoff").val()
		//alert(periode+' '+tgl_cutoff+' '+status)
		$.ajax({
            type: "POST",
            url: "form_lembur_periode_crud.php",
            data: {
            	periode:periode,
            	tgl_cutoff:tgl_cutoff,
				crud:2
			},            
            success: function(data) {
                fetchData();
                $("#modal-edit").modal("hide")
            }           
        })
	})

    $(document).on("click", ".edit-closing", function(){

		//set variabel
		var id = $(this).parent().parent().attr("id")
		var periode = $(this).parent().parent().find("td").eq(1).text()
		var status = $(this).parent().parent().find("td").eq(3).text()
		
		$.ajax({
            type: "POST",
            url: "form_lembur_periode_crud.php",
            data: {
            	periode:periode,
				status:status,
				crud:3
			},            
            success: function(data) {
                $("#data-edit").html(data)
            }           
        })

		$("#modal-edit").modal("show")
	})

	$(document).on("click", ".simpan-closing", function(e){
		e.preventDefault()
		
		//set variabel
		periode = $("#periode").val()
		status = $("#status").val()
		//alert(periode+' '+tgl_cutoff+' '+status)
		$.ajax({
            type: "POST",
            url: "form_lembur_periode_crud.php",
            data: {
            	periode:periode,
            	status:status,
				crud:4
			},
            success: function(data) {
            	fetchData();
                $("#modal-edit").modal("hide")
                //alert(data)
            }          
        })
	})
    
})
</script>

</html>