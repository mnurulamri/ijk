
<!doctype html>
<html lang="en">
  <head>
    <title>PHP AHMED</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
	  body{padding:200px;background:#6C7A89;}
	</style>
   </head>
<body>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <div class="container col-lg-7">
	  <form class="input-group" id="uploadForm" action="form_upload.php" method="post">
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="file_upload" id="file_upload" required>
          <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
        </div>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit" id="btnSubmit" value="Submit">Upload</button>
        </div>
      </form>
	   <br>
	  <div class="progress">
        <div class="progress-bar bg-success" id="progress-bar" style="width: 65%">65%</div>
      </div>
	  <br>
	  <div id="targetLayer"></div>
	</div>

<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script>
	
$(document).ready(function() { 
	
	 $('#uploadForm').submit(function(e) {	
		if($('#form_upload').val()) {
			e.preventDefault();
			$(this).ajaxSubmit({ 
				target:   '#targetLayer', 
				beforeSubmit: function() {
				  $("#progress-bar").width('0%');
				},
				uploadProgress: function (event, position, total, percentComplete){	
					$("#progress-bar").width(percentComplete + '%');
					$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
				},
				success:function (){
	          
				},
				resetForm: true 
			}); 
			// return false; 
		}
	});
});

</script>
</html>