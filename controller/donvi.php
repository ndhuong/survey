<?php
function danhSachDonVi(){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có đơn vị nào cả, hãy tạo đơn vị mới đi';
		}
		else{
			$danhsach='<table class="table-striped">
			<tr><th class="text-center">STT</th>
			<th class="text-center"> Tên đơn vị </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			$stt=0;
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt++;
				

				$id=encode($result['dv_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa đơn vị này không ?')\" ";
				$sua='<a href="./index.php?ylan=donvi&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./index.php?ylan=donvi&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				
				$danhsach=$danhsach.'<tr><td class="text-center">'.$stt.'</td><td>'.$result['dv_name'].'</td><td class="text-center">'.$sua.' </td><td class="text-center">'.$xoa.'  </td></tr>';
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
	$sql='SELECT * FROM donvi WHERE dv_id='.$id;
	$query=mysqli_query($source,$sql);
	$result=mysqli_fetch_array( $query );
	$sql='DELETE FROM donvi WHERE dv_id='.$id;
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Xóa Đơn vị: id ='.$result['dv_id'].' | Tên đơn vị'.$result['dv_name']);
					header('location: index.php?ylan=donvi&ok=3');
				}
				else $error= "Có lỗi". mysqli_error($source).$sql;
}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh='cập nhật đơn vị';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM donvi WHERE dv_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$tendonvi=$result['dv_name'];
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$tendonvi=$_POST['tendonvi'];
	if(isset($_POST['sua'])){
		$id=decode($_POST['sua']);
		$sql='UPDATE donvi SET dv_name="'.$tendonvi.'" WHERE dv_id='.$id;
		$nhatky='Cập nhật tên đơn vị ID='.$id.'| tên mới: '.$tendonvi;
		$ok=2;
	}
	else{
		$sql='INSERT INTO donvi (dv_name) VALUES ("'.$tendonvi.'")';
		$nhatky='Tạo mới tên đơn vị: '.$tendonvi;
		$ok=1;
	}
	$query=mysqli_query($source,$sql);
	if ($query)
		{
			nhatky($nhatky);	
			header('location: index.php?ylan=donvi&ok='.$ok);
		}
	else $error= "Có lỗi". mysqli_error($source).'|'.$sql;	
}
else{
	$tieudechinh = 'Quản lý đơn vị';
	$tieude_submit = 'Tạo ';
	$token =token();
	$_SESSION['token']=$token;	
}

 
$danhsach=danhSachDonVi();

if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có tên đơn vị chứ';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới đơn vị thành công.';
	elseif($_GET['ok']==2) $status='Cập nhật đơn vị thành công.';
	elseif($_GET['ok']==3) $status='Xóa đơn vị thành công.';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/donvi.phtml';
?>