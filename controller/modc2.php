<?php
if(isset($_GET['ca'])){
	if($_GET['ca']==0) $tmp='<input type="text" class="txt" placeholder="Hãy chọn ca trực đi.." readonly >';
	else{
		require './controller/mod_func.php';
		$id_nguoitruc=(int)substr($_GET['ca'],0,2);
		$nguoitruc=hoTenNguoiTruc($id_nguoitruc);
		$tmp='<select name="ho_ten" class="txt"> <option value="'.$id_nguoitruc.'">'.$nguoitruc.'</option ></select>';
	}
	echo $tmp;
}


?>