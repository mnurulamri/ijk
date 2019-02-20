<div class="blink_me">U N D E R C O N S T R U C T I O N</div>
<div class="container">

	<div class="panel panel-default">
		<!-- data pemohon -->
		<div class="panel-heading">
			<h3 class="panel-title">DATA PEMOHON</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<form>
				    <div class="col-xs-2 form-group">
				        <label>Nama</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <!--<input class="form-control" type="text" name="nama" id="nama" onkeyup="lihat(this.value)"/>-->
				        <input class="form-control" type="text" name="nama" id="nama"/>							
						<div id="kotaksugest"></div>
				    </div>
					<div class="col-xs-2 form-group">
				        <label>Jabatan</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="jabatan" id="jabatan"/>
				    </div>

				    <div class="clearfix"></div>

				    <div class="col-xs-2 form-group">
				        <label>NPM/NIP/NUP</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="nip" id="nip"/>
				    </div>
					<div class="col-xs-2 form-group">
				        <label>Golongan</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="golongan" id="golongan"/>
				    </div>
				
					<div class="clearfix"></div>
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
				        <input type="reset" value="clear" id="clear"/>
				    </div>					
				</form>

			</div>	
		</div>
	</div>

	<!-- Data Penugasan -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">PELAKSANAAN LEMBUR</h3>
		</div>
		<div class="panel-body">
			<table class="table table-bordered" id="pelaksanaan-lembur">
				<thead>
			 	<tr>
			 		<th>Hari/Tanggal</th>
			 		<th>Uraian Pekerjaan yang Dilakukan</th>
			 		<th>Presensi</th>
			 		<th>Lebih Jam</th>
					<th>Lama Lembur <br>(jam)</th>
					<th></th>
			 	</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
			 		<td></td><td></td><td></td><td id="total"></td><td id="total_jam"></td><td></td>
			 	</tr>
				</tfoot>
			</table>
			<div class="row">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#inputModal" data-whatever="@mdo"><b>+</b></button>
			</div>
		</div>
	</div>	
	
	<!-- Data Penugasan -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">DESKRIPSI PELAKSANAAN LEMBUR</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 form-group">
					<!--<label for="deskripsi">Deskripsi Pelaksanaan Kerja Lembur</label>-->
					<textarea id="deskripsi" name="deskripsi" rows="5" cols="80"></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-primary" id="simpan"> simpan </button>
	</div>
</div>
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

<!-- modal edit data -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="editModalLabel">Edit Lembur</h4>
			</div>
			<div class="modal-body">
				<form id="edit-lembur">
					<div class="form-group">
						<input name="indeks" id="indeks" type="text" class="form-control" value="" placeholder="Waktu"/>
						<label>Silahkan pilih hari dan waktu lembur berdasarkan tanggal presensi</label>
						<?include 'views/form_lembur_presensi_perperiode_form_edit.php';?>
					</div>
					<hr>
					<div class="col-xs-4 form-group">
						<label for="edit_tgl_lembur">Hari/Tanggal</label>
						<input name="edit_tgl_lembur" id="edit_tgl_lembur" type="text"  class="form-control"value="" placeholder="Tanggal Lembur"/>
					</div>
					<div class="col-xs-3 form-group">
						<label for="edit_waktu">Presensi</label>
						<input name="edit_waktu" id="edit_waktu" type="text"  class="form-control"value="" placeholder="Waktu"/>
					</div>
					<div class="col-xs-3 form-group">
						<label for="edit_waktu_lembur">Lebih Jam</label>
						<input name="edit_waktu_lembur" id="edit_waktu_lembur" type="text" class="form-control"value="" placeholder="Waktu Lembur"/>
					</div>
					<div class="clearfix"></div>	
					<div class="form-group">
						<label for="edit_uraian">Uraian Pekerjaan</label>
						<input name="edit_uraian" id="edit_uraian" type="text"  class="form-control"value="" placeholder="Uraian Pekerjaan yang Dilakukan"/>
					</div>

					<input type="reset" value="clear" id="clear"/>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="edit_ok">OK</button>
			</div>
		</div>
	</div>
</div>
<div id="test"><div>
<style type="text/css">
.panel-heading {
	background: gray !important;
	color: #fff !important;
}
table tr th {
	font-size: 14px;
	text-align:center;
}
form#input-lembur>.form-group>label {
	font-size: 13px;
	text-align:center;
}
</style>

