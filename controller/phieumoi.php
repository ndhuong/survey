<?php
function macDinh($gt1,$gt2){
if($gt1==$gt2) return ' checked ';
}
function kiemTra($tmp){
	if(!empty($tmp)) return $tmp;
}
function chon($text,$name,$default='9'){
	$tmp2='H_'.rand();
	$tmp ='<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left">'.$text.'</span><br>
			<span class="text-center"> 
				<span>
				<input id="'.$tmp2.'5" name="'.$name.'" value="5" type="radio" class="with-font" '.macDinh($default,5).' />
    			<label for="'.$tmp2.'5">5 &emsp; </label>
    			</span>
    			<span>
				<input id="'.$tmp2.'4" name="'.$name.'" value="4" type="radio" class="with-font" '.macDinh($default,4).' />
    			<label for="'.$tmp2.'4">4 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'3" name="'.$name.'" value="3" type="radio" class="with-font" '.macDinh($default,3).' />
    			<label for="'.$tmp2.'3">3 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'2" name="'.$name.'" value="2" type="radio" class="with-font" '.macDinh($default,2).' />
    			<label for="'.$tmp2.'2">2 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'1" name="'.$name.'" value="1" type="radio" class="with-font" '.macDinh($default,1).' />
    			<label for="'.$tmp2.'1">1 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'0" name="'.$name.'" value="9" type="radio" class="with-font" '.macDinh($default,9).' />
    			<label for="'.$tmp2.'0">Không ý kiến </label>
				</span>
    			


			</span>
		</div>
	</div>';
	echo $tmp;
}
function chonYesNo($text,$name,$default='9'){
	$tmp2='H_'.rand();
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left">'.$text.'</span><br>
			<span class="text-center"> 
				<span>
    			<input id="'.$tmp2.'2" name="'.$name.'" value="2" type="radio" class="with-font" '.macDinh($default,2).' />
    			<label for="'.$tmp2.'2">Có &emsp;</label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'1" name="'.$name.'" value="1" type="radio" class="with-font" '.macDinh($default,1).' />
    			<label for="'.$tmp2.'1">Không &emsp;</label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'0" name="'.$name.'" value="9" type="radio" class="with-font" '.macDinh($default,9).' />
    			<label for="'.$tmp2.'0">Không ý kiến </label>
				</span>
			</span>
		</div>
	</div>';
	echo $tmp;
}
function dongTxt($text,$name,$default=''){
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left">'.$text.'</span><br>
			<span class="text-center"> 
				<input type="text" name="'.$name.'" placeholder="" value="'.$default.'" class="txt">
			</span>
		</div>
	</div>';
	echo $tmp;
}
function soPhieu($name,$default='-1'){
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left"> Số phiếu khảo sát ý kiến khách hàng</span><br>
			<span class="text-center"> 
				<input type="number" name="'.$name.'" id="sophieu" placeholder="Nhập số phiếu" ';
	if($default>0) $tmp=$tmp.' value="'.$default.'" readonly ';
	else $tmp=$tmp.' value="" required';
			$tmp=$tmp.' class="txt" min="1">
			</span>';
	if($default>0) $tmp=$tmp.'<input type=hidden name="suaphieu" value="'.encode($default).'">';
	$tmp=$tmp.'<span id="ketQua"> </span>	
		</div>
	</div>';
	echo $tmp;
}
function ngayKhaoSat($name,$default=NULL){
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left"> Ngày khảo sát</span><br>
			<span class="text-center"> 
				<input type="date" name="'.$name.'" ';
	if(!is_null($default)) $tmp=$tmp.' value="'.$default.'" ';
	else $tmp=$tmp.' value=""  ';
			$tmp=$tmp.' required class="txt">
			</span>
			
		</div>
	</div>';
	echo $tmp;
}
function tieuDe($text){
	echo '<br><div class="row">
		<div class="col-sm-2"> </div>
		<div class="col-sm-6 text1">
			'.$text.'
			
		</div>
	</div>';
}
function tieuDe2($text){
	echo '<br><div class="row">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6 text2">
			'.$text.'
			
		</div>
	</div>';
}
// hết các function
if(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$tieudechinh = 'Cập nhật Phiếu khảo sát khách hàng';
	$tieude_submit = 'cập nhật phiếu';
	$sql= 'SELECT * FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$res = mysqli_fetch_array( $query );
		// load nội dung mẫu
		//$mau=noiDungMau();
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
		$rest_chung=$res['ks_rest_chung'];
		$rest_dich_vu=$res['ks_rest_dich_vu'];
		$rest_do_an=$res['ks_rest_do_an'];
		$rest_do_uong=$res['ks_rest_do_uong'];
		$rest_trang_tri=$res['ks_rest_trang_tri'];
		$how_an_uong=$res['ks_how_an_uong'];
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
	}
}

