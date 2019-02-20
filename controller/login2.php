<?php
if (( isset($_POST['submit']))  ){ //&& ($_POST['token']==$_SESSION['token'])
	$username = addslashes( $_POST['username'] );
	$password = md5( addslashes( $_POST['password'] ) );
	$sql1='select * from login where (log_user="'.$username.'")';
	$query=mysqli_query($source,$sql1);
	var_dump($sql1);
	if($query){
		$member = mysqli_fetch_array( $query );
		if ( mysqli_num_rows( $query ) <= 0 ) {
				$error= "Đăng nhập không thành công. Hãy thử lại111.....";
				nhatky('Đăng nhập không thành công, user không tồn tại. user='.$username);
		}else {
			if ( $password != $member['log_pass'] )	{
				$error = "Đăng nhập không thành công. Hãy thử lại...";
				nhatky('Đăng nhập không thành công, sai mật khẩu. user='.$username);
			}else {
				$_SESSION['user_id'] = $member['log_id'];
				$_SESSION['user_time'] = time();
				if ($member['log_admin']== 1)		$_SESSION['user_admin'] = '1';
				if ($member['log_admin2']== 1)	{
					$_SESSION['user_quanly'] = '1';
					if ($member['log_sa']== 1)		$_SESSION['sa'] = '1';
					$_SESSION['bophan']=$member['log_bo_phan'];
					nhatky("ID: ".$member['log_user']." - Đăng nhập vào hệ thống.");
					header('location:./index.php?ylan=main2');
				}	
				if ($member['log_sa']== 1)		$_SESSION['sa'] = '1';
				$_SESSION['bophan']=$member['log_bo_phan'];
				$success='Đăng nhập thành công';
				nhatky("ID: ".$member['log_user']." - Đăng nhập vào hệ thống.");
				if(isset($_POST['phonglam'])) header('location:./'.urldecode($_POST['phonglam']));
				else header('location:./main6');
			}
		}
	} else {
		 header('location:./login&err="co loi sql'.mysqli_error($source).'"');
	}
}else {
	header('location:./login&err="Bạn phải đăng nhập trước đã"');
}
?>