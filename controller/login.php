<?php
if ( isset($_SESSION['user_id'])){
	check_time();
	header('location: ./main6');
} else {
	if(isset($_REQUEST['t'])) $error='Quá thời gian đăng nhập. Hãy đăng nhập lại';
	if(isset($_REQUEST['q'])) $success='Đăng xuất hệ thống thành công<br> Xin chào và hẹn gặp lại.';
	if(isset($_REQUEST['p'])) $success='Thay đổi mật khẩu thành công.';
	if(isset($_REQUEST['t2'])) $error='He he, Đăng nhập trước đã nhé.';
	if(isset($_REQUEST['err'])) $error=$_REQUEST['err'];
	if(isset($_REQUEST['phonglam'])) $phonglam=$_REQUEST['phonglam'];
	$token =token();
	$_SESSION['token']=$token;
	include_once './views/login.phtml';
}


?>