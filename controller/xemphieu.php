<?php
if(isset($_REQUEST['bophan'])){
	$donvi='<input type=hidden name=bophan id="bp" value="'.$_REQUEST['bophan'].'">';
	$tieudechinh='Xem các phiếu khảo sát';
	$tieude_submit = 'tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;	
}
else{
	header('location: index.php?ylan=main');
}
if(isset($_GET['ok'] ) ){
	if($_GET['ok']==1) $status='Đã tạo xong phiếu, nhập dữ liệu phiếu mới';
	elseif($_GET['ok']==2) $status='Đã cập nhật xong phiếu. ';
	elseif($_GET['ok']==3) $status='Đã xóa xong phiếu.';
}
if(isset($_GET['err'] ) ){
	if($_GET['err']==1) $error='Có lỗi, không xóa được phiếu khảo sát đã chọn.';
	
}
//include './views/phieumoi.phtml';
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/xemphieu.phtml';
?>