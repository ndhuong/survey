<?php
//require_once('./config/config.php');
$id = $_GET['id'];

$kiemtra_sql="SELECT sale_id FROM sale_ks WHERE (sale_id=".$id.")";
$kiemtra_query=mysqli_query($source,$kiemtra_sql);
if($kiemtra_query){
	$res = mysqli_fetch_array( $kiemtra_query );
	if(count($res)>0)
		{
			//$res=mysqli_fetch_array( $kiemtra_query );
			$new_id=encode($res["sale_id"]);
			echo '<br><font color=red><b> Đã có số phiếu này rồi, hãy chọn số phiếu khác</b></font><input type="hidden" name="phieuok" value="-1"> <br> <a href="./index.php?ylan=phieu_kinhdoanh&sua='.$new_id.'"> Bấm vào đây để sửa phiếu này</a>';
			
		}
		else{
			echo '<input type="hidden" name="phieuok" value="1" >';
			echo '<br><font color="green"><i>Có thể sử dụng số phiếu này.</i></font>';
			

		}
	}
	else
		echo 'có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;
?>