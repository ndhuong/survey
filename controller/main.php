<?php

//echo 'IP:'.get_user_ip();
if(isset($_SESSION['user_admin'])){
	$phieu='<button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieumoi"\'> Nhập phiếu mới </button>
               <button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieu_nhahang"\'> Nhập phiếu mới Nhà hàng</button>
               <button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieu_letan"\'> Nhập phiếu mới Lễ tân</button>
               <button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieu_kinhdoanh"\'> Nhập phiếu mới Kinh doanh</button>';
    $baocao='<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao"\'> Xem báo cáo FO + FB </button>
            <button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=2"\'> Xem báo cáo Lễ tân</button>
            <button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=1"\'> Xem báo cáo Nhà hàng </button>
            <button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=3"\'> Xem báo cáo P. Kinh doanh</button>';
}
else{
	switch ($_SESSION['bophan']) {
		case '1':
			$phieu='<button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieumoi"\'> Nhập phiếu mới </button>
			<button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieu_nhahang"\'> Nhập phiếu mới Nhà hàng</button>';
			$xemphieu='<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=xemphieu&bophan=1"\'> Xem các phiếu đã nhập </button>';
			if(isset($_SESSION['user_quanly'])){
				$baocao='<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=1"\'> Xem báo cáo Nhà hàng </button>';

			}
			else{
				$baocao='';
			}
			break;
		case '2':
			$phieu='<button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieumoi"\'> Nhập phiếu mới </button>
			<button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieu_letan"\'> Nhập phiếu mới Lễ tân</button>';
			$xemphieu='<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=xemphieu&bophan=2"\'> Xem các phiếu đã nhập </button>';
			if(isset($_SESSION['user_quanly'])){
				$baocao='<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=2"\'> Xem báo cáo Lễ tân </button>';
			}
			else{
				$baocao='';
			}
			break;
		case '3':
			$phieu='<button type="button" class="btn btn-primary btn-block btn-lg" onclick=\'window.location="index.php?ylan=phieu_kinhdoanh"\'> Nhập phiếu mới Kinh doanh</button>';
			$xemphieu='<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=xemphieu&bophan=3"\'> Xem các phiếu đã nhập </button>';
			if(isset($_SESSION['user_quanly'])){
				$baocao='<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=3"\'> Xem báo cáo Kinh doanh </button>';
			}
			else{
				$baocao='';
			}
			break;
	}
}


if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status=' Cập nhật thông tin thành công';
}
if(isset($error)){
		$error="<br><div class='alert alert-danger text-center'>".$error." </div>" ;
	}
	if(isset($status)){
		$status="<br><div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/main.phtml';
/*
<button type="button" class="btn btn-primary btn-block btn-lg" onclick='window.location="index.php?ylan=phieumoi"'> Nhập phiếu mới </button>
               <button type="button" class="btn btn-primary btn-block btn-lg" onclick='window.location="index.php?ylan=phieu_nhahang"'> Nhập phiếu mới Nhà hàng</button>
               <button type="button" class="btn btn-primary btn-block btn-lg" onclick='window.location="index.php?ylan=phieu_letan"'> Nhập phiếu mới Lễ tân</button>
               <button type="button" class="btn btn-primary btn-block btn-lg" onclick='window.location="index.php?ylan=phieu_kinhdoanh"'> Nhập phiếu mới Kinh doanh</button>

<?php
          if(isset($_SESSION['user_quanly']))
          {
              
            echo '<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao"\'> Xem báo cáo </button>';
            echo '<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=2"\'> Xem báo cáo Lễ tân</button>';
            echo '<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=1"\'> Xem báo cáo Nhà hàng </button>';
            echo '<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=baocao2&loaibaocao=3"\'> Xem báo cáo P. Kinh doanh</button>';
          }
          else{
            echo '<button type="button" class="btn btn-success btn-block btn-lg" onclick=\'window.location="index.php?ylan=main"\'> &emsp; </button> ';
          }
      ?>


*/
?>