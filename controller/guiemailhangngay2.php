<?php
require 'email2.php';

function loadNguoiTruc($id){
$test=0;
if ($test==1) {
	$danhsach=array();
	$danhsach['id']=0;
	$danhsach['name']='Nguyễn Đức Hưởng';
	$danhsach['email']='ndhuongit@gmail.com';
}else{
	$str=dirname(__FILE__);
	$arr=explode('\\', $str);
	$tmp=array_pop($arr);
	$str=implode('\\', $arr);
	require $str.'\config\config.php';
	$sql='SELECT * FROM truc_mod WHERE tm_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$danhsach['id']=$res['tm_id'];
			$danhsach['name']=$res['tm_ten'];
			$danhsach['email']=$res['tm_email'];
		}
	
	} else $danhsach['error']='có lỗi.'.msqli_error($source);
}
	return $danhsach;
}// hết loadNguoiTruc;
function loadCaTruc($id){
	//Trả về mảng chứa thông tin của ca trực có id
	// [id]= id ca trực
	// [ten]= tên ca trực
	// [kyhieu]= Ký hiệu ca trực
	// [ghichu]= ghi chú về ca trực
	if(!is_numeric($id)){
		return null;
	}
	$str=dirname(__FILE__);
	$arr=explode('\\', $str);
	$tmp=array_pop($arr);
	$str=implode('\\', $arr);
	require $str.'\config\config.php';
	$danhsach_sql='SELECT * FROM catrucmod WHERE ca_id='.$id;
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach['error']=1; // không có ca trực nào cả
		}
		else{
			$danhsach=array();
			$result = mysqli_fetch_array( $danhsach_query );
			$danhsach['id']=(int)$result['ca_id'];
			$danhsach['ten']=$result['ca_ten'];
			$danhsach['kyhieu']=$result['ca_ky_hieu'];
			$danhsach['ghichu']=$result['ca_ghi_chu'];
		}
	}else $danhsach['error']=2; // không có kết nối đc CSDL 
	return $danhsach;
} // hết loadCaTruc;
function loadLichTruc($ngay=null,$thang=null,$nam=null){
	$str=dirname(__FILE__);
	$arr=explode('\\', $str);
	$tmp=array_pop($arr);
	$str=implode('\\', $arr);
	require $str.'\config\config.php';
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	if(is_null($ngay)) $ngay=date('d');
	if($ngay>25){
		if($thang>11){
			$thang_truc=1;
			$nam_truc=$nam+1;
		} else{
			$thang_truc=$thang+1;
			$nam_truc=$nam;
		}
	}else {
		$thang_truc=$thang;
		$nam_truc=$nam;
	}
	if($thang==1) {
		$thang_truoc=12;
		$nam_cua_thang_truoc=$nam-1;
	}else {
		$thang_truoc=$thang-1;
		$nam_cua_thang_truoc=$nam;
	}
	//var_dump($ngay);
	//var_dump($thang);
	//var_dump($nam);
	$so_ngay_trong_thang_truoc=cal_days_in_month(CAL_GREGORIAN,$thang_truoc,$nam_cua_thang_truoc);
	$so_ngay_lech=$so_ngay_trong_thang_truoc-25;
	if(($ngay+$so_ngay_lech)>$so_ngay_trong_thang_truoc)	$ngaysql=$ngay+$so_ngay_lech-$so_ngay_trong_thang_truoc; else $ngaysql=$ngay+$so_ngay_lech;
	$bienngay='ltm_ngay'.$ngaysql;
	$mang=array();
	$sql='SELECT '.$bienngay.' FROM lichtrucmod WHERE (ltm_thang='.$thang_truc.') AND( ltm_nam='.$nam_truc.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if (mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$tmp=explode(':',$res[$bienngay]);
			
			for ($i=0; $i < count($tmp); $i++) { 
				$mang[$i]['ca']=loadCaTruc((int)substr($tmp[$i],2,2));	
				$mang[$i]['nt']=loadNguoiTruc((int)substr($tmp[$i],0,2));	
				$mang[$i]['all']=$tmp[$i];
				$mang[$i]['ngay']=$ngay;
				$mang[$i]['thang']=$thang;
				$mang[$i]['nam']=$nam;
			};	
			
			
		} else $mang['error']=3; 
	} else  $mang['error']=2; 
	//echo 'lich truc ngay '.$ngay.'/'.$thang.'/'.$nam.'|n';
	//var_dump($mang);
	return $mang;
} // hết loadLichTruc2
function nhatky($noidung){
    $str=dirname(__FILE__);
	$arr=explode('\\', $str);
	$tmp=array_pop($arr);
	$str=implode('\\', $arr);
	require $str.'\config\config.php';
    $nhatky_sql="INSERT INTO `nhatky`(`nk_user`, `nk_noi_dung`) VALUES ('1','$noidung')";
    $nhatky_query=mysqli_query($source,$nhatky_sql);
}// hết nhật ký


$lich=loadLichTruc();
//var_dump($lich);
$nhatky='';
foreach ($lich as $key) {
	$date='Email nhắc lịch trực MOD ngày '.$key['ngay'].'/'.$key['thang'].'/'.$key['nam'];
	$noidung['tieude']=$date.' - '.$key['ca']['ten'];
	$noidung['noidung']='<b>Dear Mr./Ms. '.$key['nt']['name'].'</b><br/> &emsp;Anh/chị có ca trực MOD ngày hôm nay( '.$key['ngay'].'/'.$key['thang'].'/'.$key['nam'].') '.$key['ca']['ten'].' - '.$key['ca']['ghichu'].'<br/> &emsp;<i>Kính thư</i>';
	$danhsach[0]=$key['nt'];
	$ketqua=sendMail($danhsach,$noidung);
	if(strlen($nhatky)>0) $nhatky.='<br>';
	$tmp=$key['ca']['ten'].'-'.$key['nt']['name'].'-'.$key['nt']['email'];
	if($ketqua['error']==0) $nhatky.='| Send OK. '.$tmp; else $nhatky.='| Send error.'.$tmp;
}
$nhatky=$date.':<br>'.$nhatky;
echo $nhatky;
nhatky($nhatky);
//var_dump($lich);
//var_dump($catruc);
//var_dump($nguoitruc);
//sendMail($danhsach,$noidung);

?>