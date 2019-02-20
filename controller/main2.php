<?php

//echo 'IP:'.get_user_ip();

if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status=' Cập nhật thông tin thành công';
}
if(isset($error)){
		$error="<br><div class='alert alert-danger text-center'>".$error." </div>" ;
	}
	if(isset($status)){
		$status="<br><div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/main2.phtml';

?>