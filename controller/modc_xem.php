<?php
$tieudechinh = 'Xem nội dung MOD Checklist theo ngày';

$token =token();
$_SESSION['token']=$token;
if( isset($_GET['id']) ){
	$date=date_create();
	date_timestamp_set($date,$_GET['id']);
	//$ngay=date_format($date,"d-m-Y");
	$ngaytruc=date_format($date,"Y-m-d");
    date_sub($date, date_interval_create_from_date_string('1 days'));
    $backday='./modc_xem&id='.strtotime(date_format($date,'Y-m-d'));
    date_add($date, date_interval_create_from_date_string('2 days'));

    $nextday='./modc_xem&id='.strtotime(date_format($date,'Y-m-d'));
    require './controller/modc_xem_func.php';
    require './controller/modc_data.php';
    for ($i=0; $i < count($mod_c) ; $i++) { 
		if($mod_c[$i]['type']==0) $mod_c[$i]['ghichu']=$mod_c[$i]['bien'].'_txt';			
	}
	//top 
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
	$tmp=loadData($ngaytruc,$catruc);
	if($tmp['error']==0){
		$noidung=hienThi($mod_c);	
		$noidung.='<br><br><div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-6  text-center ">
                <br>
                 <a class="submitbutton" href="index.php?ylan=modc&sua='.encode($tmp['id']).'" > Sửa phiếu </a> 
                 <p></p>
            </div>
        </div><br>';
	} else {
		$noidung=$tmp['status'];
	}
	
		
	
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
}
$tieudechinh = 'Xem nội dung MOD Checklist theo ngày';

	
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/modc_xem.phtml';
?>