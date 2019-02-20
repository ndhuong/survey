<?php
require './controller/kscl_func.php';
$token =token();
$_SESSION['token']=$token;
if(isset($_GET['type'])){
	switch ($_GET['type']) {
	case '1':
		$noidung=danhSach(1);
		break;
	case '2':
		$noidung=danhSach(2);
		break;
	default:
		$noidung=danhSach();
		break;
	}
}
else {
	$noidung=danhSach();
}

$tieudechinh="Kiểm soát chất lượng";
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status="Tạo mới phiếu kiểm soát chất lượng thành công";
	elseif($_GET['ok']==2) $status="Cập nhật phiếu kiểm soát chất lượng thành công";
}
if(isset($error)) $error="<br><div class='alert alert-danger text-center'>".$error." </div>" ;
if(isset($status))	$status="<br><div class='alert alert-success text-center'>".$status." </div>" ;

$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;

include './views/kscl.phtml';
?>