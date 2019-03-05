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
				        <label>Golongan</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="golongan" id="golongan"/>
				    </div>

				    <div class="clearfix"></div>

				    <div class="col-xs-2 form-group">
				        <label>NPM/NIP/NUP</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="nip" id="nip"/>
				    </div>
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
			 		<th>Jam Lembur</th>
					<th>Keterangan</th>
					<th colspan="2"></th>
			 	</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2">
							<div class="div-table">
								<div class="div-table-row">
									<div class="div-table-col">Total Jam Lembur Hari Kerja</div>
									<div class="div-table-col">=</div>
									<div class="div-table-col" id="total_jam_hari_kerja"></div>
								</div>
								<div class="div-table-row">
									<div class="div-table-col">Total Jam Lembur Hari Libur</div>
									<div class="div-table-col">=</div>
									<div class="div-table-col" id="total_jam_hari_libur"></div>
								</div>
							</div>
						</td>
						<td></td>
						<td id="total"></td>
						<td id="total_honor"></td>
						<td colspan="2"></td>
			 	</tr>
				</tfoot>
			</table>
			<div class="container">
				<div class="row">
					<div class="col-xs-2 pull-right">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#inputModal" id="tambah"><b>tambah</b></button>
					</div>
				</div>				
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

<div class="container">
	<div class="row">
		<div class="col-xs-2 pull-right">
			<button type="button" class="btn btn-primary" id="simpan"> simpan </button>
		</div>
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
						<label for="edit_waktu_lembur">Jam Lembur</label>
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
<div class="container" id="test"></div>
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
.div-table {
  display: table;         
  width: auto;         
  background-color: #eee;         
  border: 1px solid #fa0;         
  border-spacing: 5px; /* cellspacing:poor IE support for  this */
}
.div-table-row {
  display: table-row;
  width: auto;
  clear: both;
}
.div-table-col {
  float: left; /* fix for  buggy browsers */
  display: table-column;         
  /*width: 200px;     */    
  background-color: #eee;  
}
</style>

<?php
include_once('assets/css/blink_me.php');
include_once('form_lembur_input_script.php');
?>