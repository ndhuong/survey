<?php
function loadDonViCode($code){
	require './config/config.php';
	$sql='SELECT * FROM kscl WHERE kscl_code='.$code;
	$query=	$img_query=mysqli_query($source,$sql);
	if($query){
		$tmp='<div class="box">';
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array( $query );
			$dv_sql='SELECT * FROM donvi WHERE dv_id='.$res['kscl_don_vi'];
			$dv_query=mysqli_query($source,$dv_sql);
			$dv_res=mysqli_fetch_array( $dv_query );
			$tmp=$tmp.'<span > <b>Đơn vị:</b> '.$dv_res['dv_name'].'<br></span>';
			$tmp=$tmp.'<span > <b>Mô tả lỗi:</b> '.$res['kscl_detail'].'<br></span>';
			$tmp=$tmp.'<span > <b>Mô tả cụ thể lỗi:</b> '.$res['kscl_detail2'].'<br></span>';
		}
		else{
			$tmp=$tmp.'Không có dữ liệu';
		}
	}
	$tmp=$tmp.'</div>';
	return $tmp;
}
if (isset($_GET['type'])) {
	switch ($_GET['type']) {
		case '1': //Tạo ảnh kscl mới
			if(isset($_GET['id'])){
				$id=decode($_GET['id']);
				$img_sql='SELECT * FROM kscl_images WHERE kscl_img_id='.$id;
				$img_query=mysqli_query($source,$img_sql);
				$img_res=mysqli_fetch_array( $img_query );
				$code=$img_res['kscl_img_code'];
			}	
			elseif(isset($_GET['code'])){
				$code=$_GET['code'];

			}
			$tieudechinh='Thêm ảnh mới cho vấn đề';
			$tieude_submit='Tạo mới';
			$token =token();
			$_SESSION['token']=$token;
			$taomoi='<input type="hidden" name="code" value="'.$code.'">';
			$tieude=loadDonViCode($code);
			break;
		case '2': // sửa chữa/thay thế ảnh
			$id=decode($_GET['id']);
			$tieudechinh='Cập nhật ảnh cho vấn đề';
			$tieude_submit='Cập nhật';
			$token =token();
			$_SESSION['token']=$token;
			$img_sql='SELECT * FROM kscl_images WHERE kscl_img_id='.$id;
			$img_query=mysqli_query($source,$img_sql);
			$img_res=mysqli_fetch_array( $img_query );
			$code=$img_res['kscl_img_code'];
			$id_img=$img_res['kscl_img_id'];
			//$code=$img_res['kscl_img_code'];
			$img_old='<p>Ảnh hiện tại <br><img src="'.$img_res['kscl_img_src'].'" height="400" ><br>Ghi chú ảnh: '.$img_res['kscl_img_note'].' <br> Sửa ghi chú ảnh: <input type="text" class="text" name="ghichu_moi" value="" > </p><input type="hidden" name="code" value="'.$code.'"><input type="hidden" name="imgcode" value="'.$id_img.'"><input type="hidden" name="old_src" value="'.$img_res['kscl_img_src'].'">'; 
			break;
		case '3':

				echo 'decodetoken:'.decodetoken($_GET['id']).' Session:'.$_SESSION['token'];
			if(decodetoken($_GET['id'])==$_SESSION['token']){
				$id_img=decode($_GET['id']);
				$img_sql='SELECT * FROM kscl_images WHERE kscl_img_id='.$id_img;
				$img_query=mysqli_query($source,$img_sql);
				$img_res=mysqli_fetch_array( $img_query );
				$img_src=$img_res['kscl_img_src'];
				$img_sql='DELETE FROM kscl_images WHERE kscl_img_id='.$id_img;
				$img_query=mysqli_query($source,$img_sql);
				if($img_query){
					unlink($img_src);
					nhatky('Xóa ảnh có id='.$id_img.' | có code:'.$img_res['kscl_img_code']);
					header('location: ./index.php?ylan=kscl&ok=2');
				}
				else{
					echo"Có lỗi ". mysqli_error($source).$img_sql;
				}
			}
			break;		
		default:
			header('location: ./index.php?ylan=kscl');
			// chẳng làm gì cả
			break;
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	if(isset($_POST['imgcode'])){
		$id_img=$_POST['imgcode'];
		if(strlen($_POST['ghichu_moi'])>0){
			$ghichu=$_POST['ghichu_moi'];
			$ghichu_sql='UPDATE kscl_images SET kscl_img_note="'.$ghichu.'" WHERE kscl_img_id='.$id_img;
			$ghichu_query=mysqli_query($source,$ghichu_sql);
			if($ghichu_query){
				nhatky('Cập nhật ghi chú cho ảnh có id='.$id_img);
				header('location: ./index.php?ylan=kscl');
			}
			else{
				echo"Có lỗi ". mysqli_error($source).$ghichu_sql;
			}
		}
		else{
			$file_upload=$_FILES['images'];
			if($file_upload['error']==0){
				require './lib/image.php';
				$kscl_code=$_POST['code'];
				$old_src=$_POST['old_src'];
				$tmp1=strripos($old_src,'.');
				$old_src=substr($old_src,0,$tmp1).'_'.rand().substr($old_src,$tmp1);
				$id_img=$_POST['imgcode'];
				switch ($file_upload["type"]) {
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
				$image->load($file_upload["tmp_name"]);
				$image->resizeToWidth(1024);
				$image->save($file_upload["tmp_name"]);
				rename($file_upload["tmp_name"], $old_src);
				$ghichu=$_POST['pic_detail'];
				$ghichu_sql='UPDATE kscl_images SET kscl_img_note="'.$ghichu.'", kscl_img_src="'.$old_src.'" WHERE kscl_img_id='.$id_img;
				$ghichu_query=mysqli_query($source,$ghichu_sql);
				if($ghichu_query){
					nhatky('Cập nhật ảnh có id='.$id_img);
					header('location: ./index.php?ylan=kscl&ok=2');
				}
				else{
					echo"Có lỗi ". mysqli_error($source).$sql;
				}
			}
		}
	}
	else{
		$file_upload=$_FILES['images'];
		if(array_sum($file_upload['error'])==0){
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
			$kscl_code=$_POST['code'];
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
				$newname=$target_dir.$kscl_code.$i.rand().$extension;
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
				nhatky('cập nhật thêm ảnh cho vấn đề KSCL: '.$kscl_code);
				header('location: index.php?ylan=kscl&ok=1');
			}
		}
	}		
}

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
include './views/kscl_img.phtml'
?>