<script src="../ckeditor/ckeditor.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	function getDataPemohon()
	{
		$.ajax({
	        type: "POST",
	        url: "views/form_lembur_data_pemohon.php",
			dataType: "json",
	        success: function(data) {
				$("#nip").val(data.nip)
				$("#nama").val(data.nama)
				$("#jabatan").val(data.jabatan)
				$("#golongan").val(data.golongan)
				$("#unit_kerja").val(data.unit_kerja)
	            console.log(data)
	            //alert(data.nip+data["nip"])
	            //$(".alert-pesan").fadeOut(2300); 
	        }    
	    })
	}
	getDataPemohon()
	
	CKEDITOR.replace('deskripsi')
	
	$("#inputModal").on("show.bs.modal", function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data("whatever") // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal"s content. We"ll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		//modal.find(".modal-title").text("New message to " + recipient)
		modal.find(".modal-body input#uraian").val("")
		modal.find(".modal-body input#tgl_lembur").val("")
		modal.find(".modal-body input#waktu").val("")
		modal.find(".modal-body input#waktu_lembur").val("")
		$("#ok").prop('disabled', true)
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
		$("#jabatan").val(tds.eq(2).text())
		$("#unit_kerja").val(tds.eq(3).text())
	})
	
	$(document).on("click", "#clear", function(){
		$("#nama").focus()
		$("#kotaksugest").text("")
	})
	
	$(document).on("click", "table.table-presensi tr", function(){
		//var text = $(this).text()
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
		$("#edit_tgl_lembur").val(tanggal)
		$("#edit_waktu").val(waktu)
		$("#edit_waktu_lembur").val(waktu_lembur)
		$("#edit_data").html("")
		//alert('Tanggal: ' + tanggal + 'Mulai: ' + mulai + 'Jam Selesai: ' + selesai);
		
		//cek data double
		$(".tgl-lembur, .edit-tgl-lembur").each(function(){
			//alert($("#tgl_lembur").val())
			if($("#tgl_lembur").val() == $(this).text()){
				//alert("sudah ada data yang sama")
				$("#ok").prop('disabled', true)
				$("#edit_ok").prop('disabled', true)
			} else {
				$("#ok").prop('disabled', false)
				$("#edit_ok").prop('disabled', false)
				//$('#edit_data').hide();
			}
		})
	})

	$(document).on("click", "#ok", function(){
		//set variabel
		var tgl_lembur   = $("#tgl_lembur").val()
		var uraian   	 = $("#uraian").val()
		var waktu 	  	 = $("#waktu").val()
		var waktu_lembur = $("#waktu_lembur").val()
		var i=0
		
		//hitung lama lembur (jam)
		var jml_menit = getMenit(waktu_lembur)
		var jml_jam = getMenit(waktu_lembur) / 60
		
		//tambah record
		$("table#pelaksanaan-lembur tbody").append("<tr><td class='tgl-lembur'>"+tgl_lembur+"</td><td class='uraian'>"+uraian+"</td><td class='waktu'>"+waktu+"</td><td class='waktu-lembur' id='waktu"+i+"' >"+waktu_lembur+"</td><td class='jml-jam'>"+jml_jam+"</td><td class='remove' style='color:red'><i class='fa fa-remove' ></i></td><td class='edit' style='color:green'><i class='fa fa-edit' ></i></td></tr>")
		
		//hitung total lembur
		var total_menit = 0
		$(".waktu-lembur").each(function(){
			var time = $(this).text();
			total_menit = total_menit + getMenit(time)
			 i++
		})
		
		var jamLembur = Math.floor(total_menit / 60)
    	var menitLembur = parseInt((total_menit % (60 )) % 60);
    	var total_jam = total_menit / 60
    
		$("table#pelaksanaan-lembur tfoot tr td#total").text(jamLembur+":"+menitLembur)
		//$("table#pelaksanaan-lembur tfoot tr td#total_menit").text(total_menit)
		//$("table#pelaksanaan-lembur tfoot tr td#total_jam").text(total_jam)
		
		$(".modal").modal('hide')
	})
	
	$(document).on("click", "#edit_ok", function(){
		//set variabel
		var indeks   = $("#indeks").val()
		var tgl_lembur   = $("#edit_tgl_lembur").val()
		var uraian   	 = $("#edit_uraian").val()
		var waktu 	  	 = $("#edit_waktu").val()
		var waktu_lembur = $("#edit_waktu_lembur").val()
		var i=0
		
		//hitung lama lembur (jam)
		var jml_menit = getMenit(waktu_lembur)
		var jml_jam = getMenit(waktu_lembur) / 60
		
		//edit record
		$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(0).text(tgl_lembur)
		$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(1).text(uraian)
		$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(2).text(waktu)
		$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(3).text(waktu_lembur)
		$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(4).text(jml_jam)
		
		//hitung total lembur
		var total_menit = 0
		$(".waktu-lembur").each(function(){
			var time = $(this).text();
			total_menit = total_menit + getMenit(time)
			 i++
		})
		
		var jamLembur = Math.floor(total_menit / 60)
    	var menitLembur = parseInt((total_menit % (60 )) % 60);
    	var total_jam = total_menit / 60
    
		$("table#pelaksanaan-lembur tfoot tr td#total").text(jamLembur+":"+menitLembur)
		//$("table#pelaksanaan-lembur tfoot tr td#total_menit").text(total_menit)
		//$("table#pelaksanaan-lembur tfoot tr td#total_jam").text(total_jam)
		
		$(".modal").modal('hide')
	})
	
	$(document).on("click", ".remove", function(){
		$(this).closest('tr').remove()
		var total_menit = 0
		$(".waktu-lembur").each(function(){
			var time = $(this).text();
			total_menit = total_menit + getMenit(time)
		})
		var jamLembur = Math.floor(total_menit / 60)
		var menitLembur = parseInt((total_menit % (60 )) % 60);
		$("table#pelaksanaan-lembur tfoot tr td#total").text(jamLembur+":"+menitLembur)
	})
	
	$(document).on("click", ".edit", function(){
		var indeks = $(this).closest("tr").index()
		//alert(indeks)
		//return
		$("#editModal").modal("show")
		
		var tgl_lembur = $(this).closest("tr").find("td").eq(0).text()
		var uraian = $(this).closest("tr").find("td").eq(1).text()
		var waktu = $(this).closest("tr").find("td").eq(2).text()
		var waktu_lembur = $(this).closest("tr").find("td").eq(3).text()
		
		$("#indeks").val(indeks)
		$("#edit_tgl_lembur").val(tgl_lembur)
		$("#edit_uraian").val(uraian)
		$("#edit_waktu").val(waktu)
		$("#edit_waktu_lembur").val(waktu_lembur)
		
		//$("#edit_ok").prop('disabled', true)
		
	})
	
	$(document).on("click", "#simpan", function(){
		alert('test')
		clock.start()
		var nip = $("#nip").val()
		var nama = $("#nama").val()
		var jabatan = $("#jabatan").val()
		var golongan = $("#golongan").val()
		var unit_kerja = $("#unit_kerja").val()
		var deskripsi       = CKEDITOR.instances.deskripsi.getData()
		
		var tgl_lembur = []
		$(".tgl-lembur").each(function(){
			tgl_lembur.push($(this).text())
		})
		var uraian = []
		$(".uraian").each(function(){
			uraian.push($(this).text())
		})
		var waktu = []
		$(".waktu").each(function(){
			waktu.push($(this).text())
		})
		var waktu_lembur = []
		$(".waktu-lembur").each(function(){
			waktu_lembur.push($(this).text())
		})
		var jml_jam_lembur = []
		$(".jml-jam").each(function(){
			jml_jam_lembur.push($(this).text())
		})
		
		$.ajax({
            type: "POST",
            url: "views/form_lembur_crud.php",
            data: {
				nip:nip,
				nama:nama,
				jabatan:jabatan,
				golongan:golongan,
				unit_kerja:unit_kerja,
				tgl_lembur:tgl_lembur,
				uraian:uraian,
				waktu:waktu,
				waktu_lembur:waktu_lembur,
				jml_jam_lembur:jml_jam_lembur,
				deskripsi:deskripsi,
				crud:1
			},
            
            success: function(data) {
                console.log(data)
                //alert(data)
                $("#test").html(data); 
            },
            complete: function(data) {
                //$("#modal-form").hie("hide");    
            }           
        })
	})
	
	
	/*contoh
    $("#btnAdd").click(function () {
        var time1 = $("#txtTime1").val();
        var min1 = GetMinutes(time1.toString());

        var time2 = $("#txtTime2").val();
        var min2 = GetMinutes(time2.toString());

        var time3 = $("#txtTime3").val();
        var min3 = GetMinutes(time3.toString());

        var totalMins = parseInt(min1 + min2 + min3);

        var days = parseInt(totalMins / (60 * 24));
        var hours = parseInt((totalMins % (60 * 24)) / 60);
        var mins = parseInt((totalMins % (60 * 24)) % 60);
        alert(totalMins);
        alert(days + ":" + hours + ":" + mins);
        $("#lblShowMins").text(totalMins.toString()+" Mins");
        $("#lbkShowDetails").text(days top+ ":" + hours + ":" + mins);
    });*/
})



function hitungTotalLembur()
{
	$(".waktu-lembur").each(function(){
			var time = $(this).text();
			total_menit = total_menit + getMenit(time)
			// i++
	})
	var jamLembur = Math.floor(total_menit / 60)
	var menitLembur = parseInt((total_menit % (60 )) % 60);
	return $("table#pelaksanaan-lembur tfoot tr td#total").text(jamLembur+":"+menitLembur)
}

function getMenit(timeStr)
{   
	var totalMenit = 0
	var str = timeStr.split(':');    
    var jam =parseInt(str[0]);
    var menit = parseInt(str[1]);
    var totalMenit = jam * 60 + menit;    
    return totalMenit;
};

function totalLembur()
{
	/*
	$("#total-waktu").click(function(){
		var totalJam = 0
		$(".waktu-lembur").each(function(){
	  	var timeElements = $(this).val().split(":")
	    var jam = parseInt(timeElements[0])
	    //alert(jam)
	    totalJam += jam
	  })
	  alert(totalJam)
	})
	*/
}
</script>

<?include_once('assets/css/blink_me.php');?>