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
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=1;

include './views/main6.phtml';

?>