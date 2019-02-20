<?php
function loadDanhSachDonVi($default=0){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi ORDER BY dv_name ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có đơn vị nào cả, hãy tạo đơn vị mới đi';
		}
		else{
			$danhsach='<select name="donvi" class="txt" required> <option value="-1"> &darr; Chọn đơn vị &darr; </option>';
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$danhsach=$danhsach.'<option value="'.$result['dv_id'].'" ';
				if($result['dv_id']==$default) $danhsach=$danhsach.' selected ';
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
function loadDanhSachNguoiTruc($name,$default=-1){
	// $name: biến cho select.
	// $default: chọn mặc định 
	require './config/config.php';
	$danhsach_sql='SELECT * FROM truc_mod ORDER BY tm_ten ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có người nào cả, hãy tạo mới đi';
		}
		else{
			$danhsach='<select name="'.$name.'" class="txt" required> <option value="-1"> &darr; Chọn người dùng &darr; </option>';
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$danhsach=$danhsach.'<option value="'.$result['tm_id'].'" ';
				if($result['tm_id']==$default) $danhsach=$danhsach.' selected ';
				$danhsach=$danhsach.' > '. $result['tm_ten'].' </option>';				
			}
			$danhsach=$danhsach.'</select>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách người trực";
	}
	return $danhsach;
} // Hết function loadDanhSachNguoiTruc()
//----------------------------------------
function khoiTao(){
	// khởi tạo mảng.
	require './config/config.php';
	$sql='SELECT * FROM truc_mod ORDER BY tm_ten ASC';
	$query=mysqli_query($source,$sql);
	$arr=array();
	if($query){
		$stt=0;
		while ($res = mysqli_fetch_array( $query )){
			$arr[$stt]['id']=$res['tm_id'];
			$arr[$stt]['ten']=$res['tm_ten'];
			$arr[$stt]['donvi']=loadTenDonVi($res['tm_donvi']);
			$stt++;
		}
	}	else $arr['error']='có lỗi.';
	return $arr;
}// hết khoiTao
function loadLich($arr,$nam=null,$thang=null){
	// $arr= mảng chứa thông tin tạo lịch
	// #$nam: Năm xem lịch
	//$thang: tháng xem lịch
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	$ngayhomnay=date('d');
	$thanghientai=date('m');
	//echo $thang.'/'.$nam; class="table-responsive"
	$hangngay='<div ><table class="table-striped table-bordered" id="fixTable">';
	$stt=0;

	$so_ngay_trong_thang=cal_days_in_month(CAL_GREGORIAN,$thang,$nam);
	$hangngay=$hangngay.'<tr class="bg-success">
			<th rowspan="2" class="text-center fix-colum"> STT </th>
			<th rowspan="2" class="text-left fix-colum"> Họ và tên </th>
			<th rowspan="2" class="text-center fix-colum"> Đơn vị </th>
			<th class="text-center" colspan="'.$so_ngay_trong_thang .'"> Tháng '.$thang.' - '.$nam.'</th></tr>
			<tr class="bg-success">';
	for ($i=1; $i <= $so_ngay_trong_thang; $i++) { 
		if($i<10) $ngay='0'.$i; else $ngay=$i;
		if(($i==$ngayhomnay) && ($thang==$thanghientai))
			$today_style='text-center badge-danger text-white';
		else $today_style='text-center ';
		$hangngay=$hangngay.'<th class="'.$today_style.'"> &nbsp;'.$ngay.'&nbsp; </th>';
	}
	$hangngay=$hangngay.'</tr>';
	$max_hoten=0;
	$max_donvi=0;
	for ($i=0; $i < count($arr) ; $i++) { 
		$stt=$i+1;
		if(strlen($arr[$i]['ten'])>$max_hoten ) $max_hoten=strlen($arr[$i]['ten']);
		if(strlen($arr[$i]['donvi'])>$max_donvi ) $max_donvi=strlen($arr[$i]['donvi']);
		$hangngay=$hangngay.'<tr ><td class="text-center fix-colum">'. $stt .'</td>';
		$hangngay=$hangngay.'<td class="text-left fix-colum">'.$arr[$i]['ten'].'&emsp;</td>';		
		$hangngay=$hangngay.'<td class="text-center fix-colum">'.$arr[$i]['donvi'].'&emsp;</td>';	
		for ($j=1; $j <= $so_ngay_trong_thang; $j++) { 
			if($j<10) $ngay='0'.$j; else $ngay=$j;
			$namthangngay=$nam.'-'.$thang.'-'.$ngay;
			if(($j==$ngayhomnay) && ($thang==$thanghientai)) $today_style='text-center badge-danger text-white'; else $today_style='text-center';
			$hangngay=$hangngay.'<td class="'.$today_style.'"> &nbsp; </td>';	
		}
		$hangngay=$hangngay.'</tr>';
	}
	$hangngay=$hangngay.'<tr><td></td><td>';
	for($k=1; $k<$max_hoten+3; $k++){
		$hangngay=$hangngay.'_';
	}
	$hangngay=$hangngay.'</td><td>';
	for($k=1; $k<=$max_donvi+3; $k++){
		$hangngay=$hangngay.'_';
	}
	$hangngay=$hangngay.'</td><td colspan="'.$so_ngay_trong_thang .'"> </td></tr>';
	$hangngay=$hangngay.'</table></div><br>';
	return $hangngay;
}// hết loadLich
//----------------------------------------
function loadTenDonVi($id=0){
	// $id= id của đơn vị
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi WHERE dv_id='.$id;
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Không có tên đơn vị này';
		}
		else{
			$result = mysqli_fetch_array( $danhsach_query );
			$danhsach=$result['dv_name'];
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function loadDanhTenDonVi()
function danhSach(){
	// trả về danh sách người trực mod
	require './config/config.php';
	$danhsach_sql='SELECT * FROM truc_mod';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có người nào cả, hãy tạo mới đi';
		}
		else{
			$danhsach='<table class="table-striped">
			<tr><th class="text-center">STT</th>
			<th class="text-center"> Họ và tên </th>
			<th class="text-center"> Đơn vị </th>
			<th class="text-center"> Email </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center">&nbsp; <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			$stt=0;
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt++;
				$id=encode($result['tm_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa người này không ?')\" ";
				$sua='<a href="./index.php?ylan=trucmod&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./index.php?ylan=trucmod&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				
				$danhsach=$danhsach.'<tr><td class="text-center">'.$stt.'</td>
							<td class="text-left">'.$result['tm_ten'].'&emsp;</td>
							<td class="text-center">'.loadTenDonVi($result['tm_donvi']).' &emsp;</td>
							<td class="text-center">'.$result['tm_email'].' &emsp;</td>
							<td class="text-center">'.$sua.' </td>
							<td class="text-center">'.$xoa.'  </td></tr>';
			}
			$danhsach=$danhsach.'</table>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function danhSach():