elseif((isset($_POST['submit'])) && ($_POST['token']=$_SESSION['token']) && (isset($_POST['suaphieu']))){
	$id=decode($_POST['suaphieu']);
	$t1='';
	$ngay_khao_sat=$_POST['ngay_khao_sat'];
	$t1=$t1.'ks_ngay_khao_sat="'.$ngay_khao_sat.'",';
	if(!empty($_POST['checkin_tiep_don'])){
		$checkin_tiep_don=$_POST['checkin_tiep_don'];
		$t1=$t1.'ks_checkin_chung='.$checkin_tiep_don.',';
	}
	if(!empty($_POST['checkin_dang_ky'])){
		$checkin_dang_ky=$_POST['checkin_dang_ky'];
		$t1=$t1.'ks_checkin_nhanh_gon='.$checkin_dang_ky.',';
	}
	if(!empty($_POST['checkin_yeu_cau'])){
		$checkin_yeu_cau=$_POST['checkin_yeu_cau'];
		$t1=$t1.'ks_checkin_yeu_cau='.$checkin_yeu_cau.',';
	}
	if(!empty($_POST['checkin_chao_don'])){
		$checkin_chao_don=$_POST['checkin_chao_don'];
		$t1=$t1.'ks_checkin_chao_don='.$checkin_chao_don.',';
	}
	if(!empty($_POST['room_chung'])){
		$room_chung=$_POST['room_chung'];
		$t1=$t1.'ks_room_chung='.$room_chung.',';
	}
	if(!empty($_POST['room_thoai_mai'])){
		$room_thoai_mai=$_POST['room_thoai_mai'];
		$t1=$t1.'ks_room_thoai_mai='.$room_thoai_mai.',';
	}
	if(!empty($_POST['room_sach_se'])){
		$room_sach_se=$_POST['room_sach_se'];
		$t1=$t1.'ks_room_sach_se='.$room_sach_se.',';
	}
	if(!empty($_POST['room_an_toan'])){
		$room_an_toan=$_POST['room_an_toan'];
		$t1=$t1.'ks_room_an_toan='.$room_an_toan.',';
	}
	if(!empty($_POST['room_anh_sang'])){
		$room_anh_sang=$_POST['room_anh_sang'];
		$t1=$t1.'ks_room_anh_sang='.$room_anh_sang.',';
	}
	if(!empty($_POST['room_internet'])){
		$room_internet=$_POST['room_internet'];
		$t1=$t1.'ks_room_internet='.$room_internet.',';
	}	
	if(strlen($_POST['room_tot_hon'])>1){
		$room_tot_hon=$_POST['room_tot_hon'];
		$t1=$t1.'ks_room_tot_hon="'.$room_tot_hon.'",';
	}	
	if(!empty($_POST['fac_chung'])){
		$fac_chung=$_POST['fac_chung'];
		$t1=$t1.'ks_fac_chung='.$fac_chung.',';
	}
	if(!empty($_POST['fac_fit_dich_vu'])){
		$fac_fit_dich_vu=$_POST['fac_fit_dich_vu'];
		$t1=$t1.'ks_fac_fit_dich_vu='.$fac_fit_dich_vu.',';
	}
	if(!empty($_POST['fac_fit_ky_nang'])){
		$fac_fit_ky_nang=$_POST['fac_fit_ky_nang'];
		$t1=$t1.'ks_fac_fit_ky_nang='.$fac_fit_ky_nang.',';
	}
	if(!empty($_POST['fac_fit_trang_bi'])){
		$fac_fit_trang_bi=$_POST['fac_fit_trang_bi'];
		$t1=$t1.'ks_fac_fit_trang_bi='.$fac_fit_trang_bi.',';
	}
	if(!empty($_POST['fac_spa_dich_vu'])){
		$fac_spa_dich_vu=$_POST['fac_spa_dich_vu'];
		$t1=$t1.'ks_fac_spa_dich_vu='.$fac_spa_dich_vu.',';
	}
	if(!empty($_POST['fac_spa_ky_nang'])){
		$fac_spa_ky_nang=$_POST['fac_spa_ky_nang'];
		$t1=$t1.'ks_fac_spa_ky_nang='.$fac_spa_ky_nang.',';
	}
	if(!empty($_POST['fac_spa_trang_bi'])){
		$fac_spa_trang_bi=$_POST['fac_spa_trang_bi'];
		$t1=$t1.'ks_fac_spa_trang_bi='.$fac_spa_trang_bi.',';
	}
	if(!empty($_POST['fac_swim_dich_vu'])){
		$fac_swim_dich_vu=$_POST['fac_swim_dich_vu'];
		$t1=$t1.'ks_fac_swim_dich_vu='.$fac_swim_dich_vu.',';
	}
	if(!empty($_POST['fac_swim_ky_nang'])){
		$fac_swim_ky_nang=$_POST['fac_swim_ky_nang'];
		$t1=$t1.'ks_fac_swim_ky_nang='.$fac_swim_ky_nang.',';
	}
	if(!empty($_POST['fac_swim_trang_bi'])){
		$fac_swim_trang_bi=$_POST['fac_swim_trang_bi'];
		$t1=$t1.'ks_fac_swim_trang_bi='.$fac_swim_trang_bi.',';
	}
	if(!empty($_POST['fac_busi_dich_vu'])){
		$fac_busi_dich_vu=$_POST['fac_busi_dich_vu'];
		$t1=$t1.'ks_fac_busi_dich_vu='.$fac_busi_dich_vu.',';
	}
	if(!empty($_POST['fac_busi_ky_nang'])){
		$fac_busi_ky_nang=$_POST['fac_busi_ky_nang'];
		$t1=$t1.'ks_fac_busi_ky_nang='.$fac_busi_ky_nang.',';
	}
	if(!empty($_POST['fac_busi_trang_bi'])){
		$fac_busi_trang_bi=$_POST['fac_busi_trang_bi'];
		$t1=$t1.'ks_fac_busi_trang_bi='.$fac_busi_trang_bi.',';
	}
	if(!empty($_POST['rest_chung'])){
		$rest_chung=$_POST['rest_chung'];
		$t1=$t1.'ks_rest_chung='.$rest_chung.',';
	}
	if(!empty($_POST['rest_dich_vu'])){
		$rest_dich_vu=$_POST['rest_dich_vu'];
		$t1=$t1.'ks_rest_dich_vu='.$rest_dich_vu.',';
	}
	if(!empty($_POST['rest_do_an'])){
		$rest_do_an=$_POST['rest_do_an'];
		$t1=$t1.'ks_rest_do_an='.$rest_do_an.',';
	}
	if(!empty($_POST['rest_do_uong'])){
		$rest_do_uong=$_POST['rest_do_uong'];
		$t1=$t1.'ks_rest_do_uong='.$rest_do_uong.',';
	}
	if(!empty($_POST['rest_trang_tri'])){
		$rest_trang_tri=$_POST['rest_trang_tri'];
		$t1=$t1.'ks_rest_trang_tri='.$rest_trang_tri.',';
	}
	if(strlen($_POST['how_an_uong'])>1){
		$how_an_uong=$_POST['how_an_uong'];
		$t1=$t1.'ks_how_an_uong="'.$how_an_uong.'",';
	}
	if(strlen($_POST['how_dich_vu'])>1){
		$how_dich_vu=$_POST['how_dich_vu'];
		$t1=$t1.'ks_how_dich_vu="'.$how_dich_vu.'",';
	}
	if(strlen($_POST['how_trang_bi'])>1){
		$how_trang_bi=$_POST['how_trang_bi'];
		$t1=$t1.'ks_how_trang_bi="'.$how_trang_bi.'",';
	}
	if(strlen($_POST['how_trang_tri'])>1){
		$how_trang_tri=$_POST['how_trang_tri'];
		$t1=$t1.'ks_how_trang_tri="'.$how_trang_tri.'",';
	}
	if(strlen($_POST['how_khac'])>1){
		$how_khac=$_POST['how_khac'];
		$t1=$t1.'ks_how_khac="'.$how_khac.'",';
	}
	if(!empty($_POST['employ_chung'])){
		$employ_chung=$_POST['employ_chung'];
		$t1=$t1.'ks_empl_chung='.$employ_chung.',';
	}
	if(!empty($_POST['employ_tu_tin'])){
		$employ_tu_tin=$_POST['employ_tu_tin'];
		$t1=$t1.'ks_empl_tu_tin='.$employ_tu_tin.',';
	}
	if(!empty($_POST['employ_nhanh'])){
		$employ_nhanh=$_POST['employ_nhanh'];
		$t1=$t1.'ks_empl_hieu_qua='.$employ_nhanh.',';
	}
	if(!empty($_POST['employ_chuyen_nghiep'])){
		$employ_chuyen_nghiep=$_POST['employ_chuyen_nghiep'];
		$t1=$t1.'ks_empl_chuyen_nghiep='.$employ_chuyen_nghiep.',';
	}
	if(!empty($_POST['employ_hai_long'])){
		$employ_hai_long=$_POST['employ_hai_long'];
		$t1=$t1.'ks_empl_hai_long='.$employ_hai_long.',';
	}
	if(!empty($_POST['employ_mong_doi'])){
		$employ_mong_doi=$_POST['employ_mong_doi'];
		$t1=$t1.'ks_empl_mong_doi='.$employ_mong_doi.',';
	}	
	if(strlen($_POST['employ_ten_nhan_vien'])>1){
		$employ_ten_nhan_vien=$_POST['employ_ten_nhan_vien'];
		$t1=$t1.'ks_empl_name="'.$employ_ten_nhan_vien.'",';
	}	
	if(!empty($_POST['overall_chung'])){
		$overall_chung=$_POST['overall_chung'];
		$t1=$t1.'ks_overall_chung='.$overall_chung.',';
	}
	if(strlen($_POST['overall_how'])>1){
		$overall_how=$_POST['overall_how'];
		$t1=$t1.'ks_overall_how="'.$overall_how.'",';
	}
	if(strlen($_POST['overall_ho_ten'])>1){
		$overall_ho_ten=$_POST['overall_ho_ten'];
		$t1=$t1.'ks_guest_ten="'.$overall_ho_ten.'",';
	}
	if(strlen($_POST['overall_email'])>1){
		$overall_email=$_POST['overall_email'];
		$t1=$t1.'ks_guest_email="'.$overall_email.'",';
	}
	if(strlen($_POST['overall_dien_thoai'])>1){
		$overall_dien_thoai=$_POST['overall_dien_thoai'];
		$t1=$t1.'ks_guest_tel="'.$overall_dien_thoai.'",';
	}
	if(strlen($_POST['overall_so_phong'])>1){
		$overall_so_phong=$_POST['overall_so_phong'];
		$t1=$t1.'ks_guest_so_phong="'.$overall_so_phong.'",';
	}
	if(strlen($_POST['overall_thoi_gian'])>1){
		$overall_thoi_gian=$_POST['overall_thoi_gian'];
		$t1=$t1.'ks_guest_thoi_gian="'.$overall_thoi_gian.'",';
	}
	if(strlen($_POST['overall_cong_ty'])>1){
		$overall_cong_ty=$_POST['overall_cong_ty'];
		$t1=$t1.'ks_guest_cong_ty="'.$overall_cong_ty.'"';
	}
	
	if(substr($t1, strlen($t1)-1,1)==',') $t1=substr($t1,0,strlen($t1)-1);
	$sql='UPDATE khao_sat SET '.$t1.' WHERE ks_so_phieu='.$id;
	$query=mysqli_query($source,$sql);
	if ($query)	{
		nhatky('Cập nhật phiếu khảo sát số: '.$id.' - Ngày'.$ngay_khao_sat);	
		header('location: index.php?ylan=xemphieu&ok=1');
	}
	else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source).'|'.$sql;	
}

