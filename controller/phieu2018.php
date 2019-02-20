<?php
include './controller/noidungmau3.php';
include './controller/phieu2018_func.php';
if(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$tieudechinh = 'Cập nhật Phiếu khảo sát khách hàng';
	$tieude_submit = 'cập nhật phiếu';
	$sql= 'SELECT * FROM khaosat2018 WHERE ks18_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$res = mysqli_fetch_array( $query );
		// load nội dung mẫu
		$sophieu=$res['ks18_so_phieu'];
		$ngay_khao_sat=$res['ks18_ngay_khao_sat'];
		if(strlen($res['ks18_ten_doan_khach'])>0) $ten_doan_khach=$res['ks18_ten_doan_khach'];
		if($res['ks18_muc_dich']>0) $mucdich=$res['ks18_muc_dich'];
		if(strlen($res['ks18_muc_dich_txt'])>0) $mucdich_txt=$res['ks18_muc_dich_txt'];
		if($res['ks18_ly_do']>0) $lydo=$res['ks18_ly_do'];
		if($res['ks18_kenh_dat_phong']>0) $kenhdatphong=$res['ks18_kenh_dat_phong'];
		if(strlen($res['ks18_kenh_dat_phong_txt'])>0) $kenhdatphong_txt=$res['ks18_kenh_dat_phong_txt'];
		if($res['ks18_danh_gia_chung']>0) $danhgiachung=$res['ks18_danh_gia_chung'];
		if($res['ks18_dat_phong']>0) $datphong=$res['ks18_dat_phong'];
		if($res['ks18_checkin']>0) $checkin=$res['ks18_checkin'];
		if($res['ks18_checkout']>0) $checkout=$res['ks18_checkout'];
		if($res['ks18_dich_vu_hanh_ly']>0) $dichvuhanhly=$res['ks18_dich_vu_hanh_ly'];
		if($res['ks18_ve_sinh']>0) $vesinh=$res['ks18_ve_sinh'];
		if($res['ks18_tien_nghi']>0) $tiennghi=$res['ks18_tien_nghi'];
		if($res['ks18_an_sang']>0) $ansang=$res['ks18_an_sang'];
		if($res['ks18_thai_do']>0) $thaido=$res['ks18_thai_do'];
		if($res['ks18_van_de_dat_phong']>0) $vandedatphong=$res['ks18_van_de_dat_phong'];
		if($res['ks18_van_de_checkin']>0) $vandecheckin=$res['ks18_van_de_checkin'];
		if($res['ks18_van_de_checkout']>0) $vandecheckout=$res['ks18_van_de_checkout'];
		if($res['ks18_van_de_ve_sinh']>0) $vandevesinh=$res['ks18_van_de_ve_sinh'];
		if($res['ks18_cooling']>0) $cooling=$res['ks18_cooling'];
		if($res['ks18_internet']>0) $internet=$res['ks18_internet'];
		if($res['ks18_am_thuc']>0) $amthuc=$res['ks18_am_thuc'];
		if($res['ks18_hoa_don']>0) $hoadon=$res['ks18_hoa_don'];
		if($res['ks18_nhan_vien']>0) $nhanvien=$res['ks18_nhan_vien'];
		if($res['ks18_van_de_khac']>0) $vandekhac=$res['ks18_van_de_khac'];
		if(strlen($res['ks18_van_de_khac_txt'])>0) $vandekhac_txt=$res['ks18_van_de_khac_txt'];
		if($res['ks18_cach_giai_quyet']>0) $cachgiaiquyet=$res['ks18_cach_giai_quyet'];
		if(strlen($res['ks18_nhan_xet'])>0) $nhanxet=$res['ks18_nhan_xet'];

	}
}
elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	
	$sophieu=$_POST['sophieu'];
	$s1='ks18_so_phieu';
	$s2=$sophieu;
	$ngay_khao_sat=$_POST['ngaynhap'];
	$s1=$s1.',ks18_ngay_khao_sat';
	$s2=$s2.',"'.$ngay_khao_sat.'"';
	$s3='ks18_ngay_khao_sat="'.$ngay_khao_sat.'"';
	$ten_doan_khach=$_POST['ten_doan_khach'];
	$s1=$s1.',ks18_ten_doan_khach';
	$s2=$s2.',"'.$ten_doan_khach.'"';
	$s3='ks18_ngay_khao_sat="'.$ten_doan_khach.'"';
	if(isset($_POST['mucdich'])){
		if(isset($_POST['mucdich_txt']) && (strlen($_POST['mucdich_txt'])>0)){
			$mucdich_txt=$_POST['mucdich_txt'];
			$s1=$s1.',ks18_muc_dich_txt';
			$s2=$s2.',"'.$mucdich_txt.'"';
			$s3=$s3.',ks18_muc_dich_txt="'.$mucdich_txt.'"';
			$mucdich=$_POST['mucdich'];
			$s1=$s1.',ks18_muc_dich';
			$s2=$s2.','.$mucdich;
			$s3=$s3.',ks18_muc_dich='.$mucdich;
		}
		else{
			$mucdich=$_POST['mucdich'];
			$s1=$s1.',ks18_muc_dich';
			$s2=$s2.','.$mucdich;
			$s3=$s3.',ks18_muc_dich='.$mucdich;
		}
	}
	else{
		$s3=$s3.',ks18_muc_dich=0,ks18_muc_dich_txt=""';
	}
	if(isset($_POST['lydo'])){
		$lydo=$_POST['lydo'];
			$s1=$s1.',ks18_ly_do';
			$s2=$s2.','.$lydo;
			$s3=$s3.',ks18_ly_do='.$lydo;
	}
	else{
		$s3=$s3.',ks18_ly_do=0';
	}
	if(isset($_POST['kenhdatphong'])){
		if(isset($_POST['kenhdatphong_txt']) && (strlen($_POST['kenhdatphong_txt'])>0)){
			$kenhdatphong_txt=$_POST['kenhdatphong_txt'];
			$s1=$s1.',ks18_kenh_dat_phong_txt';
			$s2=$s2.',"'.$kenhdatphong_txt.'"';
			$s3=$s3.',ks18_kenh_dat_phong_txt="'.$kenhdatphong_txt.'"';
			$kenhdatphong=$_POST['kenhdatphong'];
			$s1=$s1.',ks18_kenh_dat_phong';
			$s2=$s2.','.$kenhdatphong;
			$s3=$s3.',ks18_kenh_dat_phong='.$kenhdatphong;
		}
		else{
			$kenhdatphong=$_POST['kenhdatphong'];
			$s1=$s1.',ks18_kenh_dat_phong';
			$s2=$s2.','.$kenhdatphong;
			$s3=$s3.',ks18_kenh_dat_phong='.$kenhdatphong;
		}
	}
	else{
		$s3=$s3.',ks18_kenh_dat_phong=0,ks18_kenh_dat_phong_txt=""';
	}
	if(isset($_POST['danhgiachung'])){
		$danhgiachung=$_POST['danhgiachung'];
			$s1=$s1.',ks18_danh_gia_chung';
			$s2=$s2.','.$danhgiachung;
			$s3=$s3.',ks18_danh_gia_chung='.$danhgiachung;		
	}
	else{
		$s3=$s3.',ks18_danh_gia_chung=0';
	}
	if(isset($_POST['datphong'])){
		$datphong=$_POST['datphong'];
			$s1=$s1.',ks18_dat_phong';
			$s2=$s2.','.$datphong;
			$s3=$s3.',ks18_dat_phong='.$datphong;		
	}
	else{
		$s3=$s3.',ks18_dat_phong=0';
	}
	if(isset($_POST['checkin'])){
		$checkin=$_POST['checkin'];
			$s1=$s1.',ks18_checkin';
			$s2=$s2.','.$checkin;
			$s3=$s3.',ks18_checkin='.$checkin;		
	}
	else{
		$s3=$s3.',ks18_checkin=0';
	}
	if(isset($_POST['checkout'])){
		$checkout=$_POST['checkout'];
			$s1=$s1.',ks18_checkout';
			$s2=$s2.','.$checkout;
			$s3=$s3.',ks18_checkout='.$checkout;		
	}
	else{
		$s3=$s3.',ks18_checkout=0';
	}
	if(isset($_POST['dichvuhanhly'])){
		$dichvuhanhly=$_POST['dichvuhanhly'];
			$s1=$s1.',ks18_dich_vu_hanh_ly';
			$s2=$s2.','.$dichvuhanhly;
			$s3=$s3.',ks18_dich_vu_hanh_ly='.$checkin;		
	}
	else{
		$s3=$s3.',ks18_dich_vu_hanh_ly=0';
	}
	if(isset($_POST['vesinh'])){
		$vesinh=$_POST['vesinh'];
			$s1=$s1.',ks18_ve_sinh';
			$s2=$s2.','.$vesinh;
			$s3=$s3.',ks18_ve_sinh='.$vesinh;		
	}
	else{
		$s3=$s3.',ks18_ve_sinh=0';
	}
	if(isset($_POST['tiennghi'])){
		$tiennghi=$_POST['tiennghi'];
			$s1=$s1.',ks18_tien_nghi';
			$s2=$s2.','.$tiennghi;
			$s3=$s3.',ks18_tien_nghi='.$tiennghi;		
	}
	else{
		$s3=$s3.',ks18_tien_nghi=0';
	}
	if(isset($_POST['ansang'])){
		$ansang=$_POST['ansang'];
			$s1=$s1.',ks18_an_sang';
			$s2=$s2.','.$ansang;
			$s3=$s3.',ks18_an_sang='.$ansang;		
	}
	else{
		$s3=$s3.',ks18_an_sang=0';
	}
	if(isset($_POST['thaido'])){
		$thaido=$_POST['thaido'];
			$s1=$s1.',ks18_thai_do';
			$s2=$s2.','.$thaido;
			$s3=$s3.',ks18_thai_do='.$thaido;		
	}
	else{
		$s3=$s3.',ks18_thai_do=0';
	}
	if(isset($_POST['vandedatphong'])){
		$vandedatphong=$_POST['vandedatphong'];
			$s1=$s1.',ks18_van_de_dat_phong';
			$s2=$s2.','.$vandedatphong;
			$s3=$s3.',ks18_van_de_dat_phong='.$vandedatphong;		
	}
	else{
		$s3=$s3.',ks18_van_de_dat_phong=0';
	}
	if(isset($_POST['vandecheckin'])){
		$vandecheckin=$_POST['vandecheckin'];
			$s1=$s1.',ks18_van_de_checkin';
			$s2=$s2.','.$vandecheckin;
			$s3=$s3.',ks18_van_de_checkin='.$vandecheckin;		
	}
	else{
		$s3=$s3.',ks18_van_de_checkin=0';
	}
	if(isset($_POST['vandecheckout'])){
		$vandecheckout=$_POST['vandecheckout'];
			$s1=$s1.',ks18_van_de_checkout';
			$s2=$s2.','.$vandecheckout;
			$s3=$s3.',ks18_van_de_checkout='.$vandecheckout;		
	}
	else{
		$s3=$s3.',ks18_van_de_checkout=0';
	}
	if(isset($_POST['vandevesinh'])){
		$vandevesinh=$_POST['vandevesinh'];
			$s1=$s1.',ks18_van_de_ve_sinh';
			$s2=$s2.','.$vandevesinh;
			$s3=$s3.',ks18_van_de_ve_sinh='.$vandevesinh;		
	}
	else{
		$s3=$s3.',ks18_van_de_ve_sinh=0';
	}
	if(isset($_POST['cooling'])){
		$cooling=$_POST['cooling'];
			$s1=$s1.',ks18_cooling';
			$s2=$s2.','.$cooling;
			$s3=$s3.',ks18_cooling='.$cooling;		
	}
	else{
		$s3=$s3.',ks18_cooling=0';
	}
	if(isset($_POST['internet'])){
		$internet=$_POST['internet'];
			$s1=$s1.',ks18_internet';
			$s2=$s2.','.$internet;
			$s3=$s3.',ks18_internet='.$internet;		
	}
	else{
		$s3=$s3.',ks18_internet=0';
	}
	if(isset($_POST['amthuc'])){
		$amthuc=$_POST['amthuc'];
			$s1=$s1.',ks18_am_thuc';
			$s2=$s2.','.$amthuc;
			$s3=$s3.',ks18_am_thuc='.$amthuc;		
	}
	else{
		$s3=$s3.',ks18_am_thuc=0';
	}
	if(isset($_POST['hoadon'])){
		$hoadon=$_POST['hoadon'];
			$s1=$s1.',ks18_hoa_don';
			$s2=$s2.','.$hoadon;
			$s3=$s3.',ks18_hoa_don='.$hoadon;		
	}
	else{
		$s3=$s3.',ks18_hoa_don=0';
	}
	if(isset($_POST['nhanvien'])){
		$nhanvien=$_POST['nhanvien'];
			$s1=$s1.',ks18_nhan_vien';
			$s2=$s2.','.$nhanvien;
			$s3=$s3.',ks18_nhan_vien='.$nhanvien;		
	}
	else{
		$s3=$s3.',ks18_nhan_vien=0';
	}
	if(isset($_POST['vandekhac'])){
		$vandekhac=$_POST['vandekhac'];
			$s1=$s1.',ks18_van_de_khac';
			$s2=$s2.','.$vandekhac;
			$s3=$s3.',ks18_van_de_khac='.$vandekhac;
			if(strlen($_POST['vandekhac_txt'])>0){
				$vandekhac_txt=$_POST['vandekhac_txt'];
				$s1=$s1.',ks18_van_de_khac_txt';
				$s2=$s2.',"'.$vandekhac_txt.'"';
				$s3=$s3.',ks18_van_de_khac_txt="'.$vandekhac_txt.'"';
			}		
	}
	else{
		$s3=$s3.'ks18_van_de_khac=0,ks18_van_de_khac_txt=""';
	}
	if(isset($_POST['cachgiaiquyet'])){
		$cachgiaiquyet=$_POST['cachgiaiquyet'];
			$s1=$s1.',ks18_cach_giai_quyet';
			$s2=$s2.','.$cachgiaiquyet;
			$s3=$s3.',ks18_cach_giai_quyet='.$cachgiaiquyet;		
	}
	else{
		$s3=$s3.',ks18_cach_giai_quyet=0';
	}
	if(isset($_POST['nhanxet'])){
		$nhanxet=$_POST['nhanxet'];
			$s1=$s1.',ks18_nhan_xet';
			$s2=$s2.',"'.$nhanxet.'"';
			$s3=$s3.',ks18_nhan_xet="'.$nhanxet.'"';		
	}
	else{
		$s3=$s3.',ks18_nhan_xet=""';
	}
	if(isset($_POST['sua'])){
		$phieu=decode($_POST['sua']);
		$sql='UPDATE khaosat2018 SET '.$s3.' WHERE ks18_so_phieu='.$phieu;
		$nhatky='Cập nhật phiêu khảo sát có Số phiếu:'.$phieu;
		$ok=2;

	}
	else{
		//elseif(isset($_POST['phieuok']) && ($_POST['phieuok']>0)){
		$sql='INSERT INTO khaosat2018 ('.$s1.') VALUES ('.$s2.')';
		$nhatky='Tạo mới phiếu khảo sát 2018. Số phiếu: '.$sophieu.' ngày'.$ngay_khao_sat;
		$ok=1;
	}
	/*
	else{
		
		header('location: index.php?ylan=phieu2018&err=4');
	}
	*/
	if(isset($sql)){
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky($nhatky);	
					header('location: index.php?ylan=phieu2018&ok='.$ok);
				}
				else $error= "Có lỗi trong quá trình nhập liệu". mysqli_error($source).'|'.$sql.'<br>'.$s3;
	}
}

