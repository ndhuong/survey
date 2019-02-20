<?php
//require_once('./config/config.php');
if(isset($_GET['maso']) || isset($_GET['hoten'])){
	if(isset($_GET['maso'])){

		$maso = $_GET['maso'];
		$maso=substr($maso,1,strlen($maso)-2);
		$kiemtra_sql="SELECT * FROM person WHERE ps_ma_so LIKE '".$maso."%' ";
		$tim='Tìm khách hàng có mã số bắt đầu bằng: '.$maso;
	}
	else{ // đương nhiên còn lại là họ và tên
		$hoten=$_GET['hoten'];
		$hoten=substr($hoten,1,strlen($hoten)-2);
		$kiemtra_sql="SELECT * FROM person WHERE ps_ten_khach LIKE '%".$hoten."%'";
		$tim='Tìm khách hàng Họ tên có chứa ký tự: '.$hoten;
	}
	
	$kiemtra_query=mysqli_query($source,$kiemtra_sql);
	if($kiemtra_query){
		if(mysqli_num_rows( $kiemtra_query )>0)
			{
				$danhsach='<br>'.$tim.'<br>
				<table class="table-striped">
				<tr><th class="text-center">STT</th>
				<th class="text-center"> Mã số </th>
				<th class="text-center"> Họ và tên </th>
				<th class="text-center"> Giới tính </th>
				<th class="text-center"> Ngày sinh </th>
				<th class="text-center"> Đơn vị </th>
				<th class="text-center"> Số điện thoại </th>
				<th class="text-center"> Email </th>
				<th class="text-center"> Số CMTND </th>
				<th class="text-center"> Địa chỉ </th>
				<th class="text-center"> VIP </th>
				<th class="text-center"> Xem chi tiết </th>
				<th class="text-center"> Ghi chú </th>
				<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
				<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
				$stt=0;
				while ($result = mysqli_fetch_array( $kiemtra_query )){
					$stt=$stt+1;
					$id=encode($result['ps_id']);
					$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa người này không ?')\" ";
					$sua='<a href="./index.php?ylan=khachhang&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
					$chitiet='<a href="./index.php?ylan=khachhang5&id='.$id.'"> <span class="fa fa-eye fa-1x"></span> </a>';
					$ghichu='<a href="./index.php?ylan=kh_note&id='.$id.'"> <span class="fa fa-plus fa-1x"></span> </a>';
					$xoa='<a href="./index.php?ylan=khachhang&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
					$tmp= new DateTime($result['ps_ngay_sinh']);
	        		$ngaysinh_dmy=date_format($tmp, 'd-m-Y');
	        		if($result['ps_gioi_tinh']==1 ) $gioitinh='Nam'; elseif($result['ps_gioi_tinh']==2) $gioitinh='Nữ'; else $gioitinh='';
					if(strlen($result['ps_dia_chi'])>10) $diachi=substr($result['ps_dia_chi'], 0,8).'...';
					else $diachi=$result['ps_dia_chi'];
					$danhsach=$danhsach.'<tr>
						<td class="text-center">'.$stt.'</td>
						<td>'.$result['ps_ma_so'].'</td>
						<td>'.$result['ps_ten_khach'].'</td>
						<td class="text-center">'.$gioitinh.'</td>
						<td class="text-center">'.$ngaysinh_dmy.'</td>
						<td class="text-center">'.$result['ps_don_vi'].'</td>
						<td class="text-center">'.$result['ps_dien_thoai'].'</td>
						<td class="text-center">'.$result['ps_email'].'</td>
						<td class="text-center">'.$result['ps_cmtnd'].'</td>
						<td class="text-center">'.$diachi.'</td>
						<td class="text-center">'.$result['ps_vip_rank'].'</td>
						<td class="text-center">'.$chitiet.'</td>
						<td class="text-center">'.$ghichu.'</td>
						<td class="text-center">'.$sua.' </td><td class="text-center">'.$xoa.'  </td></tr>';
				}
				$danhsach=$danhsach.'</table>';
			
				echo $danhsach;
			}
			else{
				if(isset($_GET['maso'])) echo 'Không tồn tại khách hàng có mã số '.$maso;
				else echo 'Không tồn tại Họ tên khách hàng có ký tự '.$hoten;
				

			}
		}
		else
			echo 'có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;

}

?>