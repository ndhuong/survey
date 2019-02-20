<?php
if(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])){
	//echo 'kiểm tra các giá trị';
	$id=$_SESSION['user_id'];
	$sql='SELECT * FROM login  WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$user1=mysqli_fetch_array( $query );
		$name=$user1['log_name'];
		$user=$user1['log_user'];
		$pass=$user1['log_pass'];
		$oldpass=md5( addslashes( $_POST['oldpass'] ) );;
		$newname=$_POST['name'];
		$newpass=addslashes($_POST['newpass']);
		$renewpass=addslashes($_POST['renewpass']);
		if($oldpass != $pass){
			// không giống mật khẩu hiện tại, thoát báo lỗi
			header('location: ./user_up&err=1');
		}
		else{
			$sql1='';
			// xử lý phần họ và tên
			if(strlen($newname)<1){
				// Họ và tên không được để trống
				header('location: ./user_up&err=3');
			}
			else{
				$sql1=$sql1.", log_name='".$newname."'";
			} // kết thúc xử lý họ tên
			if($newpass != $renewpass){
				// hai mật khẩu mới không giống nhau
				header('location: ./user_up&err=2');
			}
			else{
				// đã xác nhận xong pas
				$newpass=md5( addslashes($newpass));
				$sql1=$sql1.=", log_pass='".$newpass."'";
			}
			if(strlen($sql1)>2){ // xác định xem có dữ liệu của sql không
				$sql1=substr($sql1, 1);
				$sql='UPDATE login SET '.$sql1.' WHERE log_id='.$id;
				//echo $sql;
				$query=mysqli_query($source,$sql);
					// Thông báo hoàn tất việc cập nhật pass
					if ($query)
						{
							nhatky('Cập nhật thông tin người dùng có id: '.$id);	
							header('location: ./main6&ok=1');
						}
						else $error= "Có lỗi trong quá trình cập nhật".$sql.' |'.mysqli_error($source);
				
			}
		}
	}
	else{
		echo 'có lỗi kết nối csdl.';
	}
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$repass=$_POST['repass'];
	$fullname=$_POST['name'];
}

	$tieudechinh='cập nhật người dùng';

	$tieudesubmit='Cập nhật';
	$id=$_SESSION['user_id'];
	$sql='SELECT * FROM login  WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$user1=mysqli_fetch_array( $query );
		$name=$user1['log_name'];
		$user=$user1['log_user'];
	}
	if(isset($_GET['err'])){
		if($_GET['err']==1) $error='Không đúng mật khẩu hiện tại';
		elseif($_GET['err']==2) $error='Mật khẩu mới và xác nhận mật khẩu mới phải giống nhau';
		elseif($_GET['err']==3) $error='Họ và tên không được để trống';
	}
	if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
	if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
	$token =token();
	$_SESSION['token']=$token;
	include './views/user_up.phtml';
?>