else{
	$tieudechinh = 'Phiếu khảo sát khách hàng 2018';
	$tieude_submit = 'tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;	

}

if(isset($sophieu)) $noidung=box_sophieu($sophieu); else $noidung=box_sophieu();
if(isset($ngay_khao_sat)) $noidung.=box_ngay($ngay_khao_sat); else $noidung.=box_ngay();
if(isset($ten_doan_khach))
	$noidung.=box_nhanxet('Tên đoàn khách ','ten_doan_khach',$ten_doan_khach); else $noidung.=box_nhanxet('Tên đoàn khách ','ten_doan_khach');
if(isset($mucdich)){
	if(isset($mucdich_txt)) 
		$noidung.=box_radio($mucdich_arr,'mucdich','mucdich_txt',$mucdich,$mucdich_txt);
	else 
		$noidung.=box_radio($mucdich_arr,'mucdich','mucdich_txt',$mucdich);
} 
else{
	$noidung.=box_radio($mucdich_arr,'mucdich','mucdich_txt');
}
if(isset($lydo)){
	$noidung.=box_radio($lydo_arr,'lydo','lydo_txt',$lydo);
}
else{
	$noidung.=box_radio($lydo_arr,'lydo','lydo_txt');
}
if(isset($kenhdatphong)){
	if(isset($kenhdatphong_txt)) 
		$noidung.=box_radio($kenhdatphong_arr,'kenhdatphong','kenhdatphong_txt',$kenhdatphong,$kenhdatphong_txt);
	else 
		$noidung.=box_radio($kenhdatphong_arr,'kenhdatphong','kenhdatphong_txt',$kenhdatphong);
} 
else{
	$noidung.=box_radio($kenhdatphong_arr,'kenhdatphong','kenhdatphong_txt');
}
$noidung.=title($danhgia_arr['danhgia']['noidung']);
if(isset($danhgiachung)) 
	$noidung.=box_radio2($danhgia_arr['danhgiachung']['noidung'],$danhgia_arr['danhgiachung']['bien'],$danhgiachung);
