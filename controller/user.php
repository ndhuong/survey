<?php
function loadDanhSachDonVi($id=0){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi ORDER BY dv_name ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có đơn vị nào cả, hãy tạo đơn vị mới đi';
		}
		else{
			$danhsach='<select name="donvi" class="txt" required> <option value="0"> &darr; Chọn đơn vị &darr; </option>';
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$danhsach=$danhsach.'<option value="'.$result['dv_id'].'" ';
				if($result['dv_id']==$id) $danhsach=$danhsach.' selected ';
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
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	// xóa người dùng
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM login WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
	$res=mysqli_fetch_array($query);
	$sql='DELETE FROM login WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		nhatky('xóa người dùng: '.$res['log_user'].'- Họ và tên: '.$res['log_name']);
			header('location: index.php?ylan=user_ql&d=1');
	}
	else{
		$error='Lỗi không Xóa đc người dùng';
		if(!isset($tieudesubmit)) $tieudesubmit='Tạo mới';
		$token =token();
		$_SESSION['token']=$token;
		$danhsach=danhSachNguoiNhan();
		include './views/user.phtml';
	}
}
elseif(isset($_GET['reset'])&&($_SESSION['token']==decodetoken($_GET['reset'])) ){
	$id=decode($_GET['reset']);
	$token =token();
	$_SESSION['token']=$token;
	if(isset($_GET['err'])) $error='Mật khẩu, xác nhận mật khẩu không trùng nhau';
	$tieudechinh='cập nhật thông tin người dùng';
	$tieudesubmit='Cập nhật';

	$sql='SELECT * FROM login WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$user=mysqli_fetch_array( $query );
		$tendangnhap=' value="'.$user['log_user'].'" readonly ><input type=hidden name=reset value="'.encode($id).'" ';
		$showpass=1;
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])&&isset($_POST['reset'])){
	$id=decode($_POST['reset']);
	$pass=$_POST['pass'];
	$repass=$_POST['repass'];
	$token =token();
	
	$_SESSION['token']=$token;
	if($pass != $repass){
		$newid=encode($id);
		header('location: index.php?ylan=user&reset='.$newid.'&err=1');
	}
	else{
		$passwords=md5( addslashes( $pass ) );
		$sql='UPDATE login SET log_pass="'.$passwords.'" WHERE log_id='.$id;
		$query=mysqli_query($source,$sql);
			// Thông báo hoàn tất việc cập nhật pass
			if ($query)
				{
					nhatky('Cập nhật mật khẩu người dùng có id: '.$id);	
					header('location: index.php?ylan=user_ql&ok2=1');
				}
				else $error= "Có lỗi trong quá trình cập nhật". mysqli_error($source);
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])&&isset($_POST['sua'])){
	//echo 'cập nhật sửa chữa';
	$id=decode($_POST['sua']);
	$fullname=$_POST['name'];
	$donvi=$_POST['donvi'];
	if(isset($_POST['admin'])) {
		$admin=1;
	} 
	else {
		$admin=0;
	}
	if(isset($_POST['admin2'])) {
		$admin2=1;
	} 
	else {
		$admin2=0;
	}
	$old_sql='SELECT * FROM login WHERE log_id='.$id;
	$old_query=mysqli_query($source, $old_sql);
	$old_user=mysqli_fetch_array( $old_query );
	$sql='UPDATE login SET log_name="'.$fullname.'", log_admin='.$admin.', log_admin2='.$admin2.',log_bo_phan='.$donvi.' WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
			// Thông báo hoàn tất việc cập nhật tài khoản
			if ($query)
				{
					$tmp=' | '.$old_user['log_name'].' -> '.$fullname.' | Admin: '.$old_user['log_admin'].' -> '.$admin.' | Quản lý: '.$old_user['log_admin2'].' -> '.$admin2;
					nhatky('Cập nhật người dùng: '.$tmp);	
					header('location: index.php?ylan=user_ql&ok2=1');
				}
				else $error= "Có lỗi trong quá trình cập nhật". mysqli_error($source);

}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])){
	//echo 'kiểm tra các giá trị';
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$repass=$_POST['repass'];
	$fullname=$_POST['name'];
	$donvi=$_POST['donvi'];
	if(isset($_POST['admin'])) {
		$admin=1;
		$checkadmin=' checked ';
	} 
	else {
		$admin=0;
		$checkadmin=' ';
	}
	if(isset($_POST['admin2'])) {
		$admin2=1;
		$checkadmin2=' checked ';
	} 
	else {
		$admin2=0;
		$checkadmin2=' ';
	}
	// đoạn này để chuẩn bị cho trường họp sai pas hoặc cố tình tạo tên đăng nhập đã tồn tại
	$tieudechinh='Tạo mới người dùng';
	$tieudesubmit='tạo mới';
	$tendangnhap=' value="'.$user.'" required ';
	$token =token();
	$_SESSION['token']=$token;
	$showpass=1;
	$usercreate=1;
	$dongdangnhap=' dong ';
	// hết đoạn chuẩn bị
	if($_POST['tenok'] < 0 ){
		// đã có tên đăng nhập này rồi, kiểm tra ở oh
		$error='Đã bảo là có tên đăng nhập này rồi cơ mà.';
	}
	else{
		if($pass!=$repass){
			$error='Mật khẩu, xác nhận mật khẩu không trùng nhau';
		}
		else{
			// pass trùng nhau --> đi tới tạo user
			$passwords=md5( addslashes( $pass ) );
			$sql="INSERT INTO login (log_user,log_pass,log_name,log_admin,log_admin2,log_bo_phan) VALUES ('".$user."','".$passwords."','".$fullname."',".$admin.",".$admin2.",".$donvi.")";
			
			$query=mysqli_query($source,$sql);
			// Thông báo hoàn tất việc tạo tài khoản
			if ($query)
				{
					nhatky('Tạo mới người dùng: '.$user.' - '.$fullname);	
					header('location: index.php?ylan=user_ql&ok=1');
				}
				else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source);
		}
		
	}
	
}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;

	$tieudechinh='cập nhật thông tin người dùng';
	$tieudesubmit='Cập nhật';
	$usercreate=1;

	$sql='SELECT * FROM login WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$user=mysqli_fetch_array( $query );
		$tendangnhap=' value="'.$user['log_user'].'" readonly ><input type=hidden name=sua value="'.encode($id).'" ';
		$fullname=$user['log_name'];
		if($user['log_admin']>0) $checkadmin=' checked '; else $checkadmin='';
		if($user['log_admin2']>0) $checkadmin2=' checked '; else $checkadmin2='';
		$donvi=$user['log_bo_phan'];
	}
}
else{
	$tieudechinh='Tạo mới người dùng';
	$tieudesubmit='tạo mới';
	$tendangnhap='required ';
	$token =token();
	$_SESSION['token']=$token;
	$showpass=1;
	$usercreate=1;
	$dongdangnhap=' dong ';
	if(!isset($donvi)) $donvi=0;
}
if(isset($_GET['err']) && ($_GET['err']==2)) {
	if(isset($error)) $error=$error.'<br> Đã tồn tại tên đăng nhập này rồi';
	else $error= ' Đã tồn tại tên đăng nhập này rồi';
}
if(isset($_GET['err']) && ($_GET['err']==1)) {
	if(isset($error)) $error=$error.'<br> Mật khẩu, xác nhận mật khẩu không trùng nhau';
	else $error= ' Mật khẩu, xác nhận mật khẩu không trùng nhau';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
$tieudechinh='Tạo mới người dùng';
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/user.phtml';
?>