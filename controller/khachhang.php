<?php
function loadVIP($name,$default='0'){
require './config/config.php';
	$danhsach_sql='SELECT * FROM vip_ranks ORDER BY vr_id ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		$tmp='<select name="'.$name.'" class="txt"> <option value="-1"> Chọn loại VIP</option>';
		while ($res = mysqli_fetch_array( $danhsach_query )){
			$tmp=$tmp.'<option value="'.$res['vr_stt'].'"';
			if($default==$res['vr_stt']) $tmp=$tmp.'selected';
			$tmp=$tmp.'> '.$res['vr_name'].' </option>';
		}
		$tmp=$tmp.'</select>';
	}
	else{
		$tmp="Có lỗi kết nối CSDL của danh sách VIP";
	}
	return $tmp;
}
//---------
function danhSach(){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM person ORDER BY ps_id DESC LIMIT 10';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có dòng nội dung nào cả, hãy tạo nội dung mới đi';
		}
		else{
			$danhsach='Danh sách 10 khách hàng mới nhập gần nhất: <br>
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
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			$stt=0;
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt=$stt+1;
				$id=encode($result['ps_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa người này không ?')\" ";
				$sua='<a href="./index.php?ylan=khachhang&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
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
					<td class="text-center">'.$sua.' </td><td class="text-center">'.$xoa.'  </td></tr>';
			}
			$danhsach=$danhsach.'</table>';
			$danhsach=$danhsach.'<br><button type="button" class="btn btn-primary btn-lg" onclick=\'window.location="index.php?ylan=khachhang3"\' > &nbsp;Xem các khách hàng khác...</button>';
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách nội dung";
	}
	return $danhsach;
} // Hết function danhSach():
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM person WHERE ps_id='.$id;
	$query=mysqli_query($source,$sql);
	$result=mysqli_fetch_array( $query );
	$sql='DELETE FROM person WHERE ps_id='.$id;
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Xóa khách hàng: '.$result['ps_ten_khach'].' | Mã số: '.$result['ps_ma_so']);
					header('location: index.php?ylan=khachhang&ok=3');
				}
				else $error= "Có lỗi trong quá trình cập nhật". mysqli_error($source).$sql;
}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])&&isset($_POST['sua'])){
	$id=decode($_POST['sua']);
	$hovaten=$_POST['hovaten'];
	$ngaysinh=$_POST['ngaysinh'];
	$gioitinh=$_POST['gioitinh'];
	$sua_sql='ps_ten_khach="'.$hovaten.'",ps_ngay_sinh="'.$ngaysinh.'",ps_gioi_tinh='.$gioitinh;
	if(!empty($_POST['donvi'])){
		$donvi=$_POST['donvi'];
		$sua_sql=$sua_sql.',ps_don_vi="'.$donvi.'"';
	}
	if(!empty($_POST['dienthoai'])){
		$dienthoai=$_POST['dienthoai'];
		$sua_sql=$sua_sql.',ps_dien_thoai="'.$dienthoai.'"';
	}
	if(!empty($_POST['email'])){
		$email=$_POST['email'];
		$sua_sql=$sua_sql.',ps_email="'.$email.'"';
	}
	if(!empty($_POST['socmtnd'])){
		$socmtnd=$_POST['socmtnd'];
		$sua_sql=$sua_sql.',ps_cmtnd="'.$socmtnd.'"';
	}
	if(!empty($_POST['diachi'])){
		$diachi=$_POST['diachi'];
		$sua_sql=$sua_sql.',ps_dia_chi="'.$diachi.'"';
	}
	if(!empty($_POST['vip'])){
		$vip=$_POST['vip'];
		$sua_sql=$sua_sql.',ps_vip_rank='.$vip;
	}

	$sql='UPDATE person SET '.$sua_sql.' WHERE ps_id='.$id;
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Cập nhật thông tin khách hàng: '.$hovaten.' | Mã số: '.$_POST['maso']);	
					header('location: index.php?ylan=khachhang&ok=2');
				}
				else $error= "Có lỗi trong quá trình cập nhật". mysqli_error($source).$sql;
		
	

}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh='Cập nhật thông tin khách hàng';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM person WHERE ps_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$maso=$result['ps_ma_so'];
		$hovaten=$result['ps_ten_khach'];
		$gioitinh=$result['ps_gioi_tinh'];
		$donvi=$result['ps_don_vi'];
		$ngaysinh=$result['ps_ngay_sinh'];
		$dienthoai=$result['ps_dien_thoai'];
		$email=$result['ps_email'];
		$socmtnd=$result['ps_cmtnd'];
		$diachi=$result['ps_dia_chi'];
		$vip=$result['ps_vip_rank'];
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$maso=$_POST['maso'];
	$hovaten=$_POST['hovaten'];
	$ngaysinh=$_POST['ngaysinh'];
	$gioitinh=$_POST['gioitinh'];
	if(!empty($_POST['donvi'])) $donvi=$_POST['donvi']; else $donvi='';
	
	if(!empty($_POST['dienthoai'])) $dienthoai=$_POST['dienthoai']; else $dienthoai=NULL;
	if(!empty($_POST['email'])) $email=$_POST['email']; else $email=NULL;
	if(!empty($_POST['socmtnd'])) $socmtnd=$_POST['socmtnd']; else $socmtnd=NULL;
	if(!empty($_POST['diachi'])) $diachi=$_POST['diachi']; else $diachi=NULL;
	if(!empty($_POST['vip'])) $vip=$_POST['vip']; else $vip=0;
	$sql='INSERT INTO person (ps_ma_so, ps_ten_khach, ps_gioi_tinh, ps_don_vi, ps_ngay_sinh, ps_dien_thoai, ps_email, ps_cmtnd, ps_dia_chi, ps_vip_rank) VALUES ('.$maso.',"'.$hovaten.'",'.$gioitinh.',"'.$donvi.'","'.$ngaysinh.'","'.$dienthoai.'","'.$email.'","'.$socmtnd.'","'.$diachi.'",'.$vip.')';
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Tạo mới khách hàng: '.$hovaten.' | Mã số: '.$maso.'| VIP '.$vip);	
					header('location: index.php?ylan=khachhang&ok=1');
				}
				else $error= "Có lỗi trong quá trình nhập liệu". mysqli_error($source).'|'.$sql;
		
	
}
else{
	$tieudechinh = 'Tạo mới thông tin khách hàng';
	$tieude_submit = 'tạo mới';
	$token =token();
	$_SESSION['token']=$token;	
	$sql='SELECT MAX(`ps_ma_so`) FROM person';
	$query=mysqli_query($source,$sql);
	if($query){
		//var_dump($query);
		$result=mysqli_fetch_array( $query );
		//var_dump($result);
		$maso=$result[0]+1;
		$ma_so_ok=1;
	}
}

 
$danhsach=danhSach();
if(isset($vip)) $loadvip=loadVIP('vip',$vip); else $loadvip=loadVIP('vip');
if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có nội dung chứ';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới Khách hàng thành công.';
	elseif($_GET['ok']==2) $status='Cập nhật khách hàng thành công.';
	elseif($_GET['ok']==3) $status='Xóa khách hàng thành công.';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
	$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/khachhang.phtml';
?>