else 
	$noidung.=box_radio2($danhgia_arr['danhgiachung']['noidung'],$danhgia_arr['danhgiachung']['bien']);
if(isset($datphong)) 
	$noidung.=box_radio2($danhgia_arr['datphong']['noidung'],$danhgia_arr['datphong']['bien'],$datphong);
else 
	$noidung.=box_radio2($danhgia_arr['datphong']['noidung'],$danhgia_arr['datphong']['bien']);
if(isset($checkin)) 
	$noidung.=box_radio2($danhgia_arr['checkin']['noidung'],$danhgia_arr['checkin']['bien'],$checkin);
else 
	$noidung.=box_radio2($danhgia_arr['checkin']['noidung'],$danhgia_arr['checkin']['bien']);

if(isset($checkout)) 
	$noidung.=box_radio2($danhgia_arr['checkout']['noidung'],$danhgia_arr['checkout']['bien'],$checkout);
else 
	$noidung.=box_radio2($danhgia_arr['checkout']['noidung'],$danhgia_arr['checkout']['bien']);
if(isset($dichvuhanhly)) 
	$noidung.=box_radio2($danhgia_arr['dichvuhanhly']['noidung'],$danhgia_arr['dichvuhanhly']['bien'],$dichvuhanhly);
else 
	$noidung.=box_radio2($danhgia_arr['dichvuhanhly']['noidung'],$danhgia_arr['dichvuhanhly']['bien']);
