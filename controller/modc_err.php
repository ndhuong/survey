<?php
if(isset($_GET['ngay'])){
	include './controller/mod_func.php';
	$ngay=$_GET['ngay'];
	$ca_id=$_GET['ca'];
	echo $ngay;
	$ngay=date_format(date_create($ngay),'Y-m-d');
	$ngaydmy=date_format(date_create($ngay),'d-m-Y');
	$noidung='Có lỗi. '.tenCaTruc($ca_id).' ngày '.$ngaydmy.' đã có dữ liệu.'; 
	$noidung='<div class="alert alert-danger text-center">'.$noidung.' </div>' ;

	$arr=array();
	$tieudechinh='Bảng liệt kê các mục cần kiểm tra';
	$arr['0']['stt']=0;
	$arr['0']['link']='main6';
	$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
	$arr['0']['active']=0;
	$arr['1']['stt']=1;
	$arr['1']['link']='';
	$arr['1']['name']=$tieudechinh;
	$arr['1']['active']=1;
	include './views/modc_err.phtml';
} else header('location: ./main6');


?>