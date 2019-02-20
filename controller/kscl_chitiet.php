<?php
if(!isset($_GET['id'])){
	header('location: index.php?ylan=kscl');
}else {
	$id=decode($_GET['id']);
	$sql='SELECT * FROM kscl WHERE kscl_id='.$id;
	$query=mysqli_query($source,$sql);
	if(!$query){ 
		$error='có lỗi kết nối CSDL'.mysqli_error($source).$sql;
	} else{
		if (mysqli_num_rows($query)>0) {
			require './controller/kscl_chitiet_func.php';
			$res=mysqli_fetch_array($query);
			if($res['kscl_rank']==1) $rank='<a class=" btn btn-danger"> Rất quan trọng</a> ';
			elseif($res['kscl_rank']==2) $rank='<a class=" btn btn-warning"> Quan trọng</a>';
			elseif($res['kscl_rank']==3) $rank='<a class=" btn btn-secondary"> Bình thường</a>';
			else $rank='';
			$person=loadNameCreater($res['kscl_id_creater']);
			$thongtin=array();
			$thongtin['tieude']='Thông tin phiếu';
			$thongtin['id']=$res['kscl_id'];
			$thongtin['nguoitao']=$person['ten'];
			$thongtin['ngaytao']=date_format(date_create($res['kscl_date']),'d-m-Y');
			$thongtin['rank']=$rank;
			$thongtin['thuocdonvi']=loadTenDonVi($res['kscl_don_vi']);
			$thongtin['donvi']=$res['kscl_don_vi'];
			$noidung=thongTin($thongtin);
			$thongtin['tieude2']='Vấn đề KSCL';
			$thongtin['tomtat']=$res['kscl_detail'];
			$thongtin['noidung']=$res['kscl_detail2'];
			$thongtin['id_images']=$res['kscl_code'];
			$noidung=$noidung.vanDe($thongtin);
			$noidung=$noidung.fix($thongtin);
			//var_dump($noidung);
		}else {
			$noidung='Không có dữ liệu cần xem';
		}

	}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}

$token =token();
$_SESSION['token']=$token;
$tieudechinh='Chi tiết phiếu kiểm soát chất lượng';
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/kscl_chitiet.phtml';
}
?>