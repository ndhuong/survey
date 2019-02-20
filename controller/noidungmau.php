<?php
function danhSach(){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM noidungkhaosat ORDER BY nd_stt ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có dòng nội dung nào cả, hãy tạo nội dung mới đi';
		}
		else{
			$danhsach='<table class="table-striped">
			<tr><th class="text-center">STT</th>
			<th class="text-center"> Nội dung </th>
			<th class="text-center"> Loại dữ liệu </th>
			<th class="text-center"> Tên biến </th>
			<th class="text-center"> Tên SQL </th>
			<th class="text-center"> Nhà hàng </th>
			<th class="text-center"> Lễ tân </th>
			<th class="text-center"> Kinh doanh </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center"> <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt=$result['nd_stt'];
				if($result['nd_loai']==1) $tmp= ' Câu trả lời văn bản chữ';
				elseif($result['nd_loai']==2) $tmp= ' Câu trả lời Có / Không ';
				elseif($result['nd_loai']==3) $tmp= ' Câu trả lời lựa chọn 5->1';
				elseif($result['nd_loai']==4) $tmp= ' Tiêu đề chính';
				elseif($result['nd_loai']==5) $tmp= ' Tiêu đề phụ';
				elseif($result['nd_loai']==6) $tmp= ' Dòng số phiếu';
				elseif($result['nd_loai']==7) $tmp= ' Dòng ngày khảo sát';
				else $tmp='';

				$id=encode($result['nd_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa người nhận mail này không ?')\" ";
				$sua='<a href="./index.php?ylan=noidungmau&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./index.php?ylan=noidungmau&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				if($result['nd_nhahang']>0) $nhahang='NH'; else $nhahang='';
				if($result['nd_kinhdoanh']>0) $kinhdoanh='KD'; else $kinhdoanh='';
				if($result['nd_letan']>0) $letan='LT'; else $letan='';
				$danhsach=$danhsach.'<tr><td class="text-center">'.$stt.'</td><td>'.$result['nd_noidung'].'</td><td>'.$tmp.'</td><td>'.$result['nd_ten_bien'].'</td><td>'.$result['nd_ten_sql'].'</td><td>'.$nhahang.'</td><td>'.$letan.'</td><td>'.$kinhdoanh.'</td><td class="text-center">'.$sua.' </td><td class="text-center">'.$xoa.'  </td></tr>';
			}
			$danhsach=$danhsach.'</table>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách nội dung";
	}
	return $danhsach;
} // Hết function danhSach():
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){

}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])&&isset($_POST['sua'])){
	$id=decode($_POST['sua']);
	$noidung=$_POST['noidung'];
	$loai=$_POST['loai'];
	$tentruong=$_POST['tentruong'];
	$stt=$_POST['stt'];
	$tensql=$_POST['tensql'];

	if(!empty($_POST['nhahang'])) $nhahang=1; else $nhahang=0;
	if(!empty($_POST['letan'])) $letan=1; else $letan=0;
	if(!empty($_POST['kinhdoanh'])) $kinhdoanh=1; else $kinhdoanh=0;
	// $tmp= 'Nhà hàng:'.$nhahang.'-'.$_POST['nhahang'].'Lễ tân:'.$letan.'-'.$_POST['letan'].'Kinh doanh:'.$kinhdoanh.'-'.$_POST['kinhdoanh'];
	if((strlen($noidung)<1) || ($loai <0)){
		header('location: index.php?ylan=noidungmau&sua='.$id.'&err=1');
	}
	else{
		$sql='UPDATE noidungkhaosat SET nd_noidung="'.$noidung.'",nd_loai='.$loai.',nd_ten_bien="'.$tentruong.'",nd_stt='.$stt.' ,nd_ten_sql="'.$tensql.'",nd_nhahang='.$nhahang.',nd_letan='.$letan.',nd_kinhdoanh='.$kinhdoanh.' WHERE nd_id='.$id;
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Cập nhật Nội dung khảo sát: '.$noidung.' - Loại'.$loai.' - tên trường'.$tentruong);	
					header('location: index.php?ylan=noidungmau&ok=1');
				}
				else $error= "Có lỗi trong quá trình cập nhật". mysqli_error($source).$sql;
		
	}

}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh='cập nhật nội dung khảo sát';
	$tieude_submit='Cập nhật';
	$sql='SELECT * FROM noidungkhaosat WHERE nd_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$result=mysqli_fetch_array( $query );
		$stt=$result['nd_stt'];
		$noidung=$result['nd_noidung'];
		$loai=$result['nd_loai'];
		$tentruong=$result['nd_ten_bien'];
		$tensql=$result['nd_ten_sql'];
		$nhahang=$result['nd_nhahang'];
		$letan=$result['nd_letan'];
		$kinhdoanh=$result['nd_kinhdoanh'];
	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$noidung=$_POST['noidung'];
	$loai=$_POST['loai'];
	$tentruong=$_POST['tentruong'];
	$stt=$_POST['stt'];
	$tensql=$_POST['tensql'];
	if(!empty($_POST['nhahang'])) $nhahang=1; else $nhahang=0;
	if(!empty($_POST['letan'])) $letan=1; else $letan=0;
	if(!empty($_POST['kinhdoanh'])) $kinhdoanh=1; else $kinhdoanh=0;
	if((strlen($noidung)<1) || ($loai <0) || ($_POST['sttok']<0) ){
		header('location: index.php?ylan=noidungmau&err=1');
	}
	else{
		$sql='INSERT INTO noidungkhaosat (nd_noidung,nd_loai,nd_ten_bien,nd_stt,nd_ten_sql,nd_nhahang,nd_letan,nd_kinhdoanh) VALUES ("'.$noidung.'",'.$loai.',"'.$tentruong.'",'.$stt.',"'.$tensql.'",'.$nhahang.','.$letan.','.$kinhdoanh.')';
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Tạo mới Nội dung khảo sát: '.$noidung.' - Loại'.$loai.' - tên trường'.$tentruong);	
					header('location: index.php?ylan=noidungmau&ok=1');
				}
				else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source).'|'.$sql;
		
	}
}
else{
	$tieudechinh = 'Nội dung Phiếu khảo sát khách hàng';
	$tieude_submit = 'tạo ';
	$token =token();
	$_SESSION['token']=$token;	
	$sql='SELECT MAX(`nd_stt`) FROM noidungkhaosat';
	$query=mysqli_query($source,$sql);
	if($query){
		//var_dump($query);
		$result=mysqli_fetch_array( $query );
		//var_dump($result);
		$stt=$result[0]+1;
		$stt_ok=1;
	}
}

 
$danhsach=danhSach();

if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có nội dung, loại dữ liệu, tên trường chứ';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới nội dung khảo sát thành công.';
}
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
	}
if(isset($status)){
		$status="<div class='alert alert-success text-center'>".$status." </div>" ;
	}
include './views/noidungmau.phtml';
?>