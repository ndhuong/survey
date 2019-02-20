<?php
//require_once('./config/config.php');
$stt = $_GET['stt'];

$kiemtra_sql="SELECT nd_stt FROM noidungkhaosat WHERE (nd_stt=".$stt.")";
$kiemtra_query=mysqli_query($source,$kiemtra_sql);
if($kiemtra_query){
	if(mysqli_fetch_array( $kiemtra_query )>0)
		{
			echo '<br><font color=red><b> Số thứ tự này đã được dùng rồi, hãy chọn số khác khác</b></font><input type="hidden" name="sttok" value="-1">';
		}
		else{
			echo '<input type="hidden" name="sttok" value="1" >';
			echo '<br><font color="green"><i>Có thể sử dụng số thứ tự này.</i></font>';

		}
	}
	else
		echo 'có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;
?>