<?php
function note($id){
	require './config/config.php';
	$sql='SELECT * FROM person_note WHERE pn_person='.$id.' ORDER BY pn_date ASC';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)<1){
			$danhsach='&emsp;&emsp;Không có ghi chú nào cả.';
		}
		else{
			$danhsach='';
			while ($result = mysqli_fetch_array( $query )){
				
				//$tmp= new DateTime($result['pn_date']);
        		//$ngay_dmy=date_format($tmp, 'd-m-Y');
				$danhsach=$danhsach.'&emsp;&emsp;'.$result['pn_note'].'<br>';
			}
			
		}
	}
	else{
		$danhsach="&emsp;&emsp;Có lỗi kết nối CSDL của danh sách nội dung";
	}
	return $danhsach;

} // Hết function note()
if(isset($_GET['id']) ){ //&&($_SESSION['token']==decodetoken($_GET['id']))
	//echo 'nhận ID từ GET';
	$id=decode($_GET['id']);
	$token =token();
	$_SESSION['token']=$token;
	$sql='SELECT * FROM person WHERE ps_id='.$id;
	//echo 'id='.$id.'| sql='.$sql;
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)<1){
			$error='Không có dữ liệu khách hàng';
		}
		else{
			$result=mysqli_fetch_array( $query );
			$maso=$result['ps_ma_so'];
			$hovaten=$result['ps_ten_khach'];
			$gioitinh=$result['ps_gioi_tinh'];
			$donvi=$result['ps_don_vi'];
			$ngaysinh=$result['ps_ngay_sinh'];
			$dienthoai=$result['ps_dien_thoai'];
			$email=$result['ps_email'];
			$cmtnd=$result['ps_cmtnd'];
			$diachi=$result['ps_dia_chi'];
			$vip=$result['ps_vip_rank'];
			$id=$result['ps_id'];
			$new_id=encode($id);
			// load ghi chú
			$ghichu='&nbsp;&nbsp;<a href="./index.php?ylan=kh_note&id='.$new_id.'"> <span class="fa fa-plus fa-1x"></span> </a><br>'.note($id);
			
		}
	}
	//$result=mysqli_fetch_array( $query );
}
elseif(isset($_GET['type'])){
	$token =token();
	$_SESSION['token']=$token;
	switch ($_GET['type']) {
		case '1': //đầu tiên
			//echo 'Type =1';
			$sql='SELECT * FROM person ORDER BY ps_ma_so ASC LIMIT 1';
			break;
		case '2': //lùi 1
			$sql='SELECT ps_ma_so FROM person ORDER BY ps_ma_so ASC LIMIT 1';
			$query=mysqli_query($source,$sql);
			$result=mysqli_fetch_array( $query );
			$maso=$_GET['ms']-1;
			if($maso<=$result['ps_ma_so']) $maso=$result['ps_ma_so'];
			$sql='SELECT * FROM person WHERE ps_ma_so='.$maso;
			break;
		case '3':  //tiến 1
		$sql='SELECT ps_ma_so FROM person ORDER BY ps_ma_so DESC LIMIT 1';
			$query=mysqli_query($source,$sql);
			$result=mysqli_fetch_array( $query );
			$maso=$_GET['ms']+1;
			if($maso>=$result['ps_ma_so']) $maso=$result['ps_ma_so'];
			$sql='SELECT * FROM person WHERE ps_ma_so='.$maso;
			
			break;
		default: // cuối cùng
			$sql='SELECT * FROM person ORDER BY ps_ma_so DESC LIMIT 1';
			break;
	}
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)<1){
			$error='Không có dữ liệu khách hàng';
		}
		else{
			$result=mysqli_fetch_array( $query );
			$maso=$result['ps_ma_so'];
			$hovaten=$result['ps_ten_khach'];
			$gioitinh=$result['ps_gioi_tinh'];
			$donvi=$result['ps_don_vi'];
			$ngaysinh=$result['ps_ngay_sinh'];
			$dienthoai=$result['ps_dien_thoai'];
			$email=$result['ps_email'];
			$cmtnd=$result['ps_cmtnd'];
			$diachi=$result['ps_dia_chi'];
			$vip=$result['ps_vip_rank'];
			$id=$result['ps_id'];
			$new_id=encode($id);
			$ghichu='&nbsp;&nbsp;<a href="./index.php?ylan=kh_note&id='.$new_id.'"> <span class="fa fa-plus fa-1x"></span> </a><br>'.note($id);
		}
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$maso=$_POST['maso'];
	$sql='SELECT * FROM person WHERE ps_ma_so='.$maso;
	//echo 'id='.$id.'| sql='.$sql;
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)<1){
			$error='Không có dữ liệu khách hàng';
		}
		else{
			$result=mysqli_fetch_array( $query );
			$maso=$result['ps_ma_so'];
			$hovaten=$result['ps_ten_khach'];
			$gioitinh=$result['ps_gioi_tinh'];
			$donvi=$result['ps_don_vi'];
			$ngaysinh=$result['ps_ngay_sinh'];
			$dienthoai=$result['ps_dien_thoai'];
			$email=$result['ps_email'];
			$cmtnd=$result['ps_cmtnd'];
			$diachi=$result['ps_dia_chi'];
			$vip=$result['ps_vip_rank'];
			$id=$result['ps_id'];
			$new_id=encode($id);
			$ghichu='&nbsp;&nbsp;<a href="./index.php?ylan=kh_note&id='.$new_id.'"> <span class="fa fa-plus fa-1x"></span> </a><br>'.note($id);
		}
	}
}
else{
	$token =token();
	$_SESSION['token']=$token;
}
$tieudechinh="Thông tin khách hàng";

if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/khachhang5.phtml';
?>