<?php
require './controller/lichtrucmod_func.php';
if(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$dtime=$_POST['dtime'];
	$tmp=decodeThangNam($_POST['dtime']);	
	$thang=$tmp['thang'];
	$nam=$tmp['nam'];
	$newid=$_SESSION['ltm_id'];
	$ngay1=$_POST['ngay1'];
	$ngay2=$_POST['ngay2'];
	$giatringay1=$_POST['giatringay1'];
	$giatringay2=$_POST['giatringay2'];
	$old_ngay_sql1=$_SESSION['giatringay1'];
	$old_ngay_sql2=$_SESSION['giatringay2'];
	$t11=substr($giatringay1,0,2);
	$t12=substr($giatringay1,2,2);
	$t21=substr($giatringay2,0,2);
	$t22=substr($giatringay2,2,2);
	$nguoitruc1=hoTenNguoiTruc((int)$t11);
	$nguoitruc2=hoTenNguoiTruc((int)$t21);
	$catruc1=tenCaTruc((int)$t12);
	$catruc2=tenCaTruc((int)$t22);
	if($thang==1) {
		$thang_truoc=12;
		$nam_cua_thang_truoc=$nam-1;
	}else {
		$thang_truoc=$thang-1;
		$nam_cua_thang_truoc=$nam;
	}
	$so_ngay_trong_thang_truoc=cal_days_in_month(CAL_GREGORIAN,$thang_truoc,$nam_cua_thang_truoc);
	$so_ngay_lech=$so_ngay_trong_thang_truoc-25;// vì tính ngày 26 là ngày bắt đầu của tháng mới
	if(($ngay1+25)<=$so_ngay_trong_thang_truoc) $ngaytruc1=' ngày '.($ngay1+25).'/'.$thang_truoc;  else 	$ngaytruc1=' ngày '.($ngay1-($so_ngay_trong_thang_truoc-25)).'/'.$thang;
	if(($ngay2+25)<=$so_ngay_trong_thang_truoc) $ngaytruc2=' ngày '.($ngay2+25).'/'.$thang_truoc;  else 	$ngaytruc2=' ngày '.($ngay2-($so_ngay_trong_thang_truoc-25)).'/'.$thang;
	$nhatky='Đổi ca trực MOD giữa 2 ngày: '.$ngaytruc1.'-'.$catruc1.'-'.$nguoitruc1.' và '.$ngaytruc2.'-'.$catruc2.'-'.$nguoitruc2;
	$ngaymoi1=$t21.$t12;
	$ngaymoi2=$t11.$t22;
	$ngaysqlmoi1='';
	for ($i=0; $i < count($old_ngay_sql1) ; $i++) { 
		if($old_ngay_sql1[$i]==$giatringay1) {
			if (strlen($ngaysqlmoi1)>2) $ngaysqlmoi1.=':'.$ngaymoi1;
			else $ngaysqlmoi1.=$ngaymoi1;
		} else {
			if (strlen($ngaysqlmoi1)>2) $ngaysqlmoi1.=':'.$old_ngay_sql1[$i];
			else $ngaysqlmoi1.=$old_ngay_sql1[$i];
		}
	}
	$ngaysqlmoi2='';
	for ($i=0; $i < count($old_ngay_sql2) ; $i++) { 
		if($old_ngay_sql2[$i]==$giatringay2) {
			if (strlen($ngaysqlmoi2)>2) $ngaysqlmoi2.=':'.$ngaymoi2;
			else $ngaysqlmoi2.=$ngaymoi2;
		} else {
			if (strlen($ngaysqlmoi2)>2) $ngaysqlmoi2.=':'.$old_ngay_sql2[$i];
			else $ngaysqlmoi2.=$old_ngay_sql2[$i];
		}
	}
	
	$bien_sql1='ltm_ngay'.$ngay1;
	$bien_sql2='ltm_ngay'.$ngay2;
	$sql='SELECT ltm_version FROM lichtrucmod WHERE ltm_id='.$newid;
	$query=mysqli_query($source,$sql);
	$update=$bien_sql1.'="'.$ngaysqlmoi1.'", '.$bien_sql2.'="'.$ngaysqlmoi2.'"';
	if($query){
		$res=mysqli_fetch_array($query);
		$version=$res['ltm_version']+1;
		$update.=',ltm_version='.$version;
	}
	$sql='UPDATE lichtrucmod SET '.$update.' WHERE ltm_id='.$newid;
	$query=mysqli_query($source,$sql);
	if($query){
		nhatky($nhatky);
		$_SESSION['ok']=$nhatky.' thành công';
		$_SESSION['update']=$nhatky;
		sendEmailLich($thang,$nam);
		header('location: ./lichtrucmod&id='.encodeThangNam($thang,$nam).'&ok=1');
	} else {
		$_SESSION['error']='Có lỗi.'.mysqli_error($source);
		header('location: ./lichtrucmod&id='.encodeThangNam($thang,$nam).'&err=1');
	}
	
}elseif(isset($_GET['id']) ){ //&&($_SESSION['token']==decodetoken($_GET['id']))
	$dtime=$_GET['id'];
	$tmp=decodeThangNam($_GET['id']);
	$thang=$tmp['thang'];
	$nam=$tmp['nam'];
	$_SESSION['thang']=$thang;
	$_SESSION['nam']=$nam;
	$sql='SELECT ltm_id,ltm_so_ngay FROM lichtrucmod WHERE (ltm_thang='.$thang.') AND( ltm_nam<='.$nam.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$_SESSION['ltm_id']=$res['ltm_id'];
			$so_ngay=$res['ltm_so_ngay'];

		}else{
			header('location: ./main6');
		}
	}else{
		header('location: ./main6');
	}
	$ngay1=chonNgay('ngay1',$so_ngay);
	$ngay2=chonNgay('ngay2',$so_ngay);
	//var_dump($ngay);
	//$hangngay=lichTruc($ngay,$thang,$nam);
	if(isset($_GET['err'])) $error="<br><div class='alert alert-danger text-center'>".urldecode($_GET['err'])." </div>" ;
	$tieudechinh='Đổi lịch trực 2 ngày trong tháng '.$thang.' năm '.$nam;
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
	include './views/lichtrucmod_change.phtml';	
} else header('./main6');
?>