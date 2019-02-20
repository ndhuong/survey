<?php
function loadTenLoaiLinhKien(){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM loai_linh_kien order by llk_name ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		$tmp='<select name="tenloai" class="txt" onchange="load_linh_kien()"> <option value="-1"> --- Chọn loại --- </option>';
		while ( $res = mysqli_fetch_array( $danhsach_query )) {
			$tmp=$tmp.'<option value="'.$res['llk_id'].'" > &nbsp;'.$res['llk_name'].'</option>';
		}
		$tmp=$tmp.'<option value="-2" > &nbsp; ----------------- </option>';
		$tmp=$tmp.'<option value="all" > &nbsp; Tất cả các linh kiện </option>';
		$tmp=$tmp.'<option value="tot" > &nbsp; Các linh kiện Tốt</option>';
		$tmp=$tmp.'<option value="hong" > &nbsp; Các linh kiện Hỏng</option>';
		$tmp=$tmp.'</select>';
	}
	else{
		$tmp= "Có lỗi". mysqli_error($source).$sql;
	}
	return $tmp;
}// hết load tên loai link kiện


$tieudechinh='Danh sách linh kiện'
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/linhkien.phtml';
?>