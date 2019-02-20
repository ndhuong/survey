<?php
//require './controller/lichtrucmod_func.php';
require './controller/modc_data.php';
require './controller/mod_func.php';
if(isset($_POST['submit'])){
	if(strlen($_POST['text'])<1) $text=' không có nội dung';
	else{
		//$text=$_POST['text'];
		//$hangngay=decodeThangNam($text);
		header('location:./phieu2018');
	}
}

$arr=array();
$hangngay='kiểm tra ngày trực '.kiemTraNgayTruc('2018-11-10','0');
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']='Tieu de';
$arr['1']['active']=1;

include './views/test.phtml';
?>