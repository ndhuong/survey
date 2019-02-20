<?php
function loadDanhSachDonVi($default=0){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi ORDER BY dv_name ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có đơn vị nào cả, hãy tạo đơn vị mới đi';
		}
		else{
			$danhsach='<select name="donvi" class="txt" required> <option value="-1"> &darr; Chọn đơn vị &darr; </option>';
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$danhsach=$danhsach.'<option value="'.$result['dv_id'].'" ';
				if($result['dv_id']==$default) $danhsach=$danhsach.' selected ';
				$danhsach=$danhsach.' > '. $result['dv_name'].' </option>';				
			}
			$danhsach=$danhsach.'</select>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function loadDanhSachDonVi()
//----------------------------------------
function loadTenDonVi($id=0){
	// $id= id của đơn vị
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi WHERE dv_id='.$id;
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Không có tên đơn vị này';
		}
		else{
			$result = mysqli_fetch_array( $danhsach_query );
			$danhsach=$result['dv_name'];
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function loadDanhTenDonVi()
function danhSach(){
	// trả về danh sách người trực mod
	require './config/config.php';
	$danhsach_sql='SELECT * FROM truc_mod';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có người nào cả, hãy tạo mới đi';
		}
		else{
			$danhsach='<table class="table-striped">
			<tr><th class="text-center">STT</th>
			<th class="text-center"> Họ và tên </th>
			<th class="text-center"> Đơn vị </th>
			<th class="text-center"> Email </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center">&nbsp; <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			$stt=0;
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt++;
				$id=encode($result['tm_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa người này không ?')\" ";
				$sua='<a href="./index.php?ylan=trucmod&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./index.php?ylan=trucmod&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				
				$danhsach=$danhsach.'<tr><td class="text-center">'.$stt.'</td>
							<td class="text-left">'.$result['tm_ten'].'&emsp;</td>
							<td class="text-center">'.loadTenDonVi($result['tm_donvi']).' &emsp;</td>
							<td class="text-center">'.$result['tm_email'].' &emsp;</td>
							<td class="text-center">'.$sua.' </td>
							<td class="text-center">'.$xoa.'  </td></tr>';
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
	$sql='SELECT * FROM truc_mod WHERE tm_id='.$id;
	$query=mysqli_query($source,$sql);
	$result=mysqli_fetch_array( $query );
	$sql='DELETE FROM truc_mod WHERE tm_id='.$id;
	$query=mysqli_query($source,$sql);
			if ($query){
				nhatky('Xóa người trực MOD: id='.$result['tm_id'].'| Họ tên: '.$result['tm_ten'].'| Đơn vị: '.loadTenDonVi($result['tm_donvi']).'| Email: '.$result['tm_email']);
					header('location: index.php?ylan=trucmod&ok=3');
				}	else $error= "Có lỗi". mysqli_error($source).$sql;
}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh='cập nhật người trực MOD';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM truc_mod WHERE tm_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$hoten=$result['tm_ten'];
		$donvi=$result['tm_donvi'];
		$email=$result['tm_email'];
		$arr=array();
		$arr['0']['stt']=0;
		$arr['0']['link']='main6';
		$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
		$arr['0']['active']=0;
		$arr['1']['stt']=1;
		$arr['1']['link']='';
		$arr['1']['name']=$tieudechinh;
		$arr['1']['active']=1;
		include './views/trucmod_sua.phtml';
	}else{
		$hoten='';
		$donvi=0;
		$email='';
	}

}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$hoten=$_POST['hoten'];
	$email=$_POST['email'];
	$donvi=$_POST['donvi'];
	if(isset($_POST['sua'])){
		$id=decode($_POST['sua']);
		$sql='UPDATE truc_mod SET tm_ten="'.$hoten.'",tm_donvi='.$donvi.', tm_email="'.$email.'" WHERE tm_id='.$id;
		$nhatky='Cập nhật Thông tin người trực MOD ID='.$id.'| tên mới: '.$hoten.'| Đơn vị: '.loadTenDonVi($donvi).'| Email: '.$email;
		$ok=2;
	}
	else{
		$sql='INSERT INTO truc_mod (tm_ten, tm_donvi, tm_email) VALUES ("'.$hoten.'",'.$donvi.',"'.$email.'")';
		$nhatky='Tạo mới người trực MOD Họ tên: '.$hoten.'| Đơn vị: '.loadTenDonVi($donvi).'| Email: '.$email;
		$ok=1;
	}
	$query=mysqli_query($source,$sql);
	if ($query)
		{
			nhatky($nhatky);	
			header('location: index.php?ylan=trucmod&ok='.$ok);
		}
	else $error= "Có lỗi". mysqli_error($source).'|'.$sql;	
}
else{
	$tieudechinh = 'Danh sách người trực MOD ';
	$tieude_submit = 'Tạo mới';
	$token =token();
	$_SESSION['token']=$token;	

	$danhsach=danhSach();

	if(isset($_GET['err'])){
		if($_GET['err']==1) $error='Có lỗi, nhập đủ các thông tin';
	}
	if(isset($_GET['ok'])){
		if($_GET['ok']==1) $status='Tạo mới người trực MOD thành công.';
		elseif($_GET['ok']==2) $status='Cập nhật thông tin người trực MOD thành công.';
		elseif($_GET['ok']==3) $status='Xóa người trực MOD thành công.';
	}
	if(isset($error)){
			$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
		}
	if(isset($status)){
			$status="<div class='alert alert-success text-center'>".$status." </div>" ;
		}


	$arr=array();
	$arr['0']['stt']=0;
	$arr['0']['link']='main6';
	$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
	$arr['0']['active']=0;
	$arr['1']['stt']=1;
	$arr['1']['link']='';
	$arr['1']['name']=$tieudechinh;
	$arr['1']['active']=1;
	include './views/trucmod.phtml';
}


?>