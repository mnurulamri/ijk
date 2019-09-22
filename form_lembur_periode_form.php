<!--<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../assets/images/favicon.ico">

<title>Test Periode Penutupan</title>-->

<!-- Bootstrap core CSS 
<link href="../../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../../bootstrap/css/justified-nav/justified-nav.css" rel="stylesheet">
<link href="../../../assets/css/fontawesome.css" rel="stylesheet">
<script type="text/javascript" src="../../../lib/js/jquery-1.11.2.min.js"></script>	
<link rel="stylesheet" href="../../../assets/font-awesome-4.6.1/css/font-awesome.css"/>
<link rel="stylesheet" href="../../../assets/font-awesome-4.6.1/css/font-awesome-animation.css"/> -->
<!--<script src="../../lib/js/jquery.countdown360.min.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>-->
<div class="row">
	<div class="col-md-offset-2 col-md-8 col-md-offset-2">
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
	</div>	
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster 
<script src="../../bootstrap/js/jquery.min.js"></script>
<script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../bootstrap/assets/js/docs.min.js"></script>
<script src="../../bootstrap/js/bootstrap3-typeahead.min.js"></script>

<script src="../../../assets/datepicker/bootstrap-datepicker.js"></script>
<script src="../../../assets/datepicker/locales/bootstrap-datepicker.id.js"></script>
<link href="../../../assets/datepicker/datepicker3.css" rel="stylesheet">-->

<script type="text/javascript">
$(document).ready(function(){
	//refresh data
	fetchData();
	function fetchData(){
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_periode_data.php",
	        success: function(data) {
	        	$("#data").html(data)
	        }
	    })
	}
	
	$(document).on("click", "#test", function(){
		alert("test")
	})
	
	//set cutoff
	//$(".cutoff").on('change', function() {
	$(document).on("change", ".cutoff", function(){

		id = $(this).data("id")
		tahun = $(this).data("tahun")
		bulan = $(this).data("bulan")
			
	    if ($(this).is(':checked')) {
	        switchStatus = $(this).is(':checked');
			
	        //alert(switchStatus + ' ' + id + ' ' + tahun + ' ' + bulan);// To verify
	
			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_periode_crud.php",
				data: {
	            	tahun:tahun,
	            	bulan:bulan,
	            	flag_cutoff:switchStatus,
					crud:5
				},
		        success: function(data) {
		        	//$("#data").html(data)
					//alert(data)
		        }
	    	})
	    }
	    else {
	       switchStatus = $(this).is(':checked');
	       id = $(this).data("id")
	       //alert(switchStatus + ' ' + id + ' ' + tahun + ' ' + bulan);// To verify
	
			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_periode_crud.php",
				data: {
	            	tahun:tahun,
	            	bulan:bulan,
	            	flag_cutoff:switchStatus,
					crud:5
				},
		        success: function(data) {
		        	//$("#data").html(data)
					//alert(data)
		        }
	    	})
	    }
	});
	
	//set closing
	$(document).on("change", ".closing", function(){
	    id = $(this).data("id")
		tahun = $(this).data("tahun")
		bulan = $(this).data("bulan")
			
	    if ($(this).is(':checked')) {
	        switchStatus = $(this).is(':checked');
			
	        //alert(switchStatus + ' ' + id + ' ' + tahun + ' ' + bulan);// To verify
	
			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_periode_crud.php",
				data: {
	            	tahun:tahun,
	            	bulan:bulan,
	            	flag_closing:switchStatus,
					crud:6
				},
		        success: function(data) {
		        	//$("#data").html(data)
					//alert(data)
		        }
	    	})
	    }
	    else {
	       switchStatus = $(this).is(':checked');
	       id = $(this).data("id")
	       //alert(switchStatus + ' ' + id + ' ' + tahun + ' ' + bulan);// To verify
	
			$.ajax({
		        type: "POST",
		        url: "views/form_lembur_periode_crud.php",
				data: {
	            	tahun:tahun,
	            	bulan:bulan,
	            	flag_closing:switchStatus,
					crud:6
				},
		        success: function(data) {
		        	//$("#data").html(data)
					//alert(data)
		        }
	    	})
	    }
	
		//jika nilai checked = true maka refresh data
		if ($(this).is(':checked') == true){
			fetchData();
		}
	});
})
</script>
<!--
</body>
-->