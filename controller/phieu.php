<?php
//require_once('./config/config.php');
$sophieu = $_GET['id'];

$kiemtra_sql="SELECT ks_so_phieu,ks_id FROM khao_sat WHERE (ks_so_phieu=".$sophieu.")";
$kiemtra_query=mysqli_query($source,$kiemtra_sql);
if($kiemtra_query){
	$res = mysqli_fetch_array( $kiemtra_query );
	if(count($res)>0)
		{
			$new_id=encode($res["ks_id"]);
			echo '<br><font color=red><b> Đã có số phiếu này rồi, hãy chọn số phiếu khác</b></font><input type="hidden" name="phieuok" value="-1"> <br><a href="./index.php?ylan=phieumoi&sua='.$new_id.'"> Hoặc Bấm vào đây để sửa phiếu này</a>';
		}
		else{
			echo '<input type="hidden" name="phieuok" value="1" >';
			echo '<br><font color="green"><i>Có thể sử dụng số phiếu này.</i></font>';

		}
	}
	else
		echo 'có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;
?>