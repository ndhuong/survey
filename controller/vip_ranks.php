<?php
function danhSach(){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM vip_ranks ORDER BY vr_stt ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có dòng nội dung nào cả, hãy tạo nội dung mới đi';
		}
		else{
			$danhsach='<table class="table-striped">
			<tr><th class="text-center">STT</th>
			<th class="text-center"> Tên loại VIP </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt=$result['vr_stt'];
				

				$id=encode($result['vr_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa loại này không ?')\" ";
				$sua='<a href="./index.php?ylan=vip_ranks&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./index.php?ylan=vip_ranks&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				
				$danhsach=$danhsach.'<tr><td class="text-center">'.$stt.'</td><td>'.$result['vr_name'].'</td><td class="text-center">'.$sua.' </td><td class="text-center">'.$xoa.'  </td></tr>';
			}
			$danhsach=$danhsach.'</table>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách nội dung";
	}
	return $danhsach;
} // Hết function danhSach():
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){

}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])&&isset($_POST['sua'])){
	$id=decode($_POST['sua']);
	$tenloai=$_POST['tenloai'];
	$stt=$_POST['stt'];
	if(strlen($tenloai)<1){
		header('location: index.php?ylan=vip_ranks&sua='.$id.'&err=1');
	}
	else{
		$sql='UPDATE vip_ranks SET vr_name="'.$tenloai.'",vr_stt="'.$stt.'" WHERE vr_id='.$id;
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Cập nhật tên loại VIP: '.$tenloai);	
					header('location: index.php?ylan=vip_ranks&ok=1');
				}
				else $error= "Có lỗi trong quá trình cập nhật". mysqli_error($source).$sql;
		
	}

}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh='cập nhật Loại VIP';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM vip_ranks WHERE vr_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$stt=$result['vr_stt'];
		$tenloai=$result['vr_name'];
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$tenloai=$_POST['tenloai'];
	$stt=$_POST['stt'];
	if((strlen($tenloai)<1) || ($_POST['sttok']<0) ){
		header('location: index.php?ylan=vip_ranks&err=1');
	}
	else{
		$sql='INSERT INTO vip_ranks (vr_stt,vr_name) VALUES ('.$stt.',"'.$tenloai.'")';
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Tạo mới tên loại VIP: '.$tenloai);	
					header('location: index.php?ylan=vip_ranks&ok=1');
				}
				else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source).'|'.$sql;
		
	}
}
else{
	$tieudechinh = 'Phân loại VIP';
	$tieude_submit = 'tạo ';
	$token =token();
	$_SESSION['token']=$token;	
	$sql='SELECT MAX(`vr_stt`) FROM vip_ranks';
	$query=mysqli_query($source,$sql);
	if($query){
		//var_dump($query);
		$result=mysqli_fetch_array( $query );
		//var_dump($result);
		$stt=$result[0]+1;
		$stt_ok=1;
	}
}

 
$danhsach=danhSach();

if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có nội dung, loại dữ liệu, tên trường chứ';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới nội dung VIP thành công.';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/vip_ranks.phtml';
?>