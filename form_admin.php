
	<h3 align="center">FORMULIR SDM</h3><br />  
	<div id="live_data"></div>
<!-- test -->

	
	<div id="test" class="btn btn-default btn-sm screen" data-toggle="modal" data-target="#myModal" data-tt="tooltip" title="cetak ke layar">
		<i style="font-size:15px; color:#428bca" class="glyphicon glyphicon-plus"></i>
	</div>
	

<!-- Modal Upload -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		  	<div class="modal-header" style="background:#f6dB00; color:#000; text-shadow: 0px 1px 1px #fff">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel" style="text-align:center">Upload Formulir</h4>
		  	</div>
			<div class="modal-body">
				<?//=$html?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!--<button type="button" class="btn btn-primary">Save changes</button>-->
			</div>
		</div>
  	</div>
</div>	

<script>
 $(document).ready(function(){
 	$.fn.datepicker.defaults.autoclose = 'TRUE';
    $.fn.datepicker.defaults.language = 'id';
    $.fn.datepicker.defaults.format = "dd MM yyyy";

      function fetch_data()  
      {  
           $.ajax({  
                url:"views/form_crud.php",  
                method:"POST",
                data:{crud:"select"},  
                dataType:"text",
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      }
      fetch_data();
      
      $(document).on('click', '#btn_add', function(){  
           var file_kode = $('#file_kode').text();  
           var file_name = $('#file_name').text();
           var tgl_revisi = $('#tgl_revisi').val();  
           if(file_kode == '')  
           {  
                alert("Enter Kode File");  
                return false;  
           }  
           if(file_name == '')  
           {  
                alert("Enter Nama File");  
                return false;  
           }  
           $.ajax({  
                url:"views/form_crud.php",  
                method:"POST",  
                data:{file_kode:file_kode, file_name:file_name, tgl_revisi:tgl_revisi, crud:"insert"},  
                dataType:"text",  
                success:function(data)  
                {  
                     alert(data);  
                     fetch_data();  
                }  
           })  
      }); 
      $(document).on('click', '.btn_delete', function(){  
           var id=$(this).data("id4");
           if(confirm("Are you sure you want to delete this?"))  
           {  
                $.ajax({  
                     url:"views/form_crud.php",  
                     method:"POST",  
                     data:{id:id, crud:"delete"},  
                     dataType:"text",  
                     success:function(data){  
                          alert(data);  
                          fetch_data();  
                     }  
                });  
           }  
      });
      $(document).on('focusin', '.file_kode, .file_name', function(){
      	$(this).closest('td').find('span').remove()
      	$(this).closest('td').append('<span class="cancel btn btn-xs btn-danger">cancel</span><span class="simpan btn btn-xs btn-success" >save </span>')
      });
       $(document).on('change', '.tgl_revisi', function(){
      	$(this).closest('td').find('span').remove()
      	$(this).closest('td').append('<span class="cancel btn btn-xs btn-danger">cancel</span><span class="simpan btn btn-xs btn-success" >save </span>')
      });
	$(document).on('click', '.cancel', function(e){
           $(this).closest('td').find('span').remove()
      });
	$(document).on('click', '.simpan', function(){
      	var value = $(this).closest('td').find('input').val()
          var id = $(this).parent().parent().data('id')
          var field = $(this).closest('td').data('kolom')
           $.ajax({  
                url:"views/form_crud.php",  
                method:"POST",  
                data:{id:id, text:value, column_name:field, crud:"edit"},  
                dataType:"text",  
                success:function(data){  
                     alert(data);
                }  
           });
           $(this).closest('td').find('span').remove()
      });
      
	$(document).on('click', '.screen', function(e){
		e.preventDefault();
		//$('.modal-body').html('');
		var nip = $(this).attr('id');
		var periode = $("#periode").val();
		
		$.ajax({
			type: "POST",
			url: "views/form_upload_index.php",
			/*data: {nip:nip, periode:periode},*/
			success: function(data){				
				$('.modal-body').html(data);
				clock.start();
			}
		});	
	});


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
 <style>
 input{border:none}
  </style>
 </html>