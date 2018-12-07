<?php
//$connect = mysqli_connect("localhost", "remun", "usbw", "remun");
include("../models/conn.php");
 
if( isset($_POST["crud"]) ) $crud = $_POST["crud"];
if( isset($_POST["id"]) ) $id = $_POST["id"];
if( isset($_POST["column_name"]) ) $column_name = $_POST["column_name"];
if( isset($_POST["text"]) ) $text = $_POST["text"];
if( isset($_POST["tgl_upload"]) ) $tgl_upload = $_POST["tgl_upload"];
if( isset($_POST["file_kode"]) ) $file_kode = $_POST["file_kode"];
if( isset($_POST["file_name"]) ) $file_name = $_POST["file_name"];
if( isset($_POST["tgl_revisi"]) ) $tgl_revisi = $_POST["tgl_revisi"];

switch($_POST["crud"]){
	case 'select':
		select();
		break;
	case 'insert':
		insert($tgl_upload, $file_kode, $file_name, $tgl_revisi);
		break;
	case 'edit':
		edit($id, $column_name, $text);
		break;
	case 'delete':
		delete($id);
		break;
}

function select(){
	$output = '';
	$sql = "SELECT * FROM file_ijk WHERE file_dok = 1 ORDER BY file_kode ASC";
	$result = mysql_query($sql);  

	$output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">Id</th>  
                     <th width="40%">Kode File</th>  
                     <th width="40%">Nama File</th>  
                     <th width="10%">Tgl Revisi</th>
                     <th width="10%">Delete</th>
                </tr>';  
	if(mysql_num_rows($result) > 0)  
	{  
		while($row = mysql_fetch_array($result))  
		{  
           $output .= '  
                <tr data-id="'.$row["id"].'">  
                     <td>'.$row["id"].'</td>  
                     <td data-kolom="file_kode"> <input type="text" class="file_kode" data-id1="'.$row["id"].'" value="'.$row["file_kode"].'" ></td>  
                     <td data-kolom="file_name"> <input type="text" class="file_name" data-id2="'.$row["id"].'" value="'.$row["file_name"].'"  ></td>
                     <td data-kolom="tgl_revisi"> <input type="text" class="tgl_revisi" data-id3="'.$row["id"].'" data-provide="datepicker" value="'. format_tanggal($row["tgl_revisi"]) .'" style="border:none"> </td>
                     <td><button type="button" name="delete_btn" data-id4="'.$row["id"].'" class="btn btn-xs btn-danger btn_delete">x</button></td>                     
                </tr>  
           ';  
		}  
      $output .= '  
           <tr>  
                <td></td>  
                <td id="file_kode" contenteditable></td>  
                <td id="file_name" contenteditable></td>
                <td><input type="text" id="tgl_revisi" class="test" data-provide="datepicker" ></td>
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
           </tr>  
      ';  
	}  
	else  
	{  
      $output .= '<tr>  
                     <td colspan="4">Data not Found</td>  
                  </tr>';  
	}  
	$output .= '</table>  
      </div>';  
	echo $output;
}

function insert($tgl_upload, $file_kode, $file_name, $tgl_revisi){
	$sql = "INSERT INTO file_ijk(tgl_upload, file_kode, file_name, tgl_revisi, file_dok)
	VALUES('$tgl_upload', '$file_kode', '$file_name', '$tgl_revisi', '1')";  
	if(mysql_query($sql))
	{  
		echo 'Data Inserted';  
	}
}

function edit($id, $column_name, $text){
	//manipulasi inputan tanggal
	if ( $column_name == 'tgl_revisi') {
		$array_bulan = array(
		'Januari' => '01',
		'Februari' => '02',
		'Maret' => '03',
		'April' => '04',
		'Mei' => '05',
		'Juni' => '06',
		'Juli' => '07',
		'Agustus' => '08',
		'September' => '09',
		'Oktober' => '10',
		'November' => '11',
	    'Desember' => '12'
		);
	$array = explode(" ", $text);
	$text = $array[2].'-'.$array_bulan[$array[1]].'-'.$array[0];
	}

	$sql = "UPDATE file_ijk SET $column_name = '$text' WHERE id = '$id'";  
	if(mysql_query($sql))  
	{  
		echo 'Data Updated';  
	} 
}

function delete($id){
	$sql = "DELETE FROM file_ijk WHERE id = '$id'";  
	if(mysql_query($sql))  
	{  
		echo 'Data Deleted';  
	}
}


function format_tanggal($tanggal){
  $array_bulan = array(
       '01' => 'Januari',
       '02' => 'Februari',
       '03' => 'Maret',
       '04' => 'April',
       '05' => 'Mei',
       '06' => 'Juni',
       '07' => 'Juli',
       '08' => 'Agustus',
       '09' => 'September',
       '10' => 'Oktober',
       '11' => 'November',
       '12' => 'Desember'
  );
  $array = explode("-", $tanggal);
  $hasil = $array[2].' '. $array_bulan[$array[1]].' '.$array[0];
  return $hasil;
}
?>