elseif(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$sophieu=$_POST['sophieu'];
		$t1='ks_so_phieu,';
		$t2=$sophieu.',';
	$ngay_khao_sat=$_POST['ngay_khao_sat'];
		$t1=$t1.'ks_ngay_khao_sat,';
		$t2=$t2.'"'.$ngay_khao_sat.'",';
	if(!empty($_POST['checkin_tiep_don'])){
		$checkin_tiep_don=$_POST['checkin_tiep_don'];
		$t1=$t1.'ks_checkin_chung,';
		$t2=$t2.$checkin_tiep_don.',';
	}
	if(!empty($_POST['checkin_dang_ky'])){
		$checkin_dang_ky=$_POST['checkin_dang_ky'];
		$t1=$t1.'ks_checkin_nhanh_gon,';
		$t2=$t2.$checkin_dang_ky.',';
	}
	if(!empty($_POST['checkin_yeu_cau'])){
		$checkin_yeu_cau=$_POST['checkin_yeu_cau'];
		$t1=$t1.'ks_checkin_yeu_cau,';
		$t2=$t2.$checkin_yeu_cau.',';
	}
	if(!empty($_POST['checkin_chao_don'])){
		$checkin_chao_don=$_POST['checkin_chao_don'];
		$t1=$t1.'ks_checkin_chao_don,';
		$t2=$t2.$checkin_chao_don.',';
	}
	if(!empty($_POST['room_chung'])){
		$room_chung=$_POST['room_chung'];
		$t1=$t1.'ks_room_chung,';
		$t2=$t2.$room_chung.',';
	}
	if(!empty($_POST['room_thoai_mai'])){
		$room_thoai_mai=$_POST['room_thoai_mai'];
		$t1=$t1.'ks_room_thoai_mai,';
		$t2=$t2.$room_thoai_mai.',';
	}
	if(!empty($_POST['room_sach_se'])){
		$room_sach_se=$_POST['room_sach_se'];
		$t1=$t1.'ks_room_sach_se,';
		$t2=$t2.$room_sach_se.',';
	}
	if(!empty($_POST['room_an_toan'])){
		$room_an_toan=$_POST['room_an_toan'];
		$t1=$t1.'ks_room_an_toan,';
		$t2=$t2.$room_an_toan.',';
	}
	if(!empty($_POST['room_anh_sang'])){
		$room_anh_sang=$_POST['room_anh_sang'];
		$t1=$t1.'ks_room_anh_sang,';
		$t2=$t2.$room_anh_sang.',';
	}
	if(!empty($_POST['room_internet'])){
		$room_internet=$_POST['room_internet'];
		$t1=$t1.'ks_room_internet,';
		$t2=$t2.$room_internet.',';
	}
	if(strlen($_POST['room_tot_hon'])>1){
		$room_tot_hon=$_POST['room_tot_hon'];
		$t1=$t1.'ks_room_tot_hon,';
		$t2=$t2.'"'.$room_tot_hon.'",';
	}
	if(!empty($_POST['fac_chung'])){
		$fac_chung=$_POST['fac_chung'];
		$t1=$t1.'ks_fac_chung,';
		$t2=$t2.$fac_chung.',';
	}
	if(!empty($_POST['fac_fit_dich_vu'])){
		$fac_fit_dich_vu=$_POST['fac_fit_dich_vu'];
		$t1=$t1.'ks_fac_fit_dich_vu,';
		$t2=$t2.$fac_fit_dich_vu.',';
	}
	if(!empty($_POST['fac_fit_ky_nang'])){
		$fac_fit_ky_nang=$_POST['fac_fit_ky_nang'];
		$t1=$t1.'ks_fac_fit_ky_nang,';
		$t2=$t2.$fac_fit_ky_nang.',';
	}
	if(!empty($_POST['fac_fit_trang_bi'])){
		$fac_fit_trang_bi=$_POST['fac_fit_trang_bi'];
		$t1=$t1.'ks_fac_fit_trang_bi,';
		$t2=$t2.$fac_fit_trang_bi.',';
	}
	if(!empty($_POST['fac_spa_dich_vu'])){
		$fac_spa_dich_vu=$_POST['fac_spa_dich_vu'];
		$t1=$t1.'ks_fac_spa_dich_vu,';
		$t2=$t2.$fac_spa_dich_vu.',';
	}
	if(!empty($_POST['fac_spa_ky_nang'])){
		$fac_spa_ky_nang=$_POST['fac_spa_ky_nang'];
		$t1=$t1.'ks_fac_spa_ky_nang,';
		$t2=$t2.$fac_spa_ky_nang.',';
	}
	if(!empty($_POST['fac_spa_trang_bi'])){
		$fac_spa_trang_bi=$_POST['fac_spa_trang_bi'];
		$t1=$t1.'ks_fac_spa_trang_bi,';
		$t2=$t2.$fac_spa_trang_bi.',';
	}
	if(!empty($_POST['fac_swim_dich_vu'])){
		$fac_swim_dich_vu=$_POST['fac_swim_dich_vu'];
		$t1=$t1.'ks_fac_swim_dich_vu,';
		$t2=$t2.$fac_swim_dich_vu.',';
	}
	if(!empty($_POST['fac_swim_ky_nang'])){
		$fac_swim_ky_nang=$_POST['fac_swim_ky_nang'];
		$t1=$t1.'ks_fac_swim_ky_nang,';
		$t2=$t2.$fac_swim_ky_nang.',';
	}
	if(!empty($_POST['fac_swim_trang_bi'])){
		$fac_swim_trang_bi=$_POST['fac_swim_trang_bi'];
		$t1=$t1.'ks_fac_swim_trang_bi,';
		$t2=$t2.$fac_swim_trang_bi.',';
	}
	if(!empty($_POST['fac_busi_dich_vu'])){
		$fac_busi_dich_vu=$_POST['fac_busi_dich_vu'];
		$t1=$t1.'ks_fac_busi_dich_vu,';
		$t2=$t2.$fac_busi_dich_vu.',';
	}
	if(!empty($_POST['fac_busi_ky_nang'])){
		$fac_busi_ky_nang=$_POST['fac_busi_ky_nang'];
		$t1=$t1.'ks_fac_busi_ky_nang,';
		$t2=$t2.$fac_busi_ky_nang.',';
	}
	if(!empty($_POST['fac_busi_trang_bi'])){
		$fac_busi_trang_bi=$_POST['fac_busi_trang_bi'];
		$t1=$t1.'ks_fac_busi_trang_bi,';
		$t2=$t2.$fac_busi_trang_bi.',';
	}
	if(!empty($_POST['rest_chung'])){
		$rest_chung=$_POST['rest_chung'];
		$t1=$t1.'ks_rest_chung,';
		$t2=$t2.$rest_chung.',';
	}
	if(!empty($_POST['rest_dich_vu'])){
		$rest_dich_vu=$_POST['rest_dich_vu'];
		$t1=$t1.'ks_rest_dich_vu,';
		$t2=$t2.$rest_dich_vu.',';
	}
	if(!empty($_POST['rest_do_an'])){
		$rest_do_an=$_POST['rest_do_an'];
		$t1=$t1.'ks_rest_do_an,';
		$t2=$t2.$rest_do_an.',';
	}
	if(!empty($_POST['rest_do_uong'])){
		$rest_do_uong=$_POST['rest_do_uong'];
		$t1=$t1.'ks_rest_do_uong,';
		$t2=$t2.$rest_do_uong.',';
	}
	if(!empty($_POST['rest_trang_tri'])){
		$rest_trang_tri=$_POST['rest_trang_tri'];
		$t1=$t1.'ks_rest_trang_tri,';
		$t2=$t2.$rest_trang_tri.',';
	}
	if(strlen($_POST['how_an_uong'])>1){
		$how_an_uong=$_POST['how_an_uong'];
		$t1=$t1.'ks_how_an_uong,';
		$t2=$t2.'"'.$how_an_uong.'",';
	}
	if(strlen($_POST['how_dich_vu'])>1){
		$how_dich_vu=$_POST['how_dich_vu'];
		$t1=$t1.'ks_how_dich_vu,';
		$t2=$t2.'"'.$how_dich_vu.'",';
	}
	if(strlen($_POST['how_trang_bi'])>1){
		$how_trang_bi=$_POST['how_trang_bi'];
		$t1=$t1.'ks_how_trang_bi,';
		$t2=$t2.'"'.$how_trang_bi.'",';
	}
	if(strlen($_POST['how_trang_tri'])>1){
		$how_trang_tri=$_POST['how_trang_tri'];
		$t1=$t1.'ks_how_trang_tri,';
		$t2=$t2.'"'.$how_trang_tri.'",';
	}
	if(strlen($_POST['how_khac'])>1){
		$how_khac=$_POST['how_khac'];
		$t1=$t1.'ks_how_khac,';
		$t2=$t2.'"'.$how_khac.'",';
	}
	if(!empty($_POST['employ_chung'])){
		$employ_chung=$_POST['employ_chung'];
		$t1=$t1.'ks_empl_chung,';
		$t2=$t2.$employ_chung.',';
	}
	if(!empty($_POST['employ_tu_tin'])){
		$employ_tu_tin=$_POST['employ_tu_tin'];
		$t1=$t1.'ks_empl_tu_tin,';
		$t2=$t2.$employ_tu_tin.',';
	}
	if(!empty($_POST['employ_nhanh'])){
		$employ_nhanh=$_POST['employ_nhanh'];
		$t1=$t1.'ks_empl_hieu_qua,';
		$t2=$t2.$employ_nhanh.',';
	}
	if(!empty($_POST['employ_chuyen_nghiep'])){
		$employ_chuyen_nghiep=$_POST['employ_chuyen_nghiep'];
		$t1=$t1.'ks_empl_chuyen_nghiep,';
		$t2=$t2.$employ_chuyen_nghiep.',';
	}
	if(!empty($_POST['employ_hai_long'])){
		$employ_hai_long=$_POST['employ_hai_long'];
		$t1=$t1.'ks_empl_hai_long,';
		$t2=$t2.$employ_hai_long.',';
	}
	if(!empty($_POST['employ_mong_doi'])){
		$employ_mong_doi=$_POST['employ_mong_doi'];
		$t1=$t1.'ks_empl_mong_doi,';
		$t2=$t2.$employ_mong_doi.',';
	}
	if(strlen($_POST['employ_ten_nhan_vien'])>1){
		$employ_ten_nhan_vien=$_POST['employ_ten_nhan_vien'];
		$t1=$t1.'ks_empl_name,';
		$t2=$t2.'"'.$employ_ten_nhan_vien.'",';
	}
	if(!empty($_POST['overall_chung'])) {
		$overall_chung=$_POST['overall_chung'];
		$t1=$t1.'ks_overall_chung,';
		$t2=$t2.$overall_chung.',';
	}
	if(strlen($_POST['overall_how'])>1) {
		$overall_how=$_POST['overall_how'];
		$t1=$t1.'ks_overall_how,';
		$t2=$t2.'"'.$overall_how.'",';
	}
	if(strlen($_POST['overall_ho_ten'])>1) {
		$overall_ho_ten=$_POST['overall_ho_ten'];
		$t1=$t1.'ks_guest_ten,';
		$t2=$t2.'"'.$overall_ho_ten.'",';
	}
	if(strlen($_POST['overall_email'])>1) {
		$overall_email=$_POST['overall_email'];
		$t1=$t1.'ks_guest_email,';
		$t2=$t2.'"'.$overall_email.'",';
	}
	if(strlen($_POST['overall_dien_thoai'])>1) {
		$overall_dien_thoai=$_POST['overall_dien_thoai'];
		$t1=$t1.'ks_guest_tel,';
		$t2=$t2.'"'.$overall_dien_thoai.'",';
	}
	if(strlen($_POST['overall_so_phong'])>1) {
		$overall_so_phong=$_POST['overall_so_phong'];
		$t1=$t1.'ks_guest_so_phong, ';
		$t2=$t2.'"'.$overall_so_phong.'",';
	}
	if(strlen($_POST['overall_thoi_gian'])>1) {
		$overall_thoi_gian=$_POST['overall_thoi_gian'];
		$t1=$t1.'ks_guest_thoi_gian, ';
		$t2=$t2.'"'.$overall_thoi_gian.'",';
	}
	if(strlen($_POST['overall_cong_ty'])>1) {
		$overall_cong_ty=$_POST['overall_cong_ty'];
		$t1=$t1.'ks_guest_cong_ty ';
		$t2=$t2.'"'.$overall_cong_ty.'"';
	}

	if(substr($t1, strlen($t1)-1,1)==',') $t1=substr($t1,0,strlen($t1)-1);
	if(substr($t2, strlen($t2)-1,1)==',') $t2=substr($t2,0,strlen($t2)-1);
	//echo 'T1='.$t1.'| T2='.$t2;
	if($_POST['phieuok']<0){
		$error='Đã có số phiếu này rồi, hãy nhập số khác';
		$tieudechinh = 'Phiếu khảo sát khách hàng';
		$tieude_submit = 'tạo phiếu';
		$token =token();
		$_SESSION['token']=$token;
	}
	else{
		$sql='INSERT INTO khao_sat ('.$t1.') VALUES ('.$t2.')';
		$query=mysqli_query($source,$sql);
			if ($query)
				{
					nhatky('Tạo mới khảo sát số: '.$sophieu.' - Ngày'.$ngay_khao_sat);	
					header('location: index.php?ylan=phieumoi&ok=1');
				}
				else $error= "Có lỗi trong quá trình đăng kí". mysqli_error($source).'|'.$sql;
		
	}
}

else{
	$tieudechinh = 'Phiếu khảo sát khách hàng';
	$tieude_submit = 'tạo phiếu';
	$token =token();
	$_SESSION['token']=$token;	
}
if(isset($_GET['ok'] ) ){
	if($_GET['ok']==1) $status='Đã tạo xong phiếu, nhập dữ liệu phiếu mới';
	if($_GET['ok']==2) $status='Đã cập nhật xong phiếu, nhập dữ liệu phiếu mới';
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
include './views/phieumoi.phtml';
?>