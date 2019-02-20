<?php
 function loadTenDonVi($id=0){
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
} // Hết function loadDanhSachDonVi()
//---------------------------------------- 
checkadmin();

$token =token();
$_SESSION['token']=$token;

if(isset($_GET['ok'])) $status="<div class='alert alert-success text-center'> Tạo người sử dụng thành công.</div>" ;
if(isset($_GET['ok2'])) $status="<div class='alert alert-success text-center'> Cập nhật thông tin người sử dụng thành công.</div>" ;
if(isset($_GET['d'])) $status= "<div class='alert alert-success text-center'> Xóa người sử dụng thành công.</div>" ;           

$danhsach="<table class='table table-striped table-bordered'>
<tr>
<th><span class='fa fa-user fa-1x'></span> - Tên người dùng </th>
<th><span class='fa fa-sign-in fa-1x'></span> - Tên đăng nhập </th>
<th><span class='fa fa-adn fa-1x'></span> - Admin </th>
<th><span class='fa fa-key fa-1x'></span> - Quản lý </th>
<th><span class='fa fa-university'></span> - Bộ Phận </th>
<th><span class='fa fa-pencil fa-1x'></span> - Sửa </th>
<th><span class='fa fa-repeat fa-1x'></span> - Đặt mật khẩu </th>
<th><span class='fa fa-trash fa-1x'></span> - Xóa </th>
</tr>'";
 
$sql='SELECT * FROM login ORDER BY log_bo_phan DESC';
$query=mysqli_query($source,$sql);
while ($result = mysqli_fetch_array( $query )){
		$danhsach=$danhsach.'<tr> <td class="text-left">'.$result["log_name"].'</td><td class="text-left">'.$result["log_user"].'</td>';
		if($result['log_admin']>0) 
			$danhsach=$danhsach.'<td class="text-center"><span class="fa fa-check fa-1x"></span></td>';
		else 
			$danhsach=$danhsach. '<td></td>';
		if($result['log_admin2']>0) 
			$danhsach=$danhsach. '<td class="text-center"><span class="fa fa-check fa-1x"></span></td>';
		else 
			$danhsach=$danhsach. '<td></td>';
		$danhsach=$danhsach. '<td>'.loadTenDonVi($result['log_bo_phan']).'</td>';
		$new_id=encode($result["log_id"]);
		$danhsach=$danhsach. '<td class="text-center"> <a href="./index.php?ylan=user&sua='.$new_id.'"> <span class="fa fa-pencil fa-1x"></span> </a></td>';
		$danhsach=$danhsach. '<td class="text-center"> <a href="./index.php?ylan=user&reset='.$new_id.'"> <span class="fa fa-repeat fa-1x"></span> </a></td>';
		$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa người nhận mail này không ?')\" ";
		$xoa='<a href="./index.php?ylan=user&xoa='.$new_id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
		$danhsach=$danhsach. '<td class="text-center">'.$xoa.'</td>';
		$danhsach=$danhsach. '</tr>';	
	}

$danhsach=$danhsach.'</table>';
$tieudechinh='Quản lý người dùng';
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/user_ql.phtml';
?>