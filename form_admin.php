
	<h3 align="center">FORMULIR SDM</h3><br />  
	<div id="live_data"></div>

	<div id="test" class="btn btn-default btn-sm screen" data-toggle="modal" data-target="#myModal" data-tt="tooltip" title="cetak ke layar">
		<i style="font-size:15px; color:#428bca" class="glyphicon glyphicon-plus"></i>
	</div>
	
  <!--<script type="text/javascript" src="../../lib/js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="../../lib/js/jquery.form.js"></script>	-->

<!-- Modal View -->
<div class="modal fade" id="myModalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background:#f6dB00; color:#000; text-shadow: 0px 1px 1px #fff">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" style="text-align:center">Formulir</h4>
        </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-10by1">
          <!--<iframe src="https://docs.google.com/gview?url=https://remun.ppaa.fisip.ui.ac.id/ijk/dokumen/C-00.doc &embedded=true" frameborder="0"></iframe>-->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
    </div>
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
				
        <form id="upload_form" enctype="multipart/form-data" method="post">
          <input type="hidden" name="action" id="action" value="test action">
          <input type="hidden" name="post_file_kode" id="post_file_kode" value="">
          <input type="file" name="file_upload" id="file_upload" onchange="uploadFile()"><br>
          <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
          <h3 id="status"></h3>
          <p id="loaded_n_total"></p>
          <p id="result"></p>
        </form>
          
          <script>
          	
        function _(el) {
          return document.getElementById(el);
        }

        function uploadFile() {
          var file = _("file_upload").files[0];
          var action = _("action").value;
          var post_file_kode = _("post_file_kode").value;
          //alert(file.name+" | "+file.size+" | "+file.type);
          var formdata = new FormData();
          formdata.append("action", action);
          formdata.append("file_upload", file);
          formdata.append("post_file_kode", post_file_kode);
          var ajax = new XMLHttpRequest();
          ajax.upload.addEventListener("progress", progressHandler, false);
          ajax.addEventListener("load", completeHandler, false);
          ajax.addEventListener("error", errorHandler, false);
          ajax.addEventListener("abort", abortHandler, false);
          ajax.open("POST", "views/form_upload.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
          
          //use file_upload_parser.php from above url
          ajax.send(formdata);
        }

        function progressHandler(event) {
          _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
          var percent = (event.loaded / event.total) * 100;
          _("progressBar").value = Math.round(percent);
          _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandler(event) {
          _("status").innerHTML = event.target.responseText;
          _("progressBar").value = 0; //wil clear progress bar after successful upload
          _("test-data").innerHTML = event.target.responseText;
        }

        function errorHandler(event) {
          _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
          _("status").innerHTML = "Upload Aborted";
        }

        </script>

			</div>
			<div class="modal-footer">
				<button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
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
      	$('#action').val('add');  
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
        $('#action').val('delete');  
        var id=$(this).data("id4");
        var file_kode = $('input[data-id1="' +id +'"]').val()
        if(confirm("Are you sure you want to delete this?"))  
        {  
          //hapus dokumen
          $.ajax({  
            url:"views/form_delete.php",  
            method:"POST",  
            data:{file_kode:file_kode, action:"delete"},  
            dataType:"text",  
            success:function(data){  
              //alert(data);  
            }  
          }); 

        //hapus data dari database
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

  $(document).on('click', '.edit', function(e){
    var id = $(this).data("id5")
    var file_kode = $('input[data-id1="' +id +'"]').val()
    $('#post_file_kode').val(file_kode)
  })

  $(document).on('click', '.view', function(e){
    var formulir = $(this).data("formulir")   
    var link = '<iframe src="https://docs.google.com/gview?url=https://remun.ppaa.fisip.ui.ac.id/ijk/dokumen/' + formulir + '&embedded=true" frameborder="0"></iframe>'
    $(".embed-responsive").html(link)
  })
  
  $(document).on('click', '#close', function(e){
    fetch_data();
    $("#upload_form").get(0).reset();  //bersihkan tampilan modal upload
    $('#status').text('');
    $('#loaded_n_total').text('');
    $('#result').text('');
  });
 });
 </script>

 <style>
 input{border:none}
  </style>

<style>
form 
{ 
  display: block; 
  margin: 20px auto; 
  background: #eee; 
  border-radius: 10px; 
  padding: 15px 
}
.progress 
{
  display:none; 
  position:relative; 
  width:400px; 
  border: 1px solid #ddd; 
  padding: 1px; 
  border-radius: 3px; 
}
.bar 
{ 
  background-color: #B4F5B4; 
  width:0%; 
  height:20px; 
  border-radius: 3px; 
}
.percent 
{ 
  position:absolute; 
  display:inline-block; 
  top:3px; 
  left:48%; 
}
/* form view */
.embed-responsive-10by1 {
   padding-top: 100%;
}
.view{
  cursor:pointer;
}
</style>