if(isset($vesinh)) 
	$noidung.=box_radio2($danhgia_arr['vesinh']['noidung'],$danhgia_arr['vesinh']['bien'],$vesinh);
else 
	$noidung.=box_radio2($danhgia_arr['vesinh']['noidung'],$danhgia_arr['vesinh']['bien']);
if(isset($tiennghi)) 
	$noidung.=box_radio2($danhgia_arr['tiennghi']['noidung'],$danhgia_arr['tiennghi']['bien'],$tiennghi);
else 
	$noidung.=box_radio2($danhgia_arr['tiennghi']['noidung'],$danhgia_arr['tiennghi']['bien']);
if(isset($ansang)) 
	$noidung.=box_radio2($danhgia_arr['ansang']['noidung'],$danhgia_arr['ansang']['bien'],$ansang);
else 
	$noidung.=box_radio2($danhgia_arr['ansang']['noidung'],$danhgia_arr['ansang']['bien']);
if(isset($thaido)) 
	$noidung.=box_radio2($danhgia_arr['thaido']['noidung'],$danhgia_arr['thaido']['bien'],$thaido);
else 
	$noidung.=box_radio2($danhgia_arr['thaido']['noidung'],$danhgia_arr['thaido']['bien']);
$noidung.=title($vande_arr['chung']['noidung']);
$noidung.='<div class="row dong">
			<div class="col-sm-3"></div>
			<div class="col-sm-8" > ';
