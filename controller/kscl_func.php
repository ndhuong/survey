<?php
function loadImg($is_img,$code,$value,$id_creater){
	require './config/config.php';
if($is_img>0){
	if($value>1) $value1=2; else $value1=1;
	$img_sql='SELECT * FROM kscl_images WHERE (kscl_img_code='.$code.') AND(kscl_img_status='.$value1.')';
	//echo '<br>'.$img_sql;
	$img_query=mysqli_query($source,$img_sql);
	if($img_query){
		if(mysqli_num_rows($img_query)>0){
			$anh='<div class="popup">';	
			while ( $img_res = mysqli_fetch_array( $img_query )) {
				$id_img=encode($img_res['kscl_img_id']);
				$them_anh='&nbsp;<a href="./index.php?ylan=kscl_img&type=1&id='.$id_img.'" data-toggle="tooltip" title="Thêm ảnh mới"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;';	
				$sua_anh='&nbsp; <a href="./index.php?ylan=kscl_img&type=2&id='.$id_img.'" data-toggle="tooltip" title="Sửa ảnh"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> &nbsp;';
				$tmp6="onclick=\"return confirm('Bạn có chắc chắn xóa ảnh này không ?')\" ";
				$xoa_anh='&nbsp; <a href="./index.php?ylan=kscl_img&type=3&id='.$id_img.'" data-toggle="tooltip" title="Xóa ảnh" '.$tmp6.'><i class="fa fa-trash-o" aria-hidden="true"></i></a> &nbsp;';
				$anh=$anh.'<img src="'.$img_res['kscl_img_src'].'" data-toggle="tooltip" title="'.$img_res['kscl_img_note'].'">'.'<br>';
				if($id_creater==$_SESSION['user_id']) $anh=$anh.$them_anh.$sua_anh.$xoa_anh;	
			}
			$anh=$anh.'</div>
						<div class="show">
						  <div class="overlay"></div>
						  <div class="img-show">
						    <span>&times;</span>
						    <img src="">
						  </div>
						</div>';
		} else {
			$anh='';
		}
	}
	else{
		echo "Có lỗi". mysqli_error($source).$img_sql;
	}
} 
elseif($value==2){
	$anh='';
} else $anh='&nbsp;<a href="./index.php?ylan=kscl_img&type=1&code='.$code.'" data-toggle="tooltip" title="Thêm ảnh mới"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;';
	return $anh;
}
function danhSach($loai=0,$batdau=0){
	// loai =1 da hoan thanh, =2 chua hoan thanh, 0 =1+2
	require './config/config.php';
	switch ($loai) {
		case '1':
			$sql='SELECT * FROM kscl WHERE kscl_status=1 ORDER BY kscl_id DESC';
			break;
		case '2':
			$sql='SELECT * FROM kscl WHERE kscl_status=2 ORDER BY kscl_id DESC';
			break;
		default:
			$sql='SELECT * FROM kscl ORDER BY kscl_id DESC';
			break;
	}
	$so_dong_hien_thi=10;
	$sql=$sql.' LIMIT '.$batdau.', '.$so_dong_hien_thi;
	$query=mysqli_query($source,$sql);
	if($query){
		$sodong=mysqli_num_rows($query);
		if($sodong<1)
		{
			$ketqua='Không có dữ liệu ';
		}
		else
		{
			//if($_SESSION['user_id'])
			$ketqua='<table class="table-striped">
			<tr><th class="text-center">ID</th>
			<th class="text-center"> Đơn vị </th>
			<th class="text-center"> Mô tả lỗi </th>
			<th class="text-center"> Ảnh lỗi</th>
			<th class="text-center"> Ảnh sửa lỗi</th>
			<th class="text-center"> Mức ưu tiên </th>
			<th class="text-center"> &emsp; Ngày tạo &emsp;</th>
			<th class="text-center"> &emsp; Hạn sửa &emsp; </th>
			<th class="text-center"> Trạng thái </th>
			<th class="text-center"> Chi tiết </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			while ( $res = mysqli_fetch_array( $query )) {
				$dv_sql='SELECT * FROM donvi WHERE dv_id='.$res['kscl_don_vi'];
				$dv_query=mysqli_query($source,$dv_sql);
				$dv_res=mysqli_fetch_array( $dv_query );
				$anh_loi=loadImg($res['kscl_img'],$res['kscl_code'],1,$res['kscl_id_creater']);
				$anh_sua_loi=loadImg($res['kscl_img'],$res['kscl_code'],2,$res['kscl_id_creater']);
				if($res['kscl_rank']==1) $rank='<a class=" btn btn-danger"> Rất quan trọng</a> ';
				elseif($res['kscl_rank']==2) $rank='<a class=" btn btn-warning"> Quan trọng</a>';
				elseif($res['kscl_rank']==3) $rank='<a class=" btn btn-secondary"> Bình thường</a>';
				else $rank='';
				if(strlen($res['kscl_date'])>0){
					$tmp= new DateTime();
        			$ngaytao=date_format($tmp, 'd-m-Y');
				} else $ngaytao='';
				if(strlen($res['kscl_deadline'])>0){
					$tmp= new DateTime();
					$hansua=date_format($tmp, 'd-m-Y');
				} else $hansua='';
        		

        		$chitiet='<a class="" href="./index.php?ylan=kscl_chitiet&id='.encode($res['kscl_id']).'"><i class="fa fa-file-text-o" aria-hidden="true"></i> </a>';
        		if($res['kscl_status']==1) $status='<a class=" btn btn-success"> Đã sửa </a>';
        		else $status='<a class=" btn btn-danger"> Chưa sửa </a>';
        		if($res['kscl_id_creater']==$_SESSION['user_id']) {
        			$newid=encode($res['kscl_id']);
        			$sua='<a class="" href="./index.php?ylan=kscl_cr&sua='.$newid.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>';
        			$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa vấn đề kiểm soát chất lượng này không ?')\" ";
        			$xoa='<a class="" href="./index.php?ylan=kscl_cr&xoa='.$newid.'" '.$tmp5.'><i class="fa fa-trash-o" aria-hidden="true"></i> </a>';
        		}
        		else {
        			$sua='';
        			$xoa='';
        		}
				$ketqua=$ketqua.'<tr><td class="text-center">'.$res['kscl_id'].'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$dv_res['dv_name'].'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$res['kscl_detail'].'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$anh_loi.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$anh_sua_loi.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$rank.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$ngaytao.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$hansua.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$status.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$chitiet.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$sua.'</td>';
				$ketqua=$ketqua.'<td class="text-center">'.$xoa.'</td>';
				$ketqua=$ketqua.'</tr>';
			}
			$ketqua=$ketqua.'</table>';
		}

	}
	else{
		echo "Có lỗi". mysqli_error($source).$sql;
	}
	
		return $ketqua;
}
