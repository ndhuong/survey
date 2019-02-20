<?php
require './controller/grcl_data.php';
require './controller/grcl_func.php';

if(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$kiemtra_sql="SELECT * FROM grcl WHERE (grcl_id=".$id.")";
	$kiemtra_query=mysqli_query($source,$kiemtra_sql);
	if($kiemtra_query){
		if(mysqli_num_rows( $kiemtra_query )>0)	{
			$res=mysqli_fetch_array( $kiemtra_query );
			//var_dump($res);
			for ($i=0; $i < count($grcl) ; $i++) {
				switch ($grcl[$i]['type']) {
				case '1':
				case '6':
				case '8':
				case '9':
					if(strlen($res[$grcl[$i]['sql']])>0){
						$grcl[$i]['value']=$res[$grcl[$i]['sql']];
					}
					break;
				case '2':
					if(strlen($res[$grcl[$i]['sql1']])>0){
						$grcl[$i]['value1']=$res[$grcl[$i]['sql1']];
						$grcl[$i]['readonly']=1;
						$grcl[$i]['value2']=$res[$grcl[$i]['sql2']];
					}
					break;
				case '3':
					if(strlen($res[$grcl[$i]['sql1']])>0){
						$grcl[$i]['value1']=$res[$grcl[$i]['sql1']];
					}
					if(strlen($res[$grcl[$i]['sql2']])>0){
						$grcl[$i]['value2']=$res[$grcl[$i]['sql2']];
					}
					break;
				case '5':
					if($res[$grcl[$i]['sql1']]>0){
						$grcl[$i]['value1']=$res[$grcl[$i]['sql1']];
						if(strlen($res[$grcl[$i]['sql_txt_1']])>0){
							$grcl[$i]['value_txt_1']=$res[$grcl[$i]['sql_txt_1']];
						}
					}
					if($res[$grcl[$i]['sql2']]>0){
						$grcl[$i]['value2']=$res[$grcl[$i]['sql2']];
						if(strlen($res[$grcl[$i]['sql_txt_2']])>0){
							$grcl[$i]['value_txt_2']=$res[$grcl[$i]['sql_txt_2']];
						}
					}
					break;
					
				}
				//var_dump($grcl);
			}
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
	$tieudechinh = 'Cập nhật Bảng kiểm tra phòng khách ở';
	$tieude_submit = 'cập nhật phiếu';
} elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	//header('location: index.php?ylan=grcl&ok='.json_encode('ĐÃ bấm nút Submit thành công'));
	//if($_POST['ngay_ok']>0){
		$sql_insert='';
		$sql_insert_value='';
		$sql_update='';
		$kiemtra=array();
		$k=0;
		$trap_date=0;
		$trap_room=0;
		$trap_data=0;
		for ($i=0; $i < count($grcl) ; $i++) { 
			switch ($grcl[$i]['type']) {
			case '1':
				if($_POST[$grcl[$i]['bien']]>0){
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql'];
					$sql_insert_value=$sql_insert_value.', '.$_POST[$grcl[$i]['bien']];
					$sql_update=$sql_update.', '.$grcl[$i]['sql'].'='.$_POST[$grcl[$i]['bien']];
					
					$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
					$kiemtra[$k]['type']=$grcl[$i]['type'];
					$kiemtra[$k]['value']=hoTenNguoiTruc($_POST[$grcl[$i]['bien']]);
					$k++;
				}
				break;
			
			case '9':
					if(strlen($_POST[$grcl[$i]['bien']])>0){
						$sql_insert=$sql_insert.', '.$grcl[$i]['sql'];
						$sql_insert_value=$sql_insert_value.', "'.$_POST[$grcl[$i]['bien']].'"';
						$sql_update=$sql_update.', '.$grcl[$i]['sql'].'="'.$_POST[$grcl[$i]['bien']].'"';
						$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
						$kiemtra[$k]['type']=2;
						$kiemtra[$k]['value']=date_format(date_create($_POST[$grcl[$i]['bien']]),'d-m-Y');
						$trap_date=1;
						$k++;
					}
				break;
			case '6':
			case '8':
				if(strlen($_POST[$grcl[$i]['bien']])>0){
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql'];
					$sql_insert_value=$sql_insert_value.', "'.$_POST[$grcl[$i]['bien']].'"';
					$sql_update=$sql_update.', '.$grcl[$i]['sql'].'="'.$_POST[$grcl[$i]['bien']].'"';
					$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
					$kiemtra[$k]['type']=2;
					$kiemtra[$k]['value']=$_POST[$grcl[$i]['bien']];
					$k++;
				}
				break;
			case '2':
				if(strlen($_POST[$grcl[$i]['bien1']])>0){
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql1'];
					$ngay_truc=$_POST[$grcl[$i]['bien1']];
					$sql_insert_value=$sql_insert_value.', "'.$_POST[$grcl[$i]['bien1']].'"';
					$sql_update=$sql_update.', '.$grcl[$i]['sql1'].'="'.$_POST[$grcl[$i]['bien1']].'"';
					$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
					$kiemtra[$k]['type']=$grcl[$i]['type'];
					$kiemtra[$k]['value1']=$_POST[$grcl[$i]['bien1']];
					$trap_room=1;
					
				}
				if(strlen($_POST[$grcl[$i]['bien2']])>0){
					$ca_id=substr($_POST[$grcl[$i]['bien2']],2,2);
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql2'];
					$sql_insert_value=$sql_insert_value.', '.$ca_id;
					$sql_update=$sql_update.', '.$grcl[$i]['sql2'].'='.$ca_id;
					if($trap_room==1){
						$kiemtra[$k]['value2']=tenCaTruc($ca_id);
					} else {
						$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
						$kiemtra[$k]['type']=$grcl[$i]['type'];
						$kiemtra[$k]['value2']=tenCaTruc($ca_id);
						$trap_room=1;
					}
				}	
				break;
			case '3':
				if(strlen($_POST[$grcl[$i]['bien1']])>0){
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql1'];
					$sql_insert_value=$sql_insert_value.', "'.$_POST[$grcl[$i]['bien1']].'"';
					$sql_update=$sql_update.', '.$grcl[$i]['sql1'].'="'.$_POST[$grcl[$i]['bien1']].'"';
					$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
					$kiemtra[$k]['type']=$grcl[$i]['type'];
					$kiemtra[$k]['value1']=$_POST[$grcl[$i]['bien1']];
					$trap_room=1;
					
				}

				if(strlen($_POST[$grcl[$i]['bien2']])>0){
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql2'];
					$sql_insert_value=$sql_insert_value.', "'.$_POST[$grcl[$i]['bien2']].'"';
					$sql_update=$sql_update.', '.$grcl[$i]['sql2'].'="'.$_POST[$grcl[$i]['bien2']].'"';
					if($trap_room==1){
						$kiemtra[$k]['value2']=$_POST[$grcl[$i]['bien2']];
					} else {
						$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
						$kiemtra[$k]['type']=$grcl[$i]['type'];
						$kiemtra[$k]['value2']=$_POST[$grcl[$i]['bien2']];
						$trap_room=1;
					}
				}
				if($trap_room==1) $k++;
				$trap_room=0;
				break;
			case '4':
				if($kiemtra[$k-1]['type']==4){
					$kiemtra[$k-1]['noidung']=$grcl[$i]['noidung'];
				} else{
					$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
					$kiemtra[$k]['type']=$grcl[$i]['type'];
					$k++;
				}
				break;
			case '5':
				if($_POST[$grcl[$i]['bien1']]>0){
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql1'];
					$sql_insert_value=$sql_insert_value.', '.$_POST[$grcl[$i]['bien1']];
					$sql_update=$sql_update.', '.$grcl[$i]['sql1'].'='.$_POST[$grcl[$i]['bien1']];
					if($_POST[$grcl[$i]['bien1']]==1){ // 1= giá trị NI, 2= giá trị OK
						$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
						$kiemtra[$k]['type']=$grcl[$i]['type'];
						$kiemtra[$k]['value1']=$_POST[$grcl[$i]['bien1']];
						$trap_room=1;
						$trap_data=1;
					}
					if(strlen($_POST[$grcl[$i]['bien_txt_1']])>0){
						$sql_insert=$sql_insert.', '.$grcl[$i]['sql_txt_1'];
						$sql_insert_value=$sql_insert_value.', "'.$_POST[$grcl[$i]['bien_txt_1']].'"';
						$sql_update=$sql_update.', '.$grcl[$i]['sql_txt_1'].'="'.$_POST[$grcl[$i]['bien_txt_1']].'"';
						if($_POST[$grcl[$i]['bien1']]==1) $kiemtra[$k]['value1_txt']=$_POST[$grcl[$i]['bien_txt_1']];
					}
				}
				if($_POST[$grcl[$i]['bien2']]>0){
					$sql_insert=$sql_insert.', '.$grcl[$i]['sql2'];
					$sql_insert_value=$sql_insert_value.', '.$_POST[$grcl[$i]['bien2']];
					$sql_update=$sql_update.', '.$grcl[$i]['sql2'].'='.$_POST[$grcl[$i]['bien2']];
					if($_POST[$grcl[$i]['bien2']]==1){
						if($trap_room==1){
							$kiemtra[$k]['value2']=$_POST[$grcl[$i]['bien2']];
						} else {
							$kiemtra[$k]['noidung']=$grcl[$i]['noidung'];
							$kiemtra[$k]['type']=$grcl[$i]['type'];
							$kiemtra[$k]['value2']=$_POST[$grcl[$i]['bien2']];
							$trap_room=1;
							$trap_data=1;
						}
					}
					if(strlen($_POST[$grcl[$i]['bien_txt_2']])>0){
						$sql_insert=$sql_insert.', '.$grcl[$i]['sql_txt_2'];
						$sql_insert_value=$sql_insert_value.', "'.$_POST[$grcl[$i]['bien_txt_2']].'"';
						$sql_update=$sql_update.', '.$grcl[$i]['sql_txt_2'].'="'.$_POST[$grcl[$i]['bien_txt_2']].'"';
						if($_POST[$grcl[$i]['bien2']]==1) $kiemtra[$k]['value2_txt']=$_POST[$grcl[$i]['bien_txt_2']];
					}
				}
				if($trap_room==1) $k++;
				$trap_room=0; 
				break;
			}

		} // end for($i=0; $i < count($grcl) ; $i++)
		
		
		//echo 'sql insert: '.$sql_insert.'<br>';
		//echo 'sql insert value: '.$sql_insert_value.'<br>';
		//echo 'sql UPDATE: '.$sql_update.'<br>';
		if(isset($_POST['sua'])){
			$id=decode($_POST['sua']);
			$sql_update=substr($sql_update, 1);
			$sql='UPDATE grcl SET '.$sql_update.' WHERE grcl_id="'.$id.'"';
			$nhatky='Cập nhật Guest Room Checklist ngày: '.$_POST[$grcl[1]['bien']];
		}
		else{
			if(kiemTraNgayTruc($ngay_truc,$ca_id)){
				header('location: ./modc_err&ngay="'.$ngay_truc.'"&ca='.$id_ca);
			}
			else {
				$sql_insert=substr($sql_insert, 1);
				$sql_insert_value=substr($sql_insert_value, 1);
				$sql='INSERT INTO grcl ('.$sql_insert.')  VALUES ('.$sql_insert_value.')';
				$nhatky='Tạo mới phiếu MOD Checklist ngày:'.$_POST[$grcl[1]['bien1']];
			}
		}
		//echo $sql;
		$query=mysqli_query($source,$sql);
		if ($query)
			{
				nhatky($nhatky);
				
				if($trap_data==1){
					include './controller/guiemailni.php';
					guiEmailGRCL($kiemtra);
					//var_dump($kiemtra);
				}
				
				$_SESSION['ok']='Tạo mới báo cáo Guest Room Checklist thành công. Nhập tiếp báo cáo mới.';
				header('location: ./main6&ok=1');
			}
			else $error= "Có lỗi trong quá trình nhập liệu". mysqli_error($source).'|'.$sql;
	/*	
	} else {
		header('location: index.php?ylan=grcl&err='.json_encode('Đã có bào cáo của ngày này rồi. làm lại nhé.'));
	} */
} else {
	$tieudechinh = 'Bảng liệt kê các mục cần kiểm tra';
	$tieude_submit = 'tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;	
}
$noidung=taoNoiDung($grcl);
if(isset($_GET['err'])) $error=json_decode($_GET['err']);
if(isset($_GET['ok'])) $status=json_decode($_GET['ok']);
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
include './views/grcl.phtml';
?>