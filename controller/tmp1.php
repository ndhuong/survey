<?php
	$username = 'ndhuong';
	$password = md5( addslashes('1') );
	$ten = 'Nguyen Duc Huong';
	$sql1="INSERT INTO login (log_user, log_pass,log_name,login_admin,login_quanly,login_tau) VALUES ('$username', '$password', '$ten',$admin,$quanly,$tau_ql )";
		$a=mysqli_query($source,$sql1);
		// Thông báo hoàn tất việc tạo tài khoản
		if ($a)
		{

		}
		else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source);
	}	
}

?>