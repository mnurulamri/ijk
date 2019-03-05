
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
		$("#golongan").val(tds.eq(2).text())
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
		var golongan 	 = $("#golongan").val()
		var i=0
		
		//hitung lama lembur (jam)
		var jml_menit = getMenit(waktu_lembur)
		var jml_jam = getMenit(waktu_lembur) / 60
		var honor_lembur = jml_jam * 0

		$.ajax({
            type: "POST",
            url: "views/form_lembur_get_hs.php",
            dataType: "json",
            data: {
            	tgl_lembur:tgl_lembur,
            	golongan:golongan,
				jml_menit:jml_menit
			},            
            success: function(data) {
                console.log(data)
				//tambah record
				$("table#pelaksanaan-lembur tbody").append("<tr><td class='tgl-lembur'>"+tgl_lembur+"</td><td class='uraian'>"+uraian+"</td><td class='waktu'>"+waktu+"</td><td class='waktu-lembur' id='waktu"+i+"' >"+waktu_lembur+"</td><td class='keterangan'></td><td class='remove' style='color:red'><i class='fa fa-remove' ></i></td><td class='edit' style='color:green'><i class='fa fa-edit' ></i></td></tr>")
            }           
        })
		
		$(".modal").modal('hide')
	})
	
	$('.modal').on('hidden.bs.modal', function () {
		hitungTotalLembur()
	})
	
	$(document).on("click", "#edit_ok", function(){
		//set variabel
		var indeks   = $("#indeks").val()
		var tgl_lembur   = $("#edit_tgl_lembur").val()
		var uraian   	 = $("#edit_uraian").val()
		var waktu 	  	 = $("#edit_waktu").val()
		var waktu_lembur = $("#edit_waktu_lembur").val()
		var golongan 	 = $("#golongan").val()
		var i=0
		
		//hitung lama lembur (jam)
		var jml_menit = getMenit(waktu_lembur)
		var jml_jam = getMenit(waktu_lembur) / 60
		
		$.ajax({
            type: "POST",
            url: "views/form_lembur_get_hs.php",
            data: {
            	tgl_lembur:tgl_lembur,
            	golongan:golongan,
				jml_menit:jml_menit
			},            
            success: function(data) {
                console.log(data)
				//edit record
				$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(0).text(tgl_lembur)
				$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(1).text(uraian)
				$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(2).text(waktu)
				$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(3).text(waktu_lembur)
				$("table#pelaksanaan-lembur tbody").find("tr").eq(indeks).find("td").eq(4).text(data.text)
            }           
        })
		
		$(".modal").modal('hide')
	})
	
	$(document).on("click", ".remove", function(){
		$(this).closest('tr').remove()
		hitungTotalLembur()
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
                alert(data)
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
	//hitung total lembur
	var total_menit = 0
	var total_menit_hari_kerja = 0
	var total_menit_hari_libur = 0
	var total_honor = 0
	var j = 0
	$(".waktu-lembur").each(function(){
		
		var tgl = $(this).closest('tr').children('td.tgl-lembur').text();
		var nama_hari = tgl.split(",")[0]
		
		if(nama_hari=="Sabtu" || nama_hari=="Minggu"){
			total_menit_hari_libur += getMenit($(this).text())
		} else {
			total_menit_hari_kerja += getMenit($(this).text())
		}

		/*honor lembur dinonaktifkan
		var honor = $(this).closest('tr').children('td.honor-lembur').text();
		honor = honor.replace(",","")
		total_honor += parseInt(honor)
		$(".totalSum").text('$' + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString())*/
	})

	var jam_lembur_hari_kerja = Math.floor(total_menit_hari_kerja / 60)
	var menit_lembur_hari_kerja = parseInt((total_menit_hari_kerja % (60 )) % 60);
	var total_jam_hari_kerja = total_menit_hari_kerja / 60

	var jam_lembur_hari_libur = Math.floor(total_menit_hari_libur / 60)
	var menit_lembur_hari_libur = parseInt((total_menit_hari_libur % (60 )) % 60);
	var total_jam_hari_libur = total_menit_hari_libur / 60

	$("#total_jam_hari_kerja").text(jam_lembur_hari_kerja+":"+menit_lembur_hari_kerja)
	$("#total_jam_hari_libur").text(jam_lembur_hari_libur+":"+menit_lembur_hari_libur)
	
	//$("#total_honor").text('' + parseFloat(total_honor, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString())
	/* total dinonaktifkan
	$("#total_honor").text( total_honor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )  */
	
	total_menit = total_menit_hari_libur + total_menit_hari_kerja
	/*if(total_menit>=3000){
		alert("Pengajuan lembur sudah melampaui 50 jam")
		$("#tambah").prop('disabled', true)
	} else {
		$("#tambah").prop('disabled', false)
	}*/

	if(total_menit_hari_libur>=1500 || total_menit_hari_kerja >=1500){
		alert("Pengajuan lembur sudah lebih dari 25 jam")
		//$("#tambah").prop('disabled', true)
	} else {
		$("#tambah").prop('disabled', false)
	}
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

function namaHari(v_tgl)
{
    var array_hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var array_tgl = v_tgl.split('/');
    var tgl = v_tgl;
    var tanggal = new Date(tgl);
    var d = array_tgl[1];
    var kd_hari = tanggal.getDay();
    var hari = array_hari[kd_hari];
    return hari;
}

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