<?php
//echo 'test';
//$id_file = $_POST['id_file'];
$id_file = 'testing';
/*
if(!empty($_FILES)) {
  $dir_base = "../dokumen/";
  //filter extentions
  $fileExt = explode('.', $_FILES['file_upload']['name']);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
							'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
							'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
							'application/msword',
							'application/proses',
							'application/download',
							'application/pdf',
							'doc', 'docx');
  if (in_array($fileActualExt, $allowed)) {
    if(is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
      if(move_uploaded_file($_FILES['file_upload']['tmp_name'],$dir_base.$_FILES['file_upload']['name'])) {
        // return path
        echo '<img src="'.$dir_base.$_FILES['file_upload']['name'].'" width="100%"  />';
      }
    }
  }else {
    echo '<span style="color:red">You cannot upload files of this type!</span>';
  }
}
*/

if(!empty($_FILES)) {
  $dir_base = "../dokumen/";
  //filter extentions
  $fileExt = explode('.', $_FILES['file_upload']['name']); //ada perbedaan antara type dan ext file
  $file_ext = $fileExt[1];
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
							'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
							'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
							'application/msword',
							'application/proses',
							'application/download',
							'application/pdf',
							'doc', 'docx');
  if (in_array($fileActualExt, $allowed)) {
    if(is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
    	
    	$lokasi_file = '../dokumen/'.$id_file.'.'.$file_ext;
    
    	//proses jika ukuran file kurang dari 1 mega
    	if($_FILES['file_upload']['size'] < 1044070){
    		//hapus file di database yang sebelumnya sudah di upload
			/*$result = mysql_query("SELECT file_type from file_ijk WHERE id_file = $id_file") or die('x: '.mysql_error());
			while ($row = mysql_fetch_object($result)){
				$file_type_hapus = $row->file_type;
			}
			
			$file_hapus = '../dokumen/'.$id_file.'.'.$file_type_hapus;
			if(file_exists($file_hapus)){unlink($file_hapus);}*/
			
			//upload file dan update database
			if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $lokasi_file)) {
				// return path
        		//echo '<img src="'.$dir_base.$_FILES['file_upload']['name'].'" width="100%"  />';
        		/*
        		$in = mysql_query("UPDATE file_ijk SET tgl_upload = '$tgl_upload', file_type = '$file_ext', file_size = '$file_size' WHERE id_file = $id_file") or die('y: '.mysql_error());
        
				if($in){
					echo '<div class="ok">SUCCESS: File berhasil di Upload!</div>';				
				}
				*/
			} else {
					echo '<div class="error">ERROR: Gagal upload file! - '.$lokasi_file.'</div>';
			} //end of move_uploaded_file
			
    	} //end of $_FILES

    } // end of is_uploaded_file
    
  } else {
    echo '<span style="color:red">You cannot upload files of this type!</span>';
  } //end of in_array
  
} //end of empty $_FILES

?>
<pre><?php print_r($_FILES['file_upload']);?></pre>