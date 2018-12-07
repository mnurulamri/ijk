<h3 align="center">FORMULIR SDM</h3><br />  
<?php
include "../models/conn.php";
$sql = "SELECT * FROM file_ijk WHERE file_dok = 1";
$result = mysql_query($sql) or die( mysql_error() );
while( $row = mysql_fetch_object($result) ){
	$data[] = $row;
}
$i=1;
$html = '
<table class="table">
	<th> No </th>
	<th> Nomor Formulir </th>
	<th> Nama Formulir </th>
	<th> Aksi </th>
';
foreach($data as $k => $v){
	$nama_file = $v->file_kode.'.'.$v->file_ext;
	$html.= '
	<tr>
		<td>'. $i .'</td>
		<td>'. $v->file_kode .'</td>
		<td>'. $v->file_name .'</td>
		<td>
			<a data-formulir="dokumen/'.$nama_file.'" data-toggle="modal" data-target="#myModal" class="view btn btn-warning btn-sm"> lihat </a>
		</td>
		<td> <a href="dokumen/'.$nama_file.'" class="btn btn-success btn-sm"> download </a> </td>
	</tr>';
	$i++;
}
$html .= '</table>';
echo $html;
?>
<!-- Modal View -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<script>
$(".view").click(function(){
	var formulir = $(this).data("formulir")
	var link = '<iframe src="https://docs.google.com/gview?url=https://remun.ppaa.fisip.ui.ac.id/ijk/' + formulir + '&embedded=true" frameborder="0"></iframe>'
	$(".embed-responsive").html(link)
})

</script>

<style>
.embed-responsive-10by1 {
   padding-top: 100%;
}
.view{
	cursor:pointer;
}
</style>