if(isset($vandedatphong))
	$noidung.=box_check($vande_arr['vandedatphong']['noidung'],$vande_arr['vandedatphong']['bien'],$vandedatphong);
else
	$noidung.=box_check($vande_arr['vandedatphong']['noidung'],$vande_arr['vandedatphong']['bien']);
if(isset($vandecheckin))
	$noidung.=box_check($vande_arr['vandecheckin']['noidung'],$vande_arr['vandecheckin']['bien'],$vandecheckin);
else
	$noidung.=box_check($vande_arr['vandecheckin']['noidung'],$vande_arr['vandecheckin']['bien']);
if(isset($vandecheckout))
	$noidung.=box_check($vande_arr['vandecheckout']['noidung'],$vande_arr['vandecheckout']['bien'],$vandecheckout);
else
	$noidung.=box_check($vande_arr['vandecheckout']['noidung'],$vande_arr['vandecheckout']['bien']);
if(isset($vandevesinh))
	$noidung.=box_check($vande_arr['vandevesinh']['noidung'],$vande_arr['vandevesinh']['bien'],$vandevesinh);
else
	$noidung.=box_check($vande_arr['vandevesinh']['noidung'],$vande_arr['vandevesinh']['bien']);
if(isset($cooling))
	$noidung.=box_check($vande_arr['cooling']['noidung'],$vande_arr['cooling']['bien'],$cooling);
