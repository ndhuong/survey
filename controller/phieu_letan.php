<?php
include './controller/phieumoi_func.php';
/*
if(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])&&isset($_POST['sua'])){

}

else
*/
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	$res=mysqli_fetch_array($query);
	$sql='DELETE FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		nhatky('xóa phiếu khảo sát số: '.$res['ks_so_phieu'].'- Ngày khảo sát: '.$res['ks_ngay_khao_sat']);
			header('location: index.php?ylan=xemphieu&bophan=2&ok=3');
	}
	else{
		header('location: index.php?ylan=xemphieu&bophan=2&err=1');	
	}

}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$tieudechinh='Phiếu khảo sát khách hàng - Lễ tân';
	$token =token();
	$_SESSION['token']=$token;
	$tieude_submit = 'cập nhật phiếu';
	$id=decode($_GET['sua']);
	$sql= 'SELECT * FROM khao_sat WHERE ks_so_phieu='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$res = mysqli_fetch_array( $query );
		// load nội dung mẫu
		//$mau=noiDungMau();
		/*
		$sophieu=$res['ks_so_phieu'];
		$ngay_khao_sat=$res['ks_ngay_khao_sat'];
		$rest_chung=$res['ks_rest_chung'];
		$rest_dich_vu=$res['ks_rest_dich_vu'];
		$rest_do_an=$res['ks_rest_do_an'];
		$rest_do_uong=$res['ks_rest_do_uong'];
		$rest_trang_tri=$res['ks_rest_trang_tri'];
		$how_an_uong=$res['ks_how_an_uong'];
		*/
		$sophieu=$res['ks_so_phieu'];
		$ngay_khao_sat=$res['ks_ngay_khao_sat'];
		$checkin_tiep_don=$res['ks_checkin_chung'];
		$checkin_dang_ky=$res['ks_checkin_nhanh_gon'];
		$checkin_yeu_cau=$res['ks_checkin_yeu_cau'];
		$checkin_chao_don=$res['ks_checkin_chao_don'];
		$room_chung=$res['ks_room_chung'];
		$room_thoai_mai=$res['ks_room_thoai_mai'];
		$room_sach_se=$res['ks_room_sach_se'];
		$room_an_toan=$res['ks_room_an_toan'];
		$room_anh_sang=$res['ks_room_anh_sang'];
		$room_internet=$res['ks_room_internet'];
		$room_tot_hon=$res['ks_room_tot_hon'];
		$fac_chung=$res['ks_fac_chung'];
		$fac_fit_dich_vu=$res['ks_fac_fit_dich_vu'];
		$fac_fit_ky_nang=$res['ks_fac_fit_ky_nang'];
		$fac_fit_trang_bi=$res['ks_fac_fit_trang_bi'];
		$fac_spa_dich_vu=$res['ks_fac_spa_dich_vu'];
		$fac_spa_ky_nang=$res['ks_fac_spa_ky_nang'];
		$fac_spa_trang_bi=$res['ks_fac_spa_trang_bi'];
		$fac_swim_dich_vu=$res['ks_fac_swim_dich_vu'];
		$fac_swim_ky_nang=$res['ks_fac_swim_ky_nang'];
		$fac_swim_trang_bi=$res['ks_fac_swim_trang_bi'];
		$fac_busi_dich_vu=$res['ks_fac_busi_dich_vu'];
		$fac_busi_ky_nang=$res['ks_fac_busi_ky_nang'];
		$fac_busi_trang_bi=$res['ks_fac_busi_trang_bi'];
		//
		$how_dich_vu=$res['ks_how_dich_vu'];
		$how_trang_bi=$res['ks_how_trang_bi'];
		$how_trang_tri=$res['ks_how_trang_tri'];
		$how_khac=$res['ks_how_khac'];
		$employ_chung=$res['ks_empl_chung'];
		$employ_tu_tin=$res['ks_empl_tu_tin'];
		$employ_nhanh=$res['ks_empl_hieu_qua'];
		$employ_chuyen_nghiep=$res['ks_empl_chuyen_nghiep'];
		$employ_hai_long=$res['ks_empl_hai_long'];
		$employ_mong_doi=$res['ks_empl_mong_doi'];
		$employ_ten_nhan_vien=$res['ks_empl_name'];
		$overall_chung=$res['ks_overall_chung'];
		$overall_how=$res['ks_overall_how'];
		$overall_ho_ten=$res['ks_guest_ten'];
		$overall_email=$res['ks_guest_email'];
		$overall_dien_thoai=$res['ks_guest_tel'];
		$overall_so_phong=$res['ks_guest_so_phong'];
		$overall_thoi_gian=$res['ks_guest_thoi_gian'];
		$overall_cong_ty=$res['ks_guest_cong_ty'];
		$goBack='<input type="button" value="<= Quay lại trang trước" onclick="history.back(-1)" />';
	}

}
elseif(isset($_POST['submit']) && ($_POST['token']==$_SESSION['token'])){
	$t1='';
	$t2='';
	$t3='';
	if(isset($_POST['phieuexist'])){
		if(strlen($_POST['phieuexist'])>2) $phieuexist=decode($_POST['phieuexist']);
		else $phieuexist=$_POST['phieuexist'];
		if($phieuexist>0){
				$sophieu=$_POST['sophieu'];
				$t1='';
				$t2='';
				$t3='';
			}
			else{
				$sophieu=$_POST['sophieu'];
				$t1='ks_so_phieu,';
				$t2=$sophieu.',';
				$t3='ks_so_phieu='.$sophieu.',';
			}
	}
	
	$t1=$t1.'ks_le_tan,';
	$t2=$t2.'1,';
	$t3=$t3.'ks_le_tan=1,';
	$ngay_khao_sat=$_POST['ngay_khao_sat'];
	$t1=$t1.'ks_ngay_khao_sat,';
	$t2=$t2.'"'.$ngay_khao_sat.'",';
	$t3=$t3.'ks_ngay_khao_sat='.'"'.$ngay_khao_sat.'",';
	if(!empty($_POST['checkin_tiep_don'])){
		$checkin_tiep_don=$_POST['checkin_tiep_don'];
		$t1=$t1.'ks_checkin_chung,';
		$t2=$t2.$checkin_tiep_don.',';
		$t3=$t3.'ks_checkin_chung='.$checkin_tiep_don.',';
	}
	if(!empty($_POST['checkin_dang_ky'])){
		$checkin_dang_ky=$_POST['checkin_dang_ky'];
		$t1=$t1.'ks_checkin_nhanh_gon,';
		$t2=$t2.$checkin_dang_ky.',';
		$t3=$t3.'ks_checkin_nhanh_gon='.$checkin_dang_ky.',';
	}
	if(!empty($_POST['checkin_yeu_cau'])){
		$checkin_yeu_cau=$_POST['checkin_yeu_cau'];
		$t1=$t1.'ks_checkin_yeu_cau,';
		$t2=$t2.$checkin_yeu_cau.',';
		$t3=$t3.'ks_checkin_yeu_cau='.$checkin_yeu_cau.',';
	}
	if(!empty($_POST['checkin_chao_don'])){
		$checkin_chao_don=$_POST['checkin_chao_don'];
		$t1=$t1.'ks_checkin_chao_don,';
		$t2=$t2.$checkin_chao_don.',';
		$t3=$t3.'ks_checkin_chao_don='.$checkin_chao_don.',';
	}
	if(!empty($_POST['room_chung'])){
		$room_chung=$_POST['room_chung'];
		$t1=$t1.'ks_room_chung,';
		$t2=$t2.$room_chung.',';
		$t3=$t3.'ks_room_chung='.$room_chung.',';
	}
	if(!empty($_POST['room_thoai_mai'])){
		$room_thoai_mai=$_POST['room_thoai_mai'];
		$t1=$t1.'ks_room_thoai_mai,';
		$t2=$t2.$room_thoai_mai.',';
		$t3=$t3.'ks_room_thoai_mai='.$room_thoai_mai.',';
	}
	if(!empty($_POST['room_sach_se'])){
		$room_sach_se=$_POST['room_sach_se'];
		$t1=$t1.'ks_room_sach_se,';
		$t2=$t2.$room_sach_se.',';
		$t3=$t3.'ks_room_sach_se='.$room_sach_se.',';
	}
	if(!empty($_POST['room_an_toan'])){
		$room_an_toan=$_POST['room_an_toan'];
		$t1=$t1.'ks_room_an_toan,';
		$t2=$t2.$room_an_toan.',';
		$t3=$t3.'ks_room_an_toan='.$room_an_toan.',';
	}
	if(!empty($_POST['room_anh_sang'])){
		$room_anh_sang=$_POST['room_anh_sang'];
		$t1=$t1.'ks_room_anh_sang,';
		$t2=$t2.$room_anh_sang.',';
		$t3=$t3.'ks_room_anh_sang='.$room_anh_sang.',';
	}
	if(!empty($_POST['room_internet'])){
		$room_internet=$_POST['room_internet'];
		$t1=$t1.'ks_room_internet,';
		$t2=$t2.$room_internet.',';
		$t3=$t3.'ks_room_internet='.$room_internet.',';
	}
	if(strlen($_POST['room_tot_hon'])>1){
		$room_tot_hon=$_POST['room_tot_hon'];
		$t1=$t1.'ks_room_tot_hon,';
		$t2=$t2.'"'.$room_tot_hon.'",';
		$t3=$t3.'ks_room_tot_hon='.'"'.$room_tot_hon.'",';
	}
	if(!empty($_POST['fac_chung'])){
		$fac_chung=$_POST['fac_chung'];
		$t1=$t1.'ks_fac_chung,';
		$t2=$t2.$fac_chung.',';
		$t3=$t3.'ks_fac_chung='.$fac_chung.',';
	}
	if(!empty($_POST['fac_fit_dich_vu'])){
		$fac_fit_dich_vu=$_POST['fac_fit_dich_vu'];
		$t1=$t1.'ks_fac_fit_dich_vu,';
		$t2=$t2.$fac_fit_dich_vu.',';
		$t3=$t3.'ks_fac_fit_dich_vu='.$fac_fit_dich_vu.',';
	}
	if(!empty($_POST['fac_fit_ky_nang'])){
		$fac_fit_ky_nang=$_POST['fac_fit_ky_nang'];
		$t1=$t1.'ks_fac_fit_ky_nang,';
		$t2=$t2.$fac_fit_ky_nang.',';
		$t3=$t3.'ks_fac_fit_ky_nang='.$fac_fit_ky_nang.',';
	}
	if(!empty($_POST['fac_fit_trang_bi'])){
		$fac_fit_trang_bi=$_POST['fac_fit_trang_bi'];
		$t1=$t1.'ks_fac_fit_trang_bi,';
		$t2=$t2.$fac_fit_trang_bi.',';
		$t3=$t3.'ks_fac_fit_trang_bi='.$fac_fit_trang_bi.',';
	}
	if(!empty($_POST['fac_spa_dich_vu'])){
		$fac_spa_dich_vu=$_POST['fac_spa_dich_vu'];
		$t1=$t1.'ks_fac_spa_dich_vu,';
		$t2=$t2.$fac_spa_dich_vu.',';
		$t3=$t3.'ks_fac_spa_dich_vu='.$fac_spa_dich_vu.',';
	}
	if(!empty($_POST['fac_spa_ky_nang'])){
		$fac_spa_ky_nang=$_POST['fac_spa_ky_nang'];
		$t1=$t1.'ks_fac_spa_ky_nang,';
		$t2=$t2.$fac_spa_ky_nang.',';
		$t3=$t3.'ks_fac_spa_ky_nang='.$fac_spa_ky_nang.',';
	}
	if(!empty($_POST['fac_spa_trang_bi'])){
		$fac_spa_trang_bi=$_POST['fac_spa_trang_bi'];
		$t1=$t1.'ks_fac_spa_trang_bi,';
		$t2=$t2.$fac_spa_trang_bi.',';
		$t3=$t3.'ks_fac_spa_trang_bi='.$fac_spa_trang_bi.',';
	}
	if(!empty($_POST['fac_swim_dich_vu'])){
		$fac_swim_dich_vu=$_POST['fac_swim_dich_vu'];
		$t1=$t1.'ks_fac_swim_dich_vu,';
		$t2=$t2.$fac_swim_dich_vu.',';
		$t3=$t3.'ks_fac_swim_dich_vu='.$fac_swim_dich_vu.',';
	}
	if(!empty($_POST['fac_swim_ky_nang'])){
		$fac_swim_ky_nang=$_POST['fac_swim_ky_nang'];
		$t1=$t1.'ks_fac_swim_ky_nang,';
		$t2=$t2.$fac_swim_ky_nang.',';
		$t3=$t3.'ks_fac_swim_ky_nang='.$fac_swim_ky_nang.',';
	}
	if(!empty($_POST['fac_swim_trang_bi'])){
		$fac_swim_trang_bi=$_POST['fac_swim_trang_bi'];
		$t1=$t1.'ks_fac_swim_trang_bi,';
		$t2=$t2.$fac_swim_trang_bi.',';
		$t3=$t3.'ks_fac_swim_trang_bi='.$fac_swim_trang_bi.',';
	}
	if(!empty($_POST['fac_busi_dich_vu'])){
		$fac_busi_dich_vu=$_POST['fac_busi_dich_vu'];
		$t1=$t1.'ks_fac_busi_dich_vu,';
		$t2=$t2.$fac_busi_dich_vu.',';
		$t3=$t3.'ks_fac_busi_dich_vu='.$fac_busi_dich_vu.',';
	}
	if(!empty($_POST['fac_busi_ky_nang'])){
		$fac_busi_ky_nang=$_POST['fac_busi_ky_nang'];
		$t1=$t1.'ks_fac_busi_ky_nang,';
		$t2=$t2.$fac_busi_ky_nang.',';
		$t3=$t3.'ks_fac_busi_ky_nang='.$fac_busi_ky_nang.',';
	}
	if(!empty($_POST['fac_busi_trang_bi'])){
		$fac_busi_trang_bi=$_POST['fac_busi_trang_bi'];
		$t1=$t1.'ks_fac_busi_trang_bi,';
		$t2=$t2.$fac_busi_trang_bi.',';
		$t3=$t3.'ks_fac_busi_trang_bi='.$fac_busi_trang_bi.',';
	}
	if(strlen($_POST['how_dich_vu'])>1){
		$how_dich_vu=$_POST['how_dich_vu'];
		$t1=$t1.'ks_how_dich_vu,';
		$t2=$t2.'"'.$how_dich_vu.'",';
		$t3=$t3.'ks_how_dich_vu='.'"'.$how_dich_vu.'",';
	}
	if(strlen($_POST['how_trang_bi'])>1){
		$how_trang_bi=$_POST['how_trang_bi'];
		$t1=$t1.'ks_how_trang_bi,';
		$t2=$t2.'"'.$how_trang_bi.'",';
		$t3=$t3.'ks_how_trang_bi='.'"'.$how_trang_bi.'",';
	}
	if(strlen($_POST['how_trang_tri'])>1){
		$how_trang_tri=$_POST['how_trang_tri'];
		$t1=$t1.'ks_how_trang_tri,';
		$t2=$t2.'"'.$how_trang_tri.'",';
		$t3=$t3.'ks_how_trang_tri='.'"'.$how_trang_tri.'",';
	}
	if(strlen($_POST['how_khac'])>1){
		$how_khac=$_POST['how_khac'];
		$t1=$t1.'ks_how_khac,';
		$t2=$t2.'"'.$how_khac.'",';
		$t3=$t3.'ks_how_khac='.'"'.$how_khac.'",';
	}
	if(!empty($_POST['employ_chung'])){
		$employ_chung=$_POST['employ_chung'];
		$t1=$t1.'ks_empl_chung,';
		$t2=$t2.$employ_chung.',';
		$t3=$t3.'ks_empl_chung='.$employ_chung.',';
	}
	if(!empty($_POST['employ_tu_tin'])){
		$employ_tu_tin=$_POST['employ_tu_tin'];
		$t1=$t1.'ks_empl_tu_tin,';
		$t2=$t2.$employ_tu_tin.',';
		$t3=$t3.'ks_empl_tu_tin='.$employ_tu_tin.',';
	}
	if(!empty($_POST['employ_nhanh'])){
		$employ_nhanh=$_POST['employ_nhanh'];
		$t1=$t1.'ks_empl_hieu_qua,';
		$t2=$t2.$employ_nhanh.',';
		$t3=$t3.'ks_empl_hieu_qua='.$employ_nhanh.',';
	}
	if(!empty($_POST['employ_chuyen_nghiep'])){
		$employ_chuyen_nghiep=$_POST['employ_chuyen_nghiep'];
		$t1=$t1.'ks_empl_chuyen_nghiep,';
		$t2=$t2.$employ_chuyen_nghiep.',';
		$t3=$t3.'ks_empl_chuyen_nghiep='.$employ_chuyen_nghiep.',';
	}
	if(!empty($_POST['employ_hai_long'])){
		$employ_hai_long=$_POST['employ_hai_long'];
		$t1=$t1.'ks_empl_hai_long,';
		$t2=$t2.$employ_hai_long.',';
		$t3=$t3.'ks_empl_hai_long='.$employ_hai_long.',';
	}
	if(!empty($_POST['employ_mong_doi'])){
		$employ_mong_doi=$_POST['employ_mong_doi'];
		$t1=$t1.'ks_empl_mong_doi,';
		$t2=$t2.$employ_mong_doi.',';
		$t3=$t3.'ks_empl_mong_doi='.$employ_mong_doi.',';
	}
	if(strlen($_POST['employ_ten_nhan_vien'])>1){
		$employ_ten_nhan_vien=$_POST['employ_ten_nhan_vien'];
		$t1=$t1.'ks_empl_name,';
		$t2=$t2.'"'.$employ_ten_nhan_vien.'",';
		$t3=$t3.'ks_empl_name='.'"'.$employ_ten_nhan_vien.'",';
	}
	if(!empty($_POST['overall_chung'])) {
		$overall_chung=$_POST['overall_chung'];
		$t1=$t1.'ks_overall_chung,';
		$t2=$t2.$overall_chung.',';
		$t3=$t3.'ks_overall_chung='.$overall_chung.',';
	}
	if(strlen($_POST['overall_how'])>1) {
		$overall_how=$_POST['overall_how'];
		$t1=$t1.'ks_overall_how,';
		$t2=$t2.'"'.$overall_how.'",';
		$t3=$t3.'ks_overall_how='.'"'.$overall_how.'",';
	}
	if(strlen($_POST['overall_ho_ten'])>1) {
		$overall_ho_ten=$_POST['overall_ho_ten'];
		$t1=$t1.'ks_guest_ten,';
		$t2=$t2.'"'.$overall_ho_ten.'",';
		$t3=$t3.'ks_guest_ten='.'"'.$overall_ho_ten.'",';
	}
	if(strlen($_POST['overall_email'])>1) {
		$overall_email=$_POST['overall_email'];
		$t1=$t1.'ks_guest_email,';
		$t2=$t2.'"'.$overall_email.'",';
		$t3=$t3.'ks_guest_email='.'"'.$overall_email.'",';
	}
	if(strlen($_POST['overall_dien_thoai'])>1) {
		$overall_dien_thoai=$_POST['overall_dien_thoai'];
		$t1=$t1.'ks_guest_tel,';
		$t2=$t2.'"'.$overall_dien_thoai.'",';
		$t3=$t3.'ks_guest_tel='.'"'.$overall_dien_thoai.'",';
	}
	if(strlen($_POST['overall_so_phong'])>1) {
		$overall_so_phong=$_POST['overall_so_phong'];
		$t1=$t1.'ks_guest_so_phong, ';
		$t2=$t2.'"'.$overall_so_phong.'",';
		$t3=$t3.'ks_guest_so_phong= '.'"'.$overall_so_phong.'",';
	}
	if(strlen($_POST['overall_thoi_gian'])>1) {
		$overall_thoi_gian=$_POST['overall_thoi_gian'];
		$t1=$t1.'ks_guest_thoi_gian, ';
		$t2=$t2.'"'.$overall_thoi_gian.'",';
		$t3=$t3.'ks_guest_thoi_gian ='.'"'.$overall_thoi_gian.'",';
	}
	if(strlen($_POST['overall_cong_ty'])>1) {
		$overall_cong_ty=$_POST['overall_cong_ty'];
		$t1=$t1.'ks_guest_cong_ty ';
		$t2=$t2.'"'.$overall_cong_ty.'"';
		$t3=$t3.'ks_guest_cong_ty ='.'"'.$overall_cong_ty.'"';
	}


	if(substr($t1, strlen($t1)-1,1)==',') $t1=substr($t1,0,strlen($t1)-1);
	if(substr($t2, strlen($t2)-1,1)==',') $t2=substr($t2,0,strlen($t2)-1);
	if(substr($t3, strlen($t3)-1,1)==',') $t3=substr($t3,0,strlen($t3)-1);
	echo 't1='.$t1.'<br> t2='.$t2.'<br>t3='.$t3;
	if( (isset($_POST['phieuok'])&&($_POST['phieuok']>0)) || ((isset($_POST['suaphieu'])) && (decodetoken($_POST['suaphieu'])==$_SESSION['token']) ) ){
		if((isset($_POST['suaphieu'])) && (decodetoken($_POST['suaphieu'])==$_SESSION['token']) ){
			$sophieu=decode($_POST['suaphieu']);
			$sql='UPDATE khao_sat SET '.$t3.' WHERE ks_so_phieu='.$sophieu;
			$nhatky='Cập nhật mới phiếu khảo sát số'.$sophieu.' - Cập nhật nội dung phiếu';
		}
		elseif($phieuexist>0){
			$sql='UPDATE khao_sat SET '.$t3.' WHERE ks_so_phieu='.$phieuexist;
			$nhatky='Cập nhật mới phiếu khảo sát số'.$phieuexist.' - lần 1 nhà hàng';
		}
		else{
			$sql='INSERT INTO khao_sat ('.$t1.') VALUES ('.$t2.')';
			$nhatky='Nhà hàng - Tạo mới phiếu khảo sát';
		}
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky($nhatky);	
					header('location: index.php?ylan=phieu_letan&ok=1');
				}
				else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source).'|'.$sql;
	}
}
else{
	$tieudechinh='Phiếu khảo sát khách hàng - lễ tân';
	$tieude_submit='tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;	
}
if(!isset($ngay_khao_sat))  $ngay_khao_sat=date("Y-m-d");
$noidungmau=noiDungMau(2,2);//(2) load nội dung mẫu le tan. (2)tra ve sap xep theo truong ten_sql
//var_dump($noidungmau);
$noidung='';
if(isset($goBack))  $noidung=$noidung.$goBack.'<br><br>';
if(isset($sophieu)) $noidung=$noidung.soPhieu('sophieu',$sophieu);	else $noidung=$noidung.soPhieu('sophieu');
if(isset($ngay_khao_sat)) $noidung=$noidung.ngayKhaoSat('ngay_khao_sat',$ngay_khao_sat); else $noidung=$noidung.ngayKhaoSat('ngay_khao_sat');

	$noidung=$noidung.tieuDe($noidungmau['dangkynhanphong']['noidung']);
			if(isset($checkin_tiep_don)) $noidung=$noidung.chon($noidungmau['ks_checkin_chung']['noidung'],'checkin_tiep_don',$checkin_tiep_don); else $noidung=$noidung.chon($noidungmau['ks_checkin_chung']['noidung'],'checkin_tiep_don'); 
			if(isset($checkin_dang_ky)) $noidung=$noidung.chonYesNo($noidungmau['ks_checkin_nhanh_gon']['noidung'],'checkin_dang_ky',$checkin_dang_ky); else $noidung=$noidung.chonYesNo($noidungmau['ks_checkin_nhanh_gon']['noidung'],'checkin_dang_ky');
			if(isset($checkin_yeu_cau)) $noidung=$noidung.chonYesNo($noidungmau['ks_checkin_yeu_cau']['noidung'],'checkin_yeu_cau',$checkin_yeu_cau); else $noidung=$noidung.chonYesNo($noidungmau['ks_checkin_yeu_cau']['noidung'],'checkin_yeu_cau');
			if(isset($checkin_chao_don)) $noidung=$noidung.chonYesNo($noidungmau['ks_checkin_chao_don']['noidung'],'checkin_chao_don',$checkin_chao_don); else $noidung=$noidung.chonYesNo($noidungmau['ks_checkin_chao_don']['noidung'],'checkin_chao_don');
		$noidung=$noidung.tieuDe($noidungmau['chatluongphongnghi']['noidung']);
			if(isset($room_chung)) $noidung=$noidung.chon($noidungmau['ks_room_chung']['noidung'],'room_chung',$room_chung); else $noidung=$noidung.chon($noidungmau['ks_room_chung']['noidung'],'room_chung'); 
			if(isset($room_thoai_mai))  $noidung=$noidung.chon($noidungmau['ks_room_thoai_mai']['noidung'],'room_thoai_mai',$room_thoai_mai); else $noidung=$noidung.chon($noidungmau['ks_room_thoai_mai']['noidung'],'room_thoai_mai');
			if(isset($room_sach_se)) $noidung=$noidung.chon($noidungmau['ks_room_sach_se']['noidung'],'room_sach_se',$room_sach_se); else $noidung=$noidung.chon($noidungmau['ks_room_sach_se']['noidung'],'room_sach_se');
			if(isset($room_an_toan)) $noidung=$noidung.chon($noidungmau['ks_room_an_toan']['noidung'],'room_an_toan',$room_an_toan); else $noidung=$noidung.chon($noidungmau['ks_room_an_toan']['noidung'],'room_an_toan');
			if(isset($room_anh_sang)) $noidung=$noidung.chonYesNo($noidungmau['ks_room_anh_sang']['noidung'],'room_anh_sang',$room_anh_sang); else $noidung=$noidung.chonYesNo($noidungmau['ks_room_anh_sang']['noidung'],'room_anh_sang');
			if(isset($room_internet)) $noidung=$noidung.chonYesNo($noidungmau['ks_room_internet']['noidung'],'room_internet',$room_internet); else $noidung=$noidung.chonYesNo($noidungmau['ks_room_internet']['noidung'],'room_internet');
			if(isset($room_tot_hon)) $noidung=$noidung.dongTxt($noidungmau['ks_room_tot_hon']['noidung'],'room_tot_hon',$room_tot_hon); else $noidung=$noidung.dongTxt($noidungmau['ks_room_tot_hon']['noidung'],'room_tot_hon');
		$noidung=$noidung.tieuDe($noidungmau['trangthietbikhachsan']['noidung']);	
			if(isset($fac_chung)) $noidung=$noidung.chon($noidungmau['ks_fac_chung']['noidung'],'fac_chung',$fac_chung); else $noidung=$noidung.chon($noidungmau['ks_fac_chung']['noidung'],'fac_chung');
			$noidung=$noidung.tieuDePhu($noidungmau['trungtamtheducthethao']['noidung']);
				if(isset($fac_fit_dich_vu)) $noidung=$noidung.chon($noidungmau['ks_fac_fit_dich_vu']['noidung'],'fac_fit_dich_vu',$fac_fit_dich_vu); else $noidung=$noidung.chon($noidungmau['ks_fac_fit_dich_vu']['noidung'],'fac_fit_dich_vu');
				if(isset($fac_fit_ky_nang)) $noidung=$noidung.chon($noidungmau['ks_fac_fit_ky_nang']['noidung'],'fac_fit_ky_nang',$fac_fit_ky_nang); else $noidung=$noidung.chon($noidungmau['ks_fac_fit_ky_nang']['noidung'],'fac_fit_ky_nang');
				if(isset($fac_fit_trang_bi)) $noidung=$noidung.chon($noidungmau['ks_fac_fit_trang_bi']['noidung'],'fac_fit_trang_bi',$fac_fit_trang_bi); else $noidung=$noidung.chon($noidungmau['ks_fac_fit_trang_bi']['noidung'],'fac_fit_trang_bi'); 
			$noidung=$noidung.tieuDePhu($noidungmau['spa']['noidung']);
				if(isset($fac_spa_dich_vu)) $noidung=$noidung.chon($noidungmau['ks_fac_spa_dich_vu']['noidung'],'fac_spa_dich_vu',$fac_spa_dich_vu); else $noidung=$noidung.chon($noidungmau['ks_fac_spa_dich_vu']['noidung'],'fac_spa_dich_vu');
				if(isset($fac_spa_ky_nang)) $noidung=$noidung.chon($noidungmau['ks_fac_spa_ky_nang']['noidung'],'fac_spa_ky_nang',$fac_spa_ky_nang); else $noidung=$noidung.chon($noidungmau['ks_fac_spa_ky_nang']['noidung'],'fac_spa_ky_nang');
				if(isset($fac_spa_trang_bi)) $noidung=$noidung.chon($noidungmau['ks_fac_spa_trang_bi']['noidung'],'fac_spa_trang_bi',$fac_spa_trang_bi); else $noidung=$noidung.chon($noidungmau['ks_fac_spa_trang_bi']['noidung'],'fac_spa_trang_bi');
			$noidung=$noidung.tieuDePhu($noidungmau['beboi']['noidung']);
				if(isset($fac_swim_dich_vu)) $noidung=$noidung.chon($noidungmau['ks_fac_swim_dich_vu']['noidung'],'fac_swim_dich_vu',$fac_swim_dich_vu); else $noidung=$noidung.chon($noidungmau['ks_fac_swim_dich_vu']['noidung'],'fac_swim_dich_vu');
				if(isset($fac_swim_ky_nang)) $noidung=$noidung.chon($noidungmau['ks_fac_swim_ky_nang']['noidung'],'fac_swim_ky_nang',$fac_swim_ky_nang); else $noidung=$noidung.chon($noidungmau['ks_fac_swim_ky_nang']['noidung'],'fac_swim_ky_nang');
				if(isset($fac_swim_trang_bi)) $noidung=$noidung.chon($noidungmau['ks_fac_swim_trang_bi']['noidung'],'fac_swim_trang_bi',$fac_swim_trang_bi); else $noidung=$noidung.chon($noidungmau['ks_fac_swim_trang_bi']['noidung'],'fac_swim_trang_bi');
			$noidung=$noidung.tieuDePhu($noidungmau['dichvuvanphong']['noidung']);
			
				if(isset($fac_busi_dich_vu)) $noidung=$noidung.chon($noidungmau['ks_fac_busi_dich_vu']['noidung'],'fac_busi_dich_vu',$fac_busi_dich_vu); else $noidung=$noidung.chon($noidungmau['ks_fac_busi_dich_vu']['noidung'],'fac_busi_dich_vu');
			
				if(isset($fac_busi_ky_nang)) $noidung=$noidung.chon($noidungmau['ks_fac_busi_ky_nang']['noidung'],'fac_busi_ky_nang',$fac_busi_ky_nang); else $noidung=$noidung.chon($noidungmau['ks_fac_busi_ky_nang']['noidung'],'fac_busi_ky_nang');
				if(isset($fac_busi_trang_bi)) $noidung=$noidung.chon($noidungmau['ks_fac_busi_trang_bi']['noidung'],'fac_busi_trang_bi',$fac_busi_trang_bi); else $noidung=$noidung.chon($noidungmau['ks_fac_busi_trang_bi']['noidung'],'fac_busi_trang_bi'); 
		$noidung=$noidung.tieuDe($noidungmau['caitienchatluong']['noidung']);
			if(isset($how_dich_vu)) $noidung=$noidung.dongTxt($noidungmau['ks_how_dich_vu']['noidung'],'how_dich_vu',$how_dich_vu); else $noidung=$noidung.dongTxt($noidungmau['ks_how_dich_vu']['noidung'],'how_dich_vu');
			if(isset($how_trang_bi)) $noidung=$noidung.dongTxt($noidungmau['ks_how_trang_bi']['noidung'],'how_trang_bi',$how_trang_bi); else $noidung=$noidung.dongTxt($noidungmau['ks_how_trang_bi']['noidung'],'how_trang_bi');
			if(isset($how_trang_tri)) $noidung=$noidung.dongTxt($noidungmau['ks_how_trang_tri']['noidung'],'how_trang_tri',$how_trang_tri); else $noidung=$noidung.dongTxt($noidungmau['ks_how_trang_tri']['noidung'],'how_trang_tri');
			if(isset($how_khac)) $noidung=$noidung.dongTxt($noidungmau['ks_how_khac']['noidung'],'how_khac',$how_khac); else $noidung=$noidung.dongTxt($noidungmau['ks_how_khac']['noidung'],'how_khac');
		$noidung=$noidung.tieuDe($noidungmau['nhanvienkhachsan']['noidung']);
			if(isset($employ_chung)) $noidung=$noidung.chon($noidungmau['ks_empl_chung']['noidung'],'employ_chung',$employ_chung); else $noidung=$noidung.chon($noidungmau['ks_empl_chung']['noidung'],'employ_chung');
			$noidung=$noidung.tieuDePhu($noidungmau['nhanvienhotro']['noidung']);
				if(isset($employ_tu_tin)) $noidung=$noidung.chonYesNo($noidungmau['ks_empl_tu_tin']['noidung'],'employ_tu_tin',$employ_tu_tin); else $noidung=$noidung.chonYesNo($noidungmau['ks_empl_tu_tin']['noidung'],'employ_tu_tin');
				if(isset($employ_nhanh)) $noidung=$noidung.chonYesNo($noidungmau['ks_empl_hieu_qua']['noidung'],'employ_nhanh',$employ_nhanh); else $noidung=$noidung.chonYesNo($noidungmau['ks_empl_hieu_qua']['noidung'],'employ_nhanh');
				if(isset($employ_chuyen_nghiep)) $noidung=$noidung.chonYesNo($noidungmau['ks_empl_chuyen_nghiep']['noidung'],$employ_chuyen_nghiep); else $noidung=$noidung.chonYesNo($noidungmau['ks_empl_chuyen_nghiep']['noidung'],'employ_chuyen_nghiep');
				if(isset($employ_hai_long)) $noidung=$noidung.chonYesNo($noidungmau['ks_empl_hai_long']['noidung'],'employ_hai_long',$employ_hai_long); else $noidung=$noidung.chonYesNo($noidungmau['ks_empl_hai_long']['noidung'],'employ_hai_long');
				if(isset($employ_mong_doi)) $noidung=$noidung.chonYesNo($noidungmau['ks_empl_mong_doi']['noidung'],'employ_mong_doi',$employ_mong_doi); else $noidung=$noidung.chonYesNo($noidungmau['ks_empl_mong_doi']['noidung'],'employ_mong_doi');
				if(isset($employ_ten_nhan_vien)) $noidung=$noidung.dongTxt($noidungmau['ks_empl_name']['noidung'],'employ_ten_nhan_vien',$employ_ten_nhan_vien); else $noidung=$noidung.dongTxt($noidungmau['ks_empl_name']['noidung'],'employ_ten_nhan_vien');
		tieuDe($noidungmau['hailongchung']['noidung']);
			if(isset($overall_how)) $noidung=$noidung.dongTxt($noidungmau['ks_overall_how']['noidung'],'overall_how',$overall_how); else $noidung=$noidung.dongTxt($noidungmau['ks_overall_how']['noidung'],'overall_how');
			if(isset($overall_chung)) $noidung=$noidung.chon($noidungmau['ks_overall_chung']['noidung'],'overall_chung',$overall_chung); else $noidung=$noidung.chon($noidungmau['ks_overall_chung']['noidung'],'overall_chung');
		$noidung=$noidung.tieuDe($noidungmau['hailongchung']['noidung']);
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

include './views/phieu_letan.phtml';
?>