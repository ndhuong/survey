<?php
require './controller/lichtrucmod_func.php';
//$mang=khoiTao();
//var_dump($mang);
if(isset($_GET['id'])){
	$dtime=decodeThangNam($_GET['id']);
	//var_dump($dtime);
	$lich=loadLichTrucThang($dtime['thang'],$dtime['nam']);
	if(isset($lich['error'])) $lich=$lich['status'];
	if($dtime['thang']<10 ) $dtime['thang']='0'.$dtime['thang'];
	$dtime=$dtime['nam'].'-'.$dtime['thang'];
} else {
	$lich=loadLichTrucThang();
	if(isset($lich['error'])) $lich=$lich['status'];

}
if(isset($_GET['email'])) {
	if($_GET['email']==1){
		sendEmailLich($_GET['id']);
	}elseif($_GET['email']==2){
		sendEmailLich($_GET['id'],'Cập nhật mới toàn bộ lịch trực.');
	}elseif($_GET['email']==3){
		sendEmailLich($_GET['id'],$_GET['email3']);
	}
}
if(kiemTraQuyen()) $quyen='<a class="btn btn-secondary" href="./lichtrucmod_cr"> Tạo mới </a>'; else $quyen='';
if(isset($error)) $error="<br><div class='alert alert-danger text-center'>".$error." </div>" ;
if(isset($_GET['ok']))	$status="<br><div class='alert alert-success text-center'>".$_SESSION['ok']." </div>" ;
if(isset($_GET['err']))	$status="<br><div class='alert alert-danger text-center'>".$_SESSION['error']." </div>" ;

$arr=array();
$tieudechinh='Lịch trực MOD';
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/lichtrucmod.phtml';

?>