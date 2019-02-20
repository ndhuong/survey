<?php
include './controller/phieumoi_func.php';
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM sale_ks WHERE sale_id='.$id;
	$query=mysqli_query($source,$sql);
	$res=mysqli_fetch_array($query);
	$sql='DELETE FROM sale_ks WHERE sale_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		nhatky('xóa phiếu khảo sát số: '.$res['sale_so_phieu'].'- Ngày khảo sát: '.$res['sale_ngay_khao_sat']);
			header('location: index.php?ylan=xemphieu&bophan=3&ok=3');
	}
	else{
		header('location: index.php?ylan=xemphieu&bophan=3&err=1');	
	}

}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$tieudechinh='Phiếu khảo sát khách hàng Phòng Kinh doanh';
	$token =token();
	$_SESSION['token']=$token;
	$tieude_submit = 'cập nhật phiếu';
	$id=decode($_GET['sua']);
	$sql= 'SELECT * FROM sale_ks WHERE sale_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$res = mysqli_fetch_array( $query );
		//var_dump($res);
		$sophieu=$res['sale_so_phieu'];
		$ngay_khao_sat=$res['sale_ngay_khao_sat'];
		$how_dich_vu=$res['sale_dich_vu'];
		$how_trang_bi=$res['sale_trang_bi'];
		$employ_chung=$res['sale_empl_chung'];
		$employ_tu_tin=$res['sale_empl_tu_tin'];
		$employ_nhanh=$res['sale_empl_hieu_qua'];
		$employ_chuyen_nghiep=$res['sale_empl_chuyen_nghiep'];
		$employ_hai_long=$res['sale_empl_hai_long'];
		$employ_ten_nhan_vien=$res['sale_empl_ten_nhan_vien'];
		$overall_chung=$res['sale_overall_chung'];
		$overall_how=$res['sale_overall_how'];
		$overall_ho_ten=$res['sale_guest_ten'];
		$overall_email=$res['sale_guest_email'];
		$overall_dien_thoai=$res['sale_guest_tel'];
		$overall_so_phong=$res['sale_guest_so_phong'];
		$overall_thoi_gian=$res['sale_guest_thoi_gian'];
		$overall_cong_ty=$res['sale_guest_cong_ty'];
		$goBack='<input type="button" value="<= Quay lại trang trước" onclick="history.back(-1)" />';
	}

}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])){
	$t1='';
	$t2='';
	$t3='';
	if(isset($_POST['suaphieu']) && (strlen($_POST['suaphieu'])>2)){ 
		
	}
	else{
		$sophieu=$_POST['sophieu'];
		$t1='sale_so_phieu,';
		$t2=$sophieu.',';
		$t3='sale_so_phieu='.$sophieu.',';
	}
	$ngay_khao_sat=$_POST['ngay_khao_sat'];
	$t1=$t1.'sale_ngay_khao_sat,';
	$t2=$t2.'"'.$ngay_khao_sat.'",';
	$t3=$t3.'sale_ngay_khao_sat='.'"'.$ngay_khao_sat.'",';

	if(strlen($_POST['how_dich_vu'])>0){
		$how_dich_vu=$_POST['how_dich_vu'];
		$t1=$t1.'sale_dich_vu,';
		$t2=$t2.'"'.$how_dich_vu.'",';
		$t3=$t3.'sale_dich_vu='.'"'.$how_dich_vu.'",';
	}
	if(strlen($_POST['how_trang_bi'])>0){
		$how_trang_bi=$_POST['how_trang_bi'];
		$t1=$t1.'sale_trang_bi,';
		$t2=$t2.'"'.$how_trang_bi.'",';
		$t3=$t3.'sale_trang_bi='.'"'.$how_trang_bi.'",';
	}
	if(strlen($_POST['employ_chung'])>0){
		$employ_chung=$_POST['employ_chung'];
		$t1=$t1.'sale_empl_chung,';
		$t2=$t2.'"'.$employ_chung.'",';
		$t3=$t3.'sale_empl_chung='.'"'.$employ_chung.'",';
	}
	if(strlen($_POST['employ_tu_tin'])>0){
		$employ_tu_tin=$_POST['employ_tu_tin'];
		$t1=$t1.'sale_empl_tu_tin,';
		$t2=$t2.'"'.$employ_tu_tin.'",';
		$t3=$t3.'sale_empl_tu_tin='.'"'.$employ_tu_tin.'",';
	}
	if(strlen($_POST['employ_nhanh'])>0){
		$employ_nhanh=$_POST['employ_nhanh'];
		$t1=$t1.'sale_empl_hieu_qua,';
		$t2=$t2.'"'.$employ_nhanh.'",';
		$t3=$t3.'sale_empl_hieu_qua='.'"'.$employ_nhanh.'",';
	}
	if(strlen($_POST['employ_chuyen_nghiep'])>0){
		$employ_chuyen_nghiep=$_POST['employ_chuyen_nghiep'];
		$t1=$t1.'sale_empl_chuyen_nghiep,';
		$t2=$t2.'"'.$employ_chuyen_nghiep.'",';
		$t3=$t3.'sale_empl_chuyen_nghiep='.'"'.$employ_chuyen_nghiep.'",';
	}
	if(strlen($_POST['employ_hai_long'])>0){
		$employ_hai_long=$_POST['employ_hai_long'];
		$t1=$t1.'sale_empl_hai_long,';
		$t2=$t2.'"'.$employ_hai_long.'",';
		$t3=$t3.'sale_empl_hai_long='.'"'.$employ_hai_long.'",';
	}
	if(strlen($_POST['employ_ten_nhan_vien'])>0){
		$employ_ten_nhan_vien=$_POST['employ_ten_nhan_vien'];
		$t1=$t1.'sale_empl_ten_nhan_vien,';
		$t2=$t2.'"'.$employ_ten_nhan_vien.'",';
		$t3=$t3.'sale_empl_ten_nhan_vien='.'"'.$employ_ten_nhan_vien.'",';
	}
	if(strlen($_POST['overall_chung'])>0){
		$overall_chung=$_POST['overall_chung'];
		$t1=$t1.'sale_overall_chung,';
		$t2=$t2.'"'.$overall_chung.'",';
		$t3=$t3.'sale_overall_chung='.'"'.$overall_chung.'",';
	}	
	if(strlen($_POST['overall_how'])>0) {
		$overall_how=$_POST['overall_how'];
		$t1=$t1.'sale_overall_how,';
		$t2=$t2.'"'.$overall_how.'",';
		$t3=$t3.'sale_overall_how='.'"'.$overall_how.'",';
	}
	if(strlen($_POST['overall_ho_ten'])>0) {
		$overall_ho_ten=$_POST['overall_ho_ten'];
		$t1=$t1.'sale_guest_ten,';
		$t2=$t2.'"'.$overall_ho_ten.'",';
		$t3=$t3.'sale_guest_ten='.'"'.$overall_ho_ten.'",';
	}
	if(strlen($_POST['overall_email'])>0) {
		$overall_email=$_POST['overall_email'];
		$t1=$t1.'sale_guest_email,';
		$t2=$t2.'"'.$overall_email.'",';
		$t3=$t3.'sale_guest_email='.'"'.$overall_email.'",';
	}
	if(strlen($_POST['overall_dien_thoai'])>0) {
		$overall_dien_thoai=$_POST['overall_dien_thoai'];
		$t1=$t1.'sale_guest_tel,';
		$t2=$t2.'"'.$overall_dien_thoai.'",';
		$t3=$t3.'sale_guest_tel='.'"'.$overall_dien_thoai.'",';
	}
	if(strlen($_POST['overall_so_phong'])>0) {
		$overall_so_phong=$_POST['overall_so_phong'];
		$t1=$t1.'sale_guest_so_phong, ';
		$t2=$t2.'"'.$overall_so_phong.'",';
		$t3=$t3.'sale_guest_so_phong= '.'"'.$overall_so_phong.'",';
	}
	if(strlen($_POST['overall_thoi_gian'])>0) {
		$overall_thoi_gian=$_POST['overall_thoi_gian'];
		$t1=$t1.'sale_guest_thoi_gian, ';
		$t2=$t2.'"'.$overall_thoi_gian.'",';
		$t3=$t3.'sale_guest_thoi_gian ='.'"'.$overall_thoi_gian.'",';
	}
	if(strlen($_POST['overall_cong_ty'])>0) {
		$overall_cong_ty=$_POST['overall_cong_ty'];
		$t1=$t1.'sale_guest_cong_ty ';
		$t2=$t2.'"'.$overall_cong_ty.'"';
		$t3=$t3.'sale_guest_cong_ty ='.'"'.$overall_cong_ty.'"';
	}


	if(substr($t1, strlen($t1)-1,1)==',') $t1=substr($t1,0,strlen($t1)-1);
	if(substr($t2, strlen($t2)-1,1)==',') $t2=substr($t2,0,strlen($t2)-1);
	if(substr($t3, strlen($t3)-1,1)==',') $t3=substr($t3,0,strlen($t3)-1);
	echo 't1='.$t1.'<br> t2='.$t2.'<br>t3='.$t3;
	if( (isset($_POST['phieuok'])&&($_POST['phieuok']>0)) || ((isset($_POST['suaphieu'])) && (decodetoken($_POST['suaphieu'])==$_SESSION['token']) ) ){
		if((isset($_POST['suaphieu'])) && (decodetoken($_POST['suaphieu'])==$_SESSION['token']) ){
			$sophieu=decode($_POST['suaphieu']);
			$sql='UPDATE sale_ks SET '.$t3.' WHERE ks_so_phieu='.$sophieu;
			$nhatky='Cập nhật mới phiếu khảo sát số'.$sophieu.' - Cập nhật nội dung phiếu';
		}
		else{
			$sql='INSERT INTO sale_ks ('.$t1.') VALUES ('.$t2.')';
			$nhatky='Kinh doanh - Tạo mới phiếu khảo sát';
		}
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky($nhatky);	
					header('location: index.php?ylan=phieu_kinhdoanh&ok=1');
				}
				else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source).'|'.$sql;
	}
}
else{
	$tieudechinh='Phiếu khảo sát khách hàng - Phòng Kinh doanh';
	$tieude_submit='tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;
	/*
	$sql='SELECT MAX(`nd_stt`) FROM noidungkhaosat';
	$query=mysqli_query($source,$sql);
	if($query){
		//var_dump($query);
		$result=mysqli_fetch_array( $query );
		//var_dump($result);
		$stt=$result[0]+1;
		$stt_ok=1;
	}
	*/	
}
if(!isset($ngay_khao_sat))  $ngay_khao_sat=date("Y-m-d");
$noidungmau=noiDungMau(3,2);//(3) load nội dung mẫu kinh doanh. (2)tra ve sap xep theo truong ten_sql
//var_dump($noidungmau);
$noidung='';
if(isset($goBack))  $noidung=$noidung.$goBack.'<br><br>';
if(isset($sophieu)) $noidung=$noidung.soPhieu('sophieu',$sophieu);	else $noidung=$noidung.soPhieu('sophieu');
if(isset($ngay_khao_sat)) $noidung=$noidung.ngayKhaoSat('ngay_khao_sat',$ngay_khao_sat); else $noidung=$noidung.ngayKhaoSat('ngay_khao_sat');
$noidung=$noidung.tieuDe($noidungmau['caitienchatluong']['noidung']);
	if(isset($how_dich_vu)) $noidung=$noidung.dongTxt($noidungmau['ks_how_dich_vu']['noidung'],'how_dich_vu',$how_dich_vu); else $noidung=$noidung.dongTxt($noidungmau['ks_how_dich_vu']['noidung'],'how_dich_vu');
	if(isset($how_trang_bi)) $noidung=$noidung.dongTxt($noidungmau['ks_how_trang_bi']['noidung'],'how_trang_bi',$how_trang_bi); else $noidung=$noidung.dongTxt($noidungmau['ks_how_trang_bi']['noidung'],'how_trang_bi');
	$noidung=$noidung.tieuDe($noidungmau['nhanvienkhachsan']['noidung']);
	if(isset($employ_chung)) $noidung=$noidung.dongTxt($noidungmau['ks_empl_chung']['noidung'],'employ_chung',$employ_chung); else $noidung=$noidung.dongTxt($noidungmau['ks_empl_chung']['noidung'],'employ_chung');
	$noidung=$noidung.tieuDePhu($noidungmau['nhanvienhotro']['noidung']);
	if(isset($employ_tu_tin)) $noidung=$noidung.dongTxt($noidungmau['ks_empl_tu_tin']['noidung'],'employ_tu_tin',$employ_tu_tin); else $noidung=$noidung.dongTxt($noidungmau['ks_empl_tu_tin']['noidung'],'employ_tu_tin');
	if(isset($employ_nhanh)) $noidung=$noidung.dongTxt($noidungmau['ks_empl_hieu_qua']['noidung'],'employ_nhanh',$employ_nhanh); else $noidung=$noidung.dongTxt($noidungmau['ks_empl_hieu_qua']['noidung'],'employ_nhanh');
	if(isset($employ_chuyen_nghiep)) $noidung=$noidung.dongTxt($noidungmau['ks_empl_chuyen_nghiep']['noidung'],$employ_chuyen_nghiep); else $noidung=$noidung.dongTxt($noidungmau['ks_empl_chuyen_nghiep']['noidung'],'employ_chuyen_nghiep');
	if(isset($employ_hai_long)) $noidung=$noidung.dongTxt($noidungmau['ks_empl_hai_long']['noidung'],'employ_hai_long',$employ_hai_long); else $noidung=$noidung.dongTxt($noidungmau['ks_empl_hai_long']['noidung'],'employ_hai_long');
	if(isset($employ_ten_nhan_vien)) $noidung=$noidung.dongTxt($noidungmau['ks_empl_mong_doi']['noidung'].'<br>'.$noidungmau['ks_empl_name']['noidung'].'<i>(Nếu có)</i>','employ_ten_nhan_vien',$employ_ten_nhan_vien); else $noidung=$noidung.dongTxt($noidungmau['ks_empl_mong_doi']['noidung'].'<br>'.$noidungmau['ks_empl_name']['noidung'].'<i>(Nếu có)</i>','employ_ten_nhan_vien');
	tieuDe($noidungmau['hailongchung']['noidung']);
	if(isset($overall_how)) $noidung=$noidung.dongTxt($noidungmau['ks_overall_how']['noidung'],'overall_how',$overall_how); else $noidung=$noidung.dongTxt($noidungmau['ks_overall_how']['noidung'],'overall_how');
	if(isset($overall_chung)) $noidung=$noidung.dongTxt($noidungmau['ks_overall_chung']['noidung'],'overall_chung',$overall_chung); else $noidung=$noidung.dongTxt($noidungmau['ks_overall_chung']['noidung'],'overall_chung');
	$noidung=$noidung.tieuDe($noidungmau['hailongchung2']['noidung']);
	if(isset($overall_ho_ten)) $noidung=$noidung.dongTxt($noidungmau['ks_guest_ten']['noidung'],'overall_ho_ten',$overall_ho_ten); else $noidung=$noidung.dongTxt($noidungmau['ks_guest_ten']['noidung'],'overall_ho_ten');
	if(isset($overall_email)) $noidung=$noidung.dongTxt($noidungmau['ks_guest_email']['noidung'],'overall_email',$overall_email); else $noidung=$noidung.dongTxt($noidungmau['ks_guest_email']['noidung'],'overall_email');
	if(isset($overall_dien_thoai)) $noidung=$noidung.dongTxt($noidungmau['ks_guest_tel']['noidung'],'overall_dien_thoai',$overall_dien_thoai); else $noidung=$noidung.dongTxt($noidungmau['ks_guest_tel']['noidung'],'overall_dien_thoai');
	if(isset($overall_so_phong)) $noidung=$noidung.dongTxt($noidungmau['ks_guest_so_phong']['noidung'],'overall_so_phong',$overall_so_phong); else $noidung=$noidung.dongTxt($noidungmau['ks_guest_so_phong']['noidung'],'overall_so_phong');
	if(isset($overall_thoi_gian)) $noidung=$noidung.dongTxt($noidungmau['ks_guest_thoi_gian']['noidung'],'overall_thoi_gian',$overall_thoi_gian); else $noidung=$noidung.dongTxt($noidungmau['ks_guest_thoi_gian']['noidung'],'overall_thoi_gian');
	if(isset($overall_cong_ty)) $noidung=$noidung.dongTxt($noidungmau['ks_guest_cong_ty']['noidung'],'overall_cong_ty',$overall_cong_ty); else $noidung=$noidung.dongTxt($noidungmau['ks_guest_cong_ty']['noidung'],'overall_cong_ty');

if(isset($_GET['err'])){
	if($_GET['err']==1) $error='Phải có nội dung, loại dữ liệu, tên trường chứ';
}
if(isset($_GET['ok'])){
	if($_GET['ok']==1) $status='Tạo mới/cập nhật nội dung khảo sát thành công.';
}
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
include './views/phieu_kinhdoanh.phtml';
?>