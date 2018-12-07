<?php
if($_SESSION['role_id']=='1'){
	include ("form_admin.php");
} else {
	include ("form_user_test.php");
}
?>