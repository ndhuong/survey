<?php
function loadDanhSachDonVi($name='donvi',$default=0){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi ORDER BY dv_name ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có đơn vị nào cả, hãy tạo đơn vị mới đi';
		}
		else{
			$danhsach='<select name="'.$name.'" class="txt" required> <option value="-1"> &darr; Chọn đơn vị &darr; </option>';
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

//----------------------------------------
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM kscl WHERE kscl_id='.$id;
	$query=mysqli_query($source,$sql);
	$result=mysqli_fetch_array( $query );
	$sql='DELETE FROM kscl WHERE kscl_id='.$id;
	$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Xóa vấn đề KSCL: id='.$result['kscl_id'].' |code '.$result['kscl_code'].' | Mô tả: '.$result['kscl_detail2']);
					
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
	$tieudechinh='cập nhật vấn đề KSCL';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM kscl WHERE kscl_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$tomtat=$result['kscl_detail'];
		$donvi=$result['kscl_don_vi'];
		$loailoi=$result['kscl_rank'];
		$ngaykhoitao=$result['kscl_date'];
		//$deadline=$result['kscl_deadline'];
		$motaloi=$result['kscl_detail2'];
		//$image=$result['kscl_img'];
		$sua=encode($result['kscl_id']);
		if($result['kscl_img']>0){
			$img_sql='SELECT * FROM kscl_images WHERE kscl_img_code='.$result['kscl_code'];
			$img_query=mysqli_query($source,$img_sql);
			if($img_query){
				$anh='';

				while ( $img_res = mysqli_fetch_array( $img_query )) {
					$anh=$anh.'<img src="'.$img_res['kscl_img_src'].'" data-toggle="tooltip" title="'.$img_res['kscl_img_note'].'" width="100" height="100"> &nbsp;';
					
				}
				$anh=$anh.'&nbsp; <a href="./index.php?ylan=kscl_img&type=4&id='.$img_res['kscl_img_code'].'" data-toggle="tooltip" title="Cập nhật ảnh"> Thêm/ sửa / xóa </a> &nbsp; ';
			}
			else{
				echo "Có lỗi". mysqli_error($source).$img_sql;
			}
		}
		else $anh='Bấm vào đây để thêm ảnh..';
	}
	else{
		header('location: index.php?ylan=kscl_cr&err=2');
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$tomtat=$_POST['tomtat'];
	$donvi=$_POST['donvi'];
	$loailoi=$_POST['loailoi'];
	$ngaykhoitao=$_POST['ngaykhoitao'];
	//$deadline=$_POST['deadline'];
	$motaloi=$_POST['motaloi'];
	$id=decode($_POST['sua']);
	if(isset($_POST['sua'])){
		$sql='UPDATE kscl SET kscl_detail="'.$tomtat.'", kscl_don_vi='.$donvi.', kscl_rank='.$loailoi.', kscl_date="'.$ngaykhoitao.'", kscl_detail2="'.$motaloi.'" WHERE kscl_id='.$id;
		$query=mysqli_query($source,$sql);
		if($query){
			nhatky('Cập nhật KSCL- ID: '.$id);
			header('location: index.php?ylan=kscl&ok=2');
		}
		else{
			echo"Có lỗi ". mysqli_error($source).$sql;
		}
	}
	else {
		$file_upload=$_FILES['images'];
		$kscl_code=strtotime('now');
		$token =token();
		$_SESSION['token']=$token;
		// thêm 2 dong này để test, 
		$tieudechinh="Tạo mới";
		$tieude_submit='Tạo mới';
		$user_id=$_SESSION['user_id'];
		$sql='INSERT INTO kscl (kscl_code, kscl_detail,kscl_date,  kscl_don_vi, kscl_detail2, kscl_id_creater, kscl_status, kscl_rank) VALUES ('.$kscl_code.',"'.$tomtat.'","'.$ngaykhoitao.'",'.$donvi.',"'.$motaloi.'",'.$user_id.',2,'.$loailoi.')';
		$query=mysqli_query($source,$sql);
		if($query){
		//var_dump($file_upload);
			if(array_sum($file_upload['error'])==0){
				//require './lib/image.php';
				$file_count=count($file_upload['name']);
				if (!is_dir("./uploads/".date('Y').'/')){
		   			//Tạo thư mục là năm  nếu chưa có
					mkdir("uploads/".date('Y').'/');
					$target_dir = "./uploads/".date('Y').'/';
				}
				else {
					$target_dir = "./uploads/".date('Y').'/';
				}
				require './lib/image.php';
				$note=$_POST['pic_detail'];
				$img_ok=0;
				for ($i=0; $i < $file_count; $i++) { 
					//echo 'Ảnh thứ '.$i+1;
					switch ($file_upload["type"][$i]) {
							case 'image/gif':
									$extension='.gif';
								break;
							case 'image/jpeg':
							case 'image/jpg':
									$extension='.jpg';
								break;
							case 'image/png':
									$extension='.png';
								break;
							default:
								$extension='';
								break;
							}		
						$image = new SimpleImage();
						$image->load($file_upload["tmp_name"][$i]);
						$image->resizeToWidth(1024);
						$image->save($file_upload["tmp_name"][$i]);
						$newname=$target_dir.$kscl_code.$i.$extension;
						rename($file_upload["tmp_name"][$i], $newname);

						$img_sql='INSERT INTO kscl_images (kscl_img_code, kscl_img_note,kscl_img_src, kscl_img_status) VALUES ('.$kscl_code.',"'.$note[$i].'","'.$newname.'",1)';
						$img_query=mysqli_query($source,$img_sql);
						if($img_query){
							$img_ok++;
						}
				}
				if($img_ok>0){
					$sql='UPDATE kscl SET kscl_img=1 WHERE kscl_code='.$kscl_code;
					$query=mysqli_query($source,$sql);
				}

			}
			else{
				//var_dump($file_upload);
			}
		// quay trở lại trang tổng hợp sau khi đã tạo mới xong.
			nhatky('Tạo mới KSCL- Code: '.$kscl_code);
			header('location: index.php?ylan=kscl&ok=1');
		}
		else{
			echo"Có lỗi ". mysqli_error($source).$sql;
			//header('location: index.php?ylan=kscl_cr&err=2');
		}

	}
	
}
else{
	$tieudechinh="Tạo mới";
	$tieude_submit='Tạo mới';
	$token =token();
	$_SESSION['token']=$token;	
}


if(isset($error)) $error="<div class='alert alert-danger text-center'>".$error." </div>" ;
if(isset($status))	$status="<div class='alert alert-success text-center'>".$status." </div>" ;
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='kscl';
$arr['1']['name']='Kiểm soát chất lượng';
$arr['1']['active']=0;
$arr['2']['stt']=2;
$arr['2']['link']='';
$arr['2']['name']=$tieudechinh;
$arr['2']['active']=1;
include './views/kscl_cr.phtml';
?>