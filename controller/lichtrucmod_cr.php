<?php
require './controller/lichtrucmod_func.php';

if(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])){ //
	$ngay=$_POST['ngay'];
	$thang=substr($_POST['month'],5,2);
	$nam=substr($_POST['month'],0,4);
	//var_dump($_POST['month']);
	//$ngay_err=array();
	if($thang==1) {
		$thang_truoc=12;
		$nam_cua_thang_truoc=$nam-1;
	}else {
		$thang_truoc=$thang-1;
		$nam_cua_thang_truoc=$nam;
	}
	$so_ngay_trong_thang_truoc=cal_days_in_month(CAL_GREGORIAN,$thang_truoc,$nam_cua_thang_truoc);
	//$ngay=$_POST['ngay'];
	//echo $_POST['token'].'|'.$_SESSION['token'].'<br>tháng:'.$thang.'/'.$nam;
	//var_dump($ngay);
	$insert='ltm_thang,ltm_nam,ltm_so_ngay'; //INSERT INTO lichtrucmod (
	$insert_value=''.$thang.','.$nam.','.$so_ngay_trong_thang_truoc;
	$nguoitruc=loadNguoiTrucMod();
						
			for ($i=1; $i <=$so_ngay_trong_thang_truoc ; $i++) { 
				$val='';
				for ($j=0; $j < count($nguoitruc) ; $j++) { 
					if(strlen($ngay[$j][$i])>2) {
						if(strlen($val)>2) $val.=':';
						$val.=$ngay[$j][$i];
						$co_update=1;
					}
				}
				if(strlen($val>0)){
					$bien_sql='ltm_ngay'.$i;
					$insert.=','.$bien_sql;
					$insert_value.=',"'.$val.'"';
					//$update.=','.$bien_sql.'="'.$val.'"';
				}
			}
	$sql= 'INSERT INTO lichtrucmod ('.$insert.') VALUES ('.$insert_value.')';
	$query=mysqli_query($source,$sql);
	//var_dump($sql);
	if($query){
		nhatky('Tạo mới lịch trực MOD tháng '.$thang.'/'.$nam);
		$_SESSION['ok']='Tạo mới lịch trực MOD tháng '.$thang.'/'.$nam.' thành công';
		sendEmailLich($thang,$nam);
		header('location: ./lichtrucmod&id='.encodeThangNam($thang,$nam).'&ok=1');
	} else {
		echo 'có lỗi'.mysqli_error($source).'<br>'.$sql;
		//header('location:./lichtrucmod&ok='.urlencode('Tạo mới lịch trực MOD tháng '.$thang.'/'.$nam.' thành công'));
	}
	
} elseif(isset($_GET['id']) && ($_SESSION['token']==decodetoken($_GET['id']))){

	$dtime=decode($_GET['id']);
	$tmp=decodeThangNam($_GET['id']);
	$thang=$tmp['thang'];
	$nam=$tmp['nam'];
	
	$noidung=nhapLichTrucMoi($thang,$nam);
  	
	if ($thang<10) $thang='0'.$thang;
	$dtime=$nam.'-'.$thang;
}else{
	$noidung=nhapLichTrucMoi();
	$nam=date('Y');
	$thang=date('m');
	if ($thang<10) $thang='0'.$thang;
	$dtime=$nam.'-'.$thang;
}

$tieudechinh='Tạo mới lịch trực MOD';
$token =token();
$_SESSION['token']=$token;
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='lichtrucmod';
$arr['1']['name']='Lịch trực MOD';
$arr['1']['active']=0;
$arr['2']['stt']=2;
$arr['2']['link']='';
$arr['2']['name']=$tieudechinh;
$arr['2']['active']=1;

include './views/lichtrucmod_cr.phtml';
?>