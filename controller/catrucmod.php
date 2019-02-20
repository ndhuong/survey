<?php
function danhSachCa(){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM catrucmod';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có Ca nào cả, hãy tạo ca mới đi';
		}
		else{
			$danhsach='<table class="table-striped">
			<tr><th class="text-center">STT</th>
			<th class="text-center"> Tên ca </th>
			<th class="text-center"> Ký hiệu </th>
			<th class="text-center"> Ghi chú </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			$stt=0;
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt++;
				$id=encode($result['ca_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa ca này không ?')\" ";
				$sua='<a href="./catrucmod&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./catrucmod&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				
				$danhsach=$danhsach.'<tr><td class="text-center">'.$stt.'</td><td>'.$result['ca_ten'].'</td><td>'.$result['ca_ky_hieu'].'</td><td>'.$result['ca_ghi_chu'].'</td><td class="text-center">'.$sua.' </td><td class="text-center">'.$xoa.'  </td></tr>';
			}
			$danhsach=$danhsach.'</table>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function danhSach():
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM catrucmod WHERE ca_id='.$id;
	$query=mysqli_query($source,$sql);
	$result=mysqli_fetch_array( $query );
	$sql='DELETE FROM catrucmod WHERE ca_id='.$id;
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Xóa ca trực: id ='.$result['ca_id'].' | Tên ca'.$result['ca_ten']);
					header('location: catrucmod&ok=3');
				}
				else $error= "Có lỗi". mysqli_error($source).$sql;
}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh='cập nhật ca trực';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM catrucmod WHERE ca_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$tencatruc=$result['ca_ten'];
		$kyhieu=$result['ca_ky_hieu'];
		$ghichu=$result['ca_ghi_chu'];
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$tencatruc=$_POST['tencatruc'];
	$kyhieu=$_POST['kyhieu'];
	$ghichu=$_POST['ghichu'];
	if(isset($_POST['sua'])){
		$id=decode($_POST['sua']);
		$sql='UPDATE catrucmod SET ca_ten="'.$tencatruc.'",ca_ky_hieu="'.$kyhieu.'",ca_ghi_chu="'.$ghichu.'" WHERE ca_id='.$id;
		$nhatky='Cập nhật tên ca ID='.$id.'| tên mới: '.$tencatruc;
		$ok=2;
	}
	else{
		$sql='INSERT INTO catrucmod (ca_ten,ca_ky_hieu,ca_ghi_chu) VALUES ("'.$tencatruc.'", "'.$kyhieu.'", "'.$ghichu.'")';
		$nhatky='Tạo mới tên ca trực mod: '.$tencatruc;
		$ok=1;
	}
	$query=mysqli_query($source,$sql);
	if ($query)
		{
			nhatky($nhatky);	
			header('location: catrucmod&ok='.$ok);
		}
	else $error= "Có lỗi". mysqli_error($source).'|'.$sql;	
}
else{
	$tieudechinh = 'Quản lý tên ca trực MOD';
	$tieude_submit = 'Tạo mới';
	$token =token();
	$_SESSION['token']=$token;	
}

 
$danhsach=danhSachCa();

if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có tên ca chứ';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới tên ca trực thành công.';
	elseif($_GET['ok']==2) $status='Cập nhật tên ca trực thành công.';
	elseif($_GET['ok']==3) $status='Xóa tên ca trực thành công.';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/catrucmod.phtml';
?>