else
	$noidung.=box_check($vande_arr['cooling']['noidung'],$vande_arr['cooling']['bien']);
if(isset($internet))
	$noidung.=box_check($vande_arr['internet']['noidung'],$vande_arr['internet']['bien'],$internet);
else
	$noidung.=box_check($vande_arr['internet']['noidung'],$vande_arr['internet']['bien']);
if(isset($amthuc))
	$noidung.=box_check($vande_arr['amthuc']['noidung'],$vande_arr['amthuc']['bien'],$amthuc);
else
	$noidung.=box_check($vande_arr['amthuc']['noidung'],$vande_arr['amthuc']['bien']);
if(isset($hoadon))
	$noidung.=box_check($vande_arr['hoadon']['noidung'],$vande_arr['hoadon']['bien'],$hoadon);
else
	$noidung.=box_check($vande_arr['hoadon']['noidung'],$vande_arr['hoadon']['bien']);
if(isset($nhanvien))
	$noidung.=box_check($vande_arr['nhanvien']['noidung'],$vande_arr['nhanvien']['bien'],$nhanvien);
else
	$noidung.=box_check($vande_arr['nhanvien']['noidung'],$vande_arr['nhanvien']['bien']);
if(isset($vandekhac))
	$noidung.=box_check_khac($vande_arr['vandekhac']['noidung'],$vande_arr['vandekhac']['bien'],$vande_arr['vandekhac']['bientxt'],$vandekhac);
else
	$noidung.=box_check_khac($vande_arr['vandekhac']['noidung'],$vande_arr['vandekhac']['bien'],$vande_arr['vandekhac']['bientxt']);
$noidung.='</div></div>';
if(isset($cachgiaiquyet))
	$noidung.=box_yesno($vande_arr['cachgiaiquyet']['noidung'],$vande_arr['cachgiaiquyet']['bien'],$cachgiaiquyet);
else
	$noidung.=box_yesno($vande_arr['cachgiaiquyet']['noidung'],$vande_arr['cachgiaiquyet']['bien']);
if(isset($nhanxet))
	$noidung.=box_nhanxet($vande_arr['nhanxet']['noidung'],$vande_arr['nhanxet']['bien'],$nhanxet);
else
	$noidung.=box_nhanxet($vande_arr['nhanxet']['noidung'],$vande_arr['nhanxet']['bien']);





if(isset($_GET['ok'] ) ){
	if($_GET['ok']==1) $status='Đã tạo xong phiếu, nhập dữ liệu phiếu mới';
	if($_GET['ok']==2) $status='Đã cập nhật xong phiếu, nhập dữ liệu phiếu mới';
}
if(isset($_GET['err'] ) ){
	if($_GET['err']==1) $status='Lỗi nhập liệu';
	if($_GET['err']==4) $status='Lỗi không xác định ';
}
if(isset($error)) $error="<div class='alert alert-danger text-center'>".$error." </div>" ;
if(isset($status))	$status="<div class='alert alert-success text-center'>".$status." </div>" ;
if(!isset($ngay_khao_sat))  $ngay_khao_sat=date("Y-m-d"); 
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/phieu2018.phtml';
?>