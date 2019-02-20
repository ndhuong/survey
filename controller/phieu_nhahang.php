<?php
include './controller/phieumoi_func.php';
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	$res=mysqli_fetch_array($query);
	$sql='DELETE FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		nhatky('xóa phiếu khảo sát số: '.$res['ks_so_phieu'].'- Ngày khảo sát: '.$res['ks_ngay_khao_sat']);
			header('location: index.php?ylan=xemphieu&bophan=1&ok=3');
	}
	else{
		header('location: index.php?ylan=xemphieu&bophan=1&err=1');	
	}

}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$tieudechinh='Phiếu khảo sát khách hàng - nhà hàng';
	$token =token();
	$_SESSION['token']=$token;
	$tieude_submit = 'cập nhật phiếu';
	$id=decode($_GET['sua']);
	$sql= 'SELECT * FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$res = mysqli_fetch_array( $query );
		// load nội dung mẫu
		//$mau=noiDungMau();
		$sophieu=$res['ks_so_phieu'];
		$ngay_khao_sat=$res['ks_ngay_khao_sat'];
		$rest_chung=$res['ks_rest_chung'];
		$rest_dich_vu=$res['ks_rest_dich_vu'];
		$rest_do_an=$res['ks_rest_do_an'];
		$rest_do_uong=$res['ks_rest_do_uong'];
		$rest_trang_tri=$res['ks_rest_trang_tri'];
		$how_an_uong=$res['ks_how_an_uong'];
		$goBack='<input type="button" value="<= Quay lại trang trước" onclick="history.back(-1)" />';
	}

}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])){
	$t1='';
	$t2='';
	$t3='';
	if(isset($_POST['phieuexist'])){
		if(strlen($_POST['phieuexist'])>2) $phieuexist=decode($_POST['phieuexist']);
		else $phieuexist=$_POST['phieuexist'];
		if($phieuexist>0){
				$sophieu=$_POST['sophieu'];
				$t1='';
				$t2='';
				$t3='';
			}
			else{
				$sophieu=$_POST['sophieu'];
				$t1='ks_so_phieu,';
				$t2=$sophieu.',';
				$t3='ks_so_phieu='.$sophieu.',';
			}
	}
	
	$t1=$t1.'ks_nha_hang,';
	$t2=$t2.'1,';
	$t3=$t3.'ks_nha_hang=1,';
	$ngay_khao_sat=$_POST['ngay_khao_sat'];
		$t1=$t1.'ks_ngay_khao_sat,';
		$t2=$t2.'"'.$ngay_khao_sat.'",';
		$t3=$t3.'ks_ngay_khao_sat='.'"'.$ngay_khao_sat.'",';
	if(!empty($_POST['rest_chung'])){
		$rest_chung=$_POST['rest_chung'];
		$t1=$t1.'ks_rest_chung,';
		$t2=$t2.$rest_chung.',';
		$t3=$t3.'ks_rest_chung='.$rest_chung.',';
	}
	if(!empty($_POST['rest_dich_vu'])){
		$rest_dich_vu=$_POST['rest_dich_vu'];
		$t1=$t1.'ks_rest_dich_vu,';
		$t2=$t2.$rest_dich_vu.',';
		$t3=$t3.'ks_rest_dich_vu='.$rest_dich_vu.',';
	}
	if(!empty($_POST['rest_do_an'])){
		$rest_do_an=$_POST['rest_do_an'];
		$t1=$t1.'ks_rest_do_an,';
		$t2=$t2.$rest_do_an.',';
		$t3=$t3.'ks_rest_do_an='.$rest_do_an.',';
	}
	if(!empty($_POST['rest_do_uong'])){
		$rest_do_uong=$_POST['rest_do_uong'];
		$t1=$t1.'ks_rest_do_uong,';
		$t2=$t2.$rest_do_uong.',';
		$t3=$t3.'ks_rest_do_uong='.$rest_do_uong.',';
	}
	if(!empty($_POST['rest_trang_tri'])){
		$rest_trang_tri=$_POST['rest_trang_tri'];
		$t1=$t1.'ks_rest_trang_tri,';
		$t2=$t2.$rest_trang_tri.',';
		$t3=$t3.'ks_rest_trang_tri='.$rest_trang_tri.',';
	}
	if(strlen($_POST['how_an_uong'])>1){
		$how_an_uong=$_POST['how_an_uong'];
		$t1=$t1.'ks_how_an_uong,';
		$t2=$t2.'"'.$how_an_uong.'",';
		$t3=$t3.'ks_how_an_uong='.'"'.$how_an_uong.'",';
	}
	if(substr($t1, strlen($t1)-1,1)==',') $t1=substr($t1,0,strlen($t1)-1);
	if(substr($t2, strlen($t2)-1,1)==',') $t2=substr($t2,0,strlen($t2)-1);
	if(substr($t3, strlen($t3)-1,1)==',') $t3=substr($t3,0,strlen($t3)-1);
	echo 't1='.$t1.'<br> t2='.$t2.'<br>t3='.$t3;
	if( (isset($_POST['phieuok'])&&($_POST['phieuok']>0)) || ((isset($_POST['suaphieu'])) && (decodetoken($_POST['suaphieu'])==$_SESSION['token']) ) ){
		if((isset($_POST['suaphieu'])) && (decodetoken($_POST['suaphieu'])==$_SESSION['token']) ){
			$sophieu=decode($_POST['suaphieu']);
			$sql='UPDATE khao_sat SET '.$t3.' WHERE ks_so_phieu='.$sophieu;
			$nhatky='Cập nhật mới phiếu khảo sát số'.$sophieu.' - Cập nhật nội dung phiếu';
		}
		elseif($phieuexist>0){
			$sql='UPDATE khao_sat SET '.$t3.' WHERE ks_so_phieu='.$phieuexist;
			$nhatky='Cập nhật mới phiếu khảo sát số'.$phieuexist.' - lần 1 nhà hàng';
		}
		else{
			$sql='INSERT INTO khao_sat ('.$t1.') VALUES ('.$t2.')';
			$nhatky='Nhà hàng - Tạo mới phiếu khảo sát';
		}
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky($nhatky);	
					header('location: index.php?ylan=phieu_nhahang&ok=1');
				}
				else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source).'|'.$sql;
	}
}
else{
	$tieudechinh='Phiếu khảo sát khách hàng - nhà hàng';
	$tieude_submit='tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;	
}
if(!isset($ngay_khao_sat))  $ngay_khao_sat=date("Y-m-d");
$noidungmau=noiDungMau(1,2);//(1) load nội dung mẫu nhà hàng. (2)tra ve sap xep theo truong ten_sql
//var_dump($noidungmau);
$noidung='';
if(isset($goBack))  $noidung=$noidung.$goBack.'<br><br>';
if(isset($sophieu)) $noidung=$noidung.soPhieu('sophieu',$sophieu);	else $noidung=$noidung.soPhieu('sophieu');
if(isset($ngay_khao_sat)) $noidung=$noidung.ngayKhaoSat('ngay_khao_sat',$ngay_khao_sat); else $noidung=$noidung.ngayKhaoSat('ngay_khao_sat');
$noidung=$noidung.tieuDe($noidungmau['nhahangvabar']['noidung']);
if(isset($rest_chung)) $noidung=$noidung.chon($noidungmau['ks_rest_chung']['noidung'],'rest_chung',$rest_chung); else $noidung=$noidung.chon($noidungmau['ks_rest_chung']['noidung'],'rest_chung');
$noidung=$noidung.tieuDePhu($noidungmau['nhahang']['noidung']);
if(isset($rest_dich_vu)) $noidung=$noidung.chon($noidungmau['ks_rest_dich_vu']['noidung'],'rest_dich_vu',$rest_dich_vu); else $noidung=$noidung.chon($noidungmau['ks_rest_dich_vu']['noidung'],'rest_dich_vu');
if(isset($rest_do_an)) $noidung=$noidung.chon($noidungmau['ks_rest_do_an']['noidung'],'rest_do_an',$rest_do_an); else $noidung=$noidung.chon($noidungmau['ks_rest_do_an']['noidung'],'rest_do_an');
if(isset($rest_do_uong)) $noidung=$noidung.chon($noidungmau['ks_rest_do_uong']['noidung'],'rest_do_uong',$rest_do_uong); else $noidung=$noidung.chon($noidungmau['ks_rest_do_uong']['noidung'],'rest_do_uong');
if(isset($rest_trang_tri)) $noidung=$noidung.chon($noidungmau['ks_rest_trang_tri']['noidung'],'rest_trang_tri',$rest_trang_tri); else $noidung=$noidung.chon($noidungmau['ks_rest_trang_tri']['noidung'],'rest_trang_tri');
$noidung=$noidung.tieuDe($noidungmau['caitienchatluong']['noidung']);
if(isset($how_an_uong)) $noidung=$noidung.dongTxt($noidungmau['ks_how_an_uong']['noidung'],'how_an_uong',$how_an_uong); else $noidung=$noidung.dongTxt($noidungmau['ks_how_an_uong']['noidung'],'how_an_uong');



if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có nội dung, loại dữ liệu, tên trường chứ';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới/cập nhật nội dung khảo sát thành công.';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}

include './views/phieu_nhahang.phtml';
?>