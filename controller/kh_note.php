<?php
function note($id){
	require './config/config.php';
	$sql='SELECT * FROM person_note WHERE pn_person='.$id.' ORDER BY pn_date ASC';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)<1){
			$danhsach='Chưa có dòng ghi chú nào cả, hãy tạo ghi chú đi';
		}
		else{
			$danhsach='Các ghi chú về khách: <br>
			<table class="table-striped">
			<tr>
			<th class="text-center"> Ngày/tháng </th>
			<th class="text-center"> Nội dung ghi chú </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			while ($result = mysqli_fetch_array( $query )){
				$id=encode($result['pn_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa ghi chú này không ?')\" ";
				$sua='<a href="./index.php?ylan=kh_note&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./index.php?ylan=kh_note&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				$tmp= new DateTime($result['pn_date']);
        		$ngay_dmy=date_format($tmp, 'd-m-Y');
				$danhsach=$danhsach.'<tr>
					<td class="text-center">'.$ngay_dmy.'</td>
					<td>'.$result['pn_note'].'</td>
					<td class="text-center">'.$sua.' </td>
					<td class="text-center">'.$xoa.'  </td></tr>';
			}
			$danhsach=$danhsach.'</table>';
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách nội dung";
	}
	return $danhsach;

} // Hết function note()
function guest($id){
	require './config/config.php';
	
	$sql='SELECT * FROM person WHERE ps_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)<1){
			$khach='Không có dữ liệu khách hàng';
		}
		else{
			$result=mysqli_fetch_array( $query );
			if($result['ps_gioi_tinh']==1) $gioitinh='Nam'; elseif($result['ps_gioi_tinh']==2) $gioitinh='Nữ'; else $gioitinh='';
			$tmp= new DateTime($result['ps_ngay_sinh']);
		    $ngaysinh_dmy=date_format($tmp, 'd-m-Y');
			$khach='<div class="row ">
				<div class="col-sm-12 text-center">
				<div class="package brilliant">
			    <div class="name">'.$result['ps_ten_khach'].' </div>
			    <div class="vip">'.$result['ps_vip_rank'].' </div>
			    <hr>
			    <ul>
			    	<li>
			    	    <span class="maso">'.$result['ps_ma_so'].' </span> 
			        	<span class="cmtnd"> '.$result['ps_cmtnd'].'</span>
			      	</li>
			      	<li>
			        	<span class="ngaysinh">'.$ngaysinh_dmy.' </span> 
			        	<span class="gioitinh">'.$gioitinh.' </span>
			      	</li>
			      	<li>
			        	<span class="dienthoai">'.$result['ps_dien_thoai'].'</span> 
			        	<span class="email">'.$result['ps_email'].' </span>
			      	</li>
			      	<li>
			        	<span class="diachi"> '.$result['ps_dia_chi'].'</span>
				    </li>
				    <li>
			        	<span class="donvi">'.$result['ps_don_vi'].' </span>
			      </li>
			    </ul>
			  </div>
			</div>
			</div>';
		}
	}

	return $khach;
} // Hết function Guest

if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM person_note WHERE pn_id='.$id;
	$query=mysqli_query($source,$sql);
	$result=mysqli_fetch_array( $query );
	$sql='DELETE FROM person_note WHERE pn_id='.$id;
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Xóa ghi chú về khách hàng: id khách='.$result['pn_person'].' |'.$result['pn_date'].' | ghi chú: '.$result['pn_note']);
					header('location: index.php?ylan=kh_note&ok=3&id='.encode($result['pn_person']));
				}
				else $error= "Có lỗi trong quá trình cập nhật". mysqli_error($source).$sql;
}
elseif(isset($_GET['id'])&&($_SESSION['token']==decodetoken($_GET['id'])) ){
	$token =token();
	$_SESSION['token']=$token;
	$id=decode($_GET['id']);
	$khach=guest($id);
	$noidungghichu=note($id);
	$khachhang=encode($id);
	//if(isset($_GET))
	$tieudechinh='Ghi chú về khách hàng';
	$tieude_submit='Tạo mới';
}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh='cập nhật ghi chú về khách hàng';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM person_note WHERE pn_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$noidung=$result['pn_note'];
		$ngaythang=$result['pn_date'];
		$khachhang=encode($result['pn_person']);

	}
	else{
		header('location: index.php?ylan=kh_note&err=2');
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$khachhang=decode($_POST['khachhang']);
	$noidung=$_POST['noidung'];
	$ngaythang=$_POST['ngaythang'];
	$token =token();
	$_SESSION['token']=$token;

	if(isset($_POST['sua'])){
		$id=decode($_POST['sua']);
		$sql='UPDATE person_note SET pn_date="'.$ngaythang.'", pn_note="'.$noidung.'" WHERE pn_id='.$id;
		$nhatky='Cập nhật ghi chú về khách ID='.$khachhang.' | Nội dung: '.$noidung;
		$ok=2;
	}
	else{
		$sql='INSERT INTO person_note (pn_date, pn_note, pn_person) VALUES ("'.$ngaythang.'","'.$noidung.'",'.$khachhang.')';
		$nhatky='Tạo mới ghi chú về khách hàng: ID='.$khachhang.' | Nội dung: '.$noidung;
		$ok=1;
	}
	
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky($nhatky);	
					header('location: index.php?ylan=kh_note&ok='.$ok.'&id='.encode($khachhang));
				}
				else $error= "Có lỗi trong quá trình nhập liệu". mysqli_error($source).'|'.$sql;
}
else{
	$tieudechinh = 'Khách hàng';
	$tieude_submit = 'tạo mới';
	$token =token();
	$_SESSION['token']=$token;	
}
if(!isset($ngaythang))  $ngaythang=date("Y-m-d");
if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có nội dung chứ';
	if($_GET['err']==2) $error='Lỗi không tìm thấy ghi chú';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới ghi chú thành công.';
	elseif($_GET['ok']==2) $status='Cập nhật ghi chú thành công.';
	elseif($_GET['ok']==3) $status='Xóa ghi chú thành công.';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/kh_note.phtml';
?>