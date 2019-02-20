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
function loadNameCreater($id){
	require './config/config.php';
	$person=array();
	$sql='SELECT log_name,log_bo_phan FROM login WHERE log_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$res=mysqli_fetch_array($query);
		$person['ten']=$res['log_name'];
		$person['dv_id']=$res['log_bo_phan'];
		$person['donvi']=loadTenDonVi($res['log_bo_phan']);
	} else {
		$person['ten']=null;
		$person['dv_id']=null;
		$person['donvi']=null;
	}
	return $person;
} // end loadNameCreater

function thongTin($value){
	return $tmp='<div class="row ">
      <div class="col-sm-2"> </div>
      <div class="col-sm-8">
        <div class="style1">
          <h3 class="tde"><span> '.$value['tieude'].' </span></h3>
        </div>
        <div class="box "><table border=0>
          <tr><td><span class="text-in-box"> ID </span></td><td>'.$value['id'].' </td></tr>
          <tr><td><span class="text-in-box"> Người tạo </span></td><td>'.$value['nguoitao'].' </td></tr>
          <tr><td><span class="text-in-box"> Ngày tạo vấn đề </span></td><td>'.$value['ngaytao'].' </td></tr>
          <tr><td><span class="text-in-box"> Mức độ ưu tiên </span></td><td>'.$value['rank'].' </td></tr>
          <tr><td><span class="text-in-box"> Vấn đề thuộc đơn vị &emsp;</span></td><td>'.$value['thuocdonvi'].' </td></tr></table>
        </div>
      </div>
    </div>';
}// hết function thongTin
function vanDe($value){
	return $tmp='<div class="row ">
      <div class="col-sm-2"> </div>
      <div class="col-sm-8">
        <div class="style1">
          <h3 class="tde"><span> '.$value['tieude2'].' </span></h3>
        </div>
        <div class="box "><table border=0>
          <tr><td><span class="text-in-box"> Tóm tắt: </span></td><td>'.$value['tomtat'].' </td></tr>
          <tr><td><span class="text-in-box"> Nội dung: </span></td><td>'.$value['noidung'].' </td></tr>
          <tr><td><span class="text-in-box"> Hình ảnh: </span></td><td>'.showImage($value['id_images']).' </td></tr>
          </table>
        </div>
      </div>
    </div>';
} // hết func vanDe
function showImage($id){
	require './config/config.php';
	$img_sql='SELECT * FROM kscl_images WHERE (kscl_img_code='.$id.') AND(kscl_img_status=1)';
	//echo '<br>'.$img_sql;
	$img_query=mysqli_query($source,$img_sql);
	if($img_query){
		if(mysqli_num_rows($img_query)>0){
			$anh='<div class="show">
						  <div class="overlay"></div>
						  <div class="img-show">
						    <span>&times; Đóng</span>
						    <img src="">
						  </div>
						</div><div class="popup">';	
			while ( $img_res = mysqli_fetch_array( $img_query )) {
				
				$anh=$anh.'<img src="'.$img_res['kscl_img_src'].'" >'.' '.$img_res['kscl_img_note'].'<br>';
			}
			$anh=$anh.'</div>
						';
		} else {
			$anh='Không có ảnh.';
		}
	}
	else{
		$anh= "Có lỗi". mysqli_error($source).$img_sql;
	}
	return $anh;
} // end show image
function fix($value){
	require './config/config.php';
	$user=$_SESSION['user_id'];
	$sql='SELECT log_bo_phan FROM login WHERE log_id='.$user;
	$query=mysqli_query($source,$sql);
	if(($query)&&(mysqli_num_rows($query)>0)){
		$res=mysqli_fetch_array($query);
		$donvi_id=$res['log_bo_phan'];
	} else $donvi_id=0;
	if($donvi_id==$value['donvi']){
		$tmp='<div class="row ">
      <div class="col-sm-2"> </div>
      <div class="col-sm-8 text-center"> <a class="submitbutton" href="index.php?ylan=kscl_fix&id='.encode($value['id']).'" > Sửa chữa vấn đề</a> </div></div><br><br>';
	} else $tmp='';
	return $tmp;
}