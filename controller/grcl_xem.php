<?php
require './controller/grcl_xem_func.php';

$tieudechinh = 'Xem nội dung Kiểm tra phòng khách theo tháng';
$token =token();
$_SESSION['token']=$token;
if( isset($_GET['id']) ){
	$date=date_create();
	date_timestamp_set($date,$_GET['id']);
	$ngay=date_format($date,"d-m-Y");
	$ngaytruc=date_format($date,"Y-m-d");
	//echo 'ngày trực:'.$ngaytruc;
    date_sub($date, date_interval_create_from_date_string('1 days'));
    $backday='index.php?ylan=grcl_xem&id='.strtotime(date_format($date,'Y-m-d'));
    date_add($date, date_interval_create_from_date_string('2 days'));
    $nextday='index.php?ylan=grcl_xem&id='.strtotime(date_format($date,'Y-m-d'));
    
    $select_ca=loadCaTruc($ngaytruc);
	//var_dump($select_ca);
	if(isset($select_ca['error'])) $ca=''; else $ca=$select_ca['noidung'];
	//var_dump($ca);
	$top='<a class="btn btn-secondary" href="'.$backday.'" data-toggle="tooltip" title=" Lùi lại 1 ngày." ><i class="fa fa-backward" aria-hidden="true"></i></a>
        &emsp;
        <input type="date" name="ngay" id="ngay" class="txt" value="'.$ngaytruc.'" readonly> '.$ca.' &emsp;
        <a class="btn btn-secondary" href="'.$nextday.'" data-toggle="tooltip" title=" Tiến tới 1 ngày."><i class="fa fa-forward" aria-hidden="true"></i></a>'; 
	// end top
	if(isset($_GET['c'])) $catruc=$_GET['c']; 
	elseif(!isset($select_ca['error'])) $catruc=$select_ca['defaul'];
	else $catruc=3;// 3 = ca B1	
	$noidung=showLichTruc($ngaytruc,$catruc);
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
}


	
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/grcl_xem.phtml';
?>