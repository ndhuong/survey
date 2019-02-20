<?php
require './controller/modc_data.php';
include './controller/mod_func.php';
for ($i=0; $i < count($mod_c) ; $i++) { 
	if($mod_c[$i]['type']==0) $mod_c[$i]['ghichu']=$mod_c[$i]['bien'].'_txt';			
}
$menu=0;

if(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	//$date=date('Y-m-d',$_GET['date']);
	$id=decode($_GET['sua']);
	$kiemtra_sql="SELECT * FROM mod_c WHERE (modc_id=".$id.")";
	$kiemtra_query=mysqli_query($source,$kiemtra_sql);
	if($kiemtra_query){
		if(mysqli_num_rows( $kiemtra_query )>0)	{
			$res=mysqli_fetch_array( $kiemtra_query );
			//var_dump($res);
			for ($i=0; $i < count($mod_c) ; $i++) {
				switch ($mod_c[$i]['type']) {
				case '0':
					if($res[$mod_c[$i]['sql']]>0) {
						$mod_c[$i]['value']=$res[$mod_c[$i]['sql']];
						$ghichu_txt='modc_'.$mod_c[$i]['ghichu'];
						if(strlen($res[$ghichu_txt])>0) $mod_c[$i]['value_txt']=$res[$ghichu_txt];
					}	
					break;
				case '1':
				case '2':
				case '3':	
					$mod_c[$i]['value']=$res[$mod_c[$i]['sql']];
					break;
				case '4':
						$mod_c[$i]['val_ngay_truc']=$res[$mod_c[$i]['sql']];
						$mod_c[$i]['value']=$res[$mod_c[$i]['sql2']];
					break;
				}
			}
			//var_dump($mod_c);
		}
		else {
			$error='lỗi không tìm thấy ngày'.date('d-m-Y',$_GET['date']);
		}
	}
	else
		$error='có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;




	$token =token();
	$_SESSION['token']=$token;
	$suachua=encode($id);
	$tieudechinh = 'Cập nhật Bảng liệt kê các mục cần kiểm tra';
	$tieude_submit = 'cập nhật phiếu';
	

	
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	//echo 'Submit là đây';
	$sql_insert='';
	$sql_insert_value='';
	$sql_update='';
	$kiemtra=array();
	$k=0;
	$flag=0;
	$flag_tieude=0;
	$flag_text=0;
	for ($i=0; $i < count($mod_c) ; $i++) {
		switch ($mod_c[$i]['type']) {
		case '0':
			if($_POST[$mod_c[$i]['bien']]>0){
				$sql_insert.=', '.$mod_c[$i]['sql'];
				$sql_insert_value.=', '.$_POST[$mod_c[$i]['bien']];
				$sql_update.=', '.$mod_c[$i]['sql'].'='.$_POST[$mod_c[$i]['bien']];
				if(strlen($_POST[$mod_c[$i]['ghichu']])>0){
					$sql_insert.=', modc_'.$mod_c[$i]['ghichu'];
					$sql_insert_value.=', "'.$_POST[$mod_c[$i]['ghichu']].'"';
					$sql_update.=', modc_'.$mod_c[$i]['ghichu'].'="'.$_POST[$mod_c[$i]['ghichu']].'"';
				}
				//-------------------
				if($_POST[$mod_c[$i]['bien']]==1){
					$kiemtra[$k]['type']=1;// dòng tiêu đề phụ
					$kiemtra[$k]['noidung']=$mod_c[$i]['noidung'];
					if(strlen($_POST[$mod_c[$i]['ghichu']])>0) $kiemtra[$k]['ghichu']=$_POST[$mod_c[$i]['ghichu']];
					else $kiemtra[$k]['ghichu']='';

					$k++;
					$flag=1;
					$trap=1;
					$flag_tieude=1;
				}
			}
			break;
		case '1':
			if($flag_tieude>0){ 
				$kiemtra[$k]['noidung']=$mod_c[$i]['noidung'];
				$kiemtra[$k]['type']=2; // tiêu đề chính
				$flag_tieude=0;
				$k++;
			}
			else{
				if($k==2) $k++;
				$kiemtra[$k-1]['noidung']=$mod_c[$i]['noidung'];
				$kiemtra[$k-1]['type']=2; // tiêu đề chính
				
			}
		case '2':
			if(strlen($_POST[$mod_c[$i]['bien']])>0){
					$sql_insert.=', '.$mod_c[$i]['sql'];
					$sql_insert_value.=', "'.$_POST[$mod_c[$i]['bien']].'"';
					$sql_update.=', '.$mod_c[$i]['sql'].'="'.$_POST[$mod_c[$i]['bien']].'"';
					
					if(($kiemtra[$k-1]['type']==2)&&($flag_text<1)){
						$k--;
						$kiemtra[$k]['noidung']='<b>'.$mod_c[$i]['noidung'].'</b>';
						$kiemtra[$k]['type']=2; // tiêu đề chính
						$kiemtra[$k]['ghichu']=$_POST[$mod_c[$i]['bien']];
						$k++;
						$flag_text=2;
					} else {
						$kiemtra[$k]['noidung']='<b>'.$mod_c[$i]['noidung'].'</b>';
						$kiemtra[$k]['type']=1; // tiêu đề chính
						$kiemtra[$k]['ghichu']=$_POST[$mod_c[$i]['bien']];
						$k++;
					}

					
				}
			break;
		case '3':
			
			if(strlen($_POST[$mod_c[$i]['bien']])>0){
				$sql_insert.=$mod_c[$i]['sql'];
				$sql_insert_value.=$_POST[$mod_c[$i]['bien']];
				$sql_update.=$mod_c[$i]['sql'].'='.$_POST[$mod_c[$i]['bien']];

				$kiemtra[$k]['noidung']=$mod_c[$i]['noidung'];
				$kiemtra[$k]['type']=3; // tiêu đề chính
				$kiemtra[$k]['value']=hoTenNguoiTruc($_POST[$mod_c[$i]['bien']]); 
				$k++;
			}
			break;
		case '4':
				$sql_insert.=', '.$mod_c[$i]['sql'];
				$sql_insert_value.=', "'.$_POST[$mod_c[$i]['bien']].'"';
				$sql_update.=', '.$mod_c[$i]['sql'].'="'.$_POST[$mod_c[$i]['bien']].'"';
				$sql_insert.=', '.$mod_c[$i]['sql2'];
				$id_ca=(int)substr($_POST[$mod_c[$i]['bien2']],2,2);
				$sql_insert_value.=', '.$id_ca;
				$sql_update.=', '.$mod_c[$i]['sql2'].'='.$id_ca;
				$ngay_truc=$_POST[$mod_c[$i]['bien']];

				$kiemtra[$k]['noidung']='Ngày trực ';
				$kiemtra[$k]['type']=3;
				$tmp4=date_create($_POST[$mod_c[$i]['bien']]);
				$kiemtra[$k]['value']=date_format($tmp4,'d-m-Y');
				$k++;
			break;	
		}
	}// hết for duyệt nhập dữ liệu từ form
	
		if(isset($_POST['sua'])){
			$id=decode($_POST['sua']);
			$sql='UPDATE mod_c SET '.$sql_update.' WHERE modc_id="'.$id.'"';
			$nhatky='Cập nhật MOD Checklist ngày: '.$_POST[$mod_c[1]['bien']];
		}
		else{
			if(kiemTraNgayTruc($ngay_truc,$id_ca)){
				header('location: ./modc_err&ngay="'.$ngay_truc.'"&ca='.$id_ca);
			}
			else {
				$sql='INSERT INTO mod_c ('.$sql_insert.')  VALUES ('.$sql_insert_value.')';
				$nhatky='Tạo mới phiếu MOD Checklist ngày:'.$_POST[$mod_c[1]['bien']];
			}
		}
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky($nhatky);	
				// 
					if($flag>0) {
						include './controller/guiemailni.php';
						guiEmailMODC($kiemtra);
						//var_dump($kiemtra);
					}
					header('location: ./main6&ok=1');
				}
				else $error= "Có lỗi trong quá trình nhập liệu". mysqli_error($source).'|'.$sql;
		

	
	
	// đoạn này thêm vào chỉ để test 
	echo $sql_update,'<br>'.$sql_insert.'<br>'.$sql_insert_value;
	$tieudechinh = 'Bảng liệt kê các mục cần kiểm tra';
	$tieude_submit = 'tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;
	
}

else{
	$tieudechinh = 'Bảng liệt kê các mục cần kiểm tra';
	$tieude_submit = 'tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;
		

}

//$mod_c[1]['val_ngay_truc']="2018-09-18";
//$mod_c[1]['readonly']=1;
$noidung='';
for ($i=0; $i < count($mod_c) ; $i++) { 
	switch ($mod_c[$i]['type']) {
		case '0':
			$noidung=$noidung.okNi($mod_c[$i]);	
			break;
		case '1':
			$noidung=$noidung.tieuDe($mod_c[$i]);
			break;
		case '2':
			$noidung=$noidung.noiDungText($mod_c[$i]);
			break;
		case '3':
			$noidung=$noidung.nguoiTruc2();
			break;
		case '4':
			$noidung=$noidung.ngayTruc2();
			break;	
	}
}		
$noidung=$noidung.'<div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-6  text-center ">
                <br>
                 <input type="submit" class="submitbutton" value="'.$tieude_submit.'" name="submit" > 
                 <p></p>
            </div>
        </div>';
if(isset($error)){
		$error="<div class='alert alert-danger text-center'>".$error." </div>" ;
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
include './views/modc.phtml';
?>