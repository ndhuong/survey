<?php
if(isset($_GET['ca'])){
	if($_GET['ca']==0) $tmp='<input type="text" class="txt" placeholder="Hãy chọn ca trực đi.." readonly >';
	else{
		require './controller/mod_func.php';
		$id_nguoitruc=(int)substr($_GET['ca'],0,2);
		$nguoitruc=hoTenNguoiTruc($id_nguoitruc);
		$tmp='<select name="nguoi_kiem_tra" class="txt"> <option value="'.$id_nguoitruc.'">'.$nguoitruc.'</option ></select>';
	}
	echo $tmp;
}
//require_once('./config/config.php');
/*
$date = $_GET['date'];
$kiemtra_sql="SELECT grcl_id,grcl_ngay_kiem_tra FROM grcl WHERE (grcl_ngay_kiem_tra=".$date.")";
$kiemtra_query=mysqli_query($source,$kiemtra_sql);
if($kiemtra_query){
	if(mysqli_num_rows( $kiemtra_query )>0)
		{
			$date=strtotime(substr($date,1,strlen($date)-2));
			$res=mysqli_fetch_array( $kiemtra_query );
			$sua=encode($res['grcl_id']);
			echo '<font color=red><b> Đã có báo cáo của ngày này rồi, hãy chọn ngày khác khác</b></font><input type="hidden" name="ngay_ok" value="-1"><br> hoặc<a href="index.php?ylan=grcl&date='.$date.'&sua='.$sua.'"> bấm vào đây để sửa chữa báo cáo của ngày này</a>';
		}
		else{
			echo '<input type="hidden" name="ngay_ok" value="1" >';
			echo '<font color="green"><i>Có thể tạo GUEST ROOM Checklist cho ngày này.</i></font>';

		}
	}
	else
		echo 'có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;
		*/
?>