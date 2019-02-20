<?php
//require_once('./config/config.php');
$user = $_GET['id'];

$kiemtra_sql="SELECT log_user FROM login WHERE (log_user=".$user.")";
$kiemtra_query=mysqli_query($source,$kiemtra_sql);
if($kiemtra_query){
	if(mysqli_fetch_array( $kiemtra_query )>0)
		{
			echo '<br><font color=red><b> Đã có tên đăng nhập này rồi, hãy chọn tên đăng nhập khác</b></font><input type="hidden" name="tenok" value="-1">';
		}
		else{
			echo '<input type="hidden" name="tenok" value="1" >';
			echo '<br><font color="green"><i>Có thể sử dụng tên đăng nhập này.</i></font>';

		}
	}
	else
		echo 'có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;
?>