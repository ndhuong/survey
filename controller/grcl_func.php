<?php
function macDinh($gt1,$gt2){
	if($gt1==$gt2) return ' checked ';
}// hết mặc định
function okNi($arr){
	$ngauNhien=rand();
	$ngauNhien2=$ngauNhien.'H';
	if(isset($arr['value1']) && ($arr['value1']>0)) $value1=$arr['value1']; else $value1=0;
	if(isset($arr['value2']) && ($arr['value2']>0)) $value2=$arr['value2']; else $value2=0;
	if(isset($arr['value_txt_1']) && (strlen($arr['value_txt_1'])>0)) $value_txt_1=$arr['value_txt_1']; else $value_txt_1=NULL;
	if(isset($arr['value_txt_2']) && (strlen($arr['value_txt_2'])>0)) $value_txt_2=$arr['value_txt_2']; else $value_txt_2=NULL;
	$tmp='<br><div class="row dong">
	    <div class="col-sm-4 text4row-left">'.$arr['noidung'].' </div>
	      <div class="col-sm-3 text-center">
	        <div class="radio-group">
	          <input type="radio" id="'.$ngauNhien.'1" name="'.$arr['bien1'].'" value="2" '.macDinh($value1,2).'>
	            <label class="text_radio3" for="'.$ngauNhien.'1">OK</label>
	          <input type="radio" id="'.$ngauNhien.'2" name="'.$arr['bien1'].'" value="0" '.macDinh($value1,0).'>
	            <label class="text_radio3" for="'.$ngauNhien.'2">Nothing</label>
	          <input type="radio" id="'.$ngauNhien.'3" name="'.$arr['bien1'].'" value="1" '.macDinh($value1,1).'>
	            <label class="text_radio3" for="'.$ngauNhien.'3">NI</label>
	        </div>
	        <br>
	        <input type="text" name="'.$arr['bien_txt_1'].'" placeholder="Nhập ghi chú(nếu có)" value="'.$value_txt_1.'">
	      </div>
	      
	      <div class="col-sm-3 text-center">
	        <div class="radio-group">
	          <input type="radio" id="'.$ngauNhien2.'1" name="'.$arr['bien2'].'" value="2" '.macDinh($value2,2).'>
	            <label class="text_radio3" for="'.$ngauNhien2.'1">OK</label>
	          <input type="radio" id="'.$ngauNhien2.'2" name="'.$arr['bien2'].'" value="0" '.macDinh($value2,0).'>
	            <label class="text_radio3" for="'.$ngauNhien2.'2">Nothing</label>
	          <input type="radio" id="'.$ngauNhien2.'3" name="'.$arr['bien2'].'" value="1" '.macDinh($value2,1).'>
	            <label class="text_radio3" for="'.$ngauNhien2.'3">NI</label>
	        </div>
	        <br>
	        <input type="text" name="'.$arr['bien_txt_2'].'" placeholder="Nhập ghi chú(nếu có)" value="'.$value_txt_2.'">
	      </div>
	    </div>';

	return $tmp;
}// hết okNi
function tieuDe($arr){
	global $menu;	
		$random='ndh'.rand();
		$tmp2='<span id="id_'.$random.'" onclick="'.$random.'_script()"> <button> Hiện nội dung</button> </span>
		<script type="text/javascript">
				function '.$random.'_script() {
					if(document.getElementById("'.$random.'").style.display=="none"){
						document.getElementById("'.$random.'").style.display="inline";
						document.getElementById("goTop_'.$random.'").style.display="inline";
						document.getElementById("'.$random.'_top").classList.add("select-bar");
						document.getElementById("id_'.$random.'").innerHTML="<button> Ẩn nội dung</button>";
					}
					else{
						document.getElementById("'.$random.'").style.display="none";
						document.getElementById("goTop_'.$random.'").style.display="none";
						document.getElementById("id_'.$random.'").innerHTML="<button> Hiện nội dung</button>";
						document.getElementById("'.$random.'_top").classList.remove("select-bar");
					}
				};	
			</script>';

		$tmp3='<div class="row"><div class="col-12"></div><div id="'.$random.'" class="select-area" style="display: none">';
		$tmp4='';
	if($menu==0){	
		$tmp4='';
		$menu=1;
	}
	else{
		$tmp4='</div></div>';
	}
	$tmp=$tmp4.'<div class="row dong lienke" id="'.$random.'_top">
	      <div class="col-sm-4 text4caption text-right">'.$arr['noidung'].'</div>
	      <div class="col-sm-4 text4caption">'.$tmp2.' </div>
	      <div class="col-sm-2 go-top-icon" id="goTop_'.$random.'" style="display: none"> <a href="#top" data-toggle="tooltip" title="Lên trên cùng" ><i class="fa fa-arrow-up" aria-hidden="true"></i> </a></div>
	    </div>'.$tmp3;
	
	return $tmp;	
}// end tieuDe
function hoTenNguoiTruc($value=null){
	// trả về họ và tên người trực theo id người trực;
	if($value==null) $hoten='';
	else{
		require './config/config.php';
		$sql='SELECT * FROM truc_mod WHERE tm_id='.$value;
		$query=mysqli_query($source,$sql);
		if($query){
			if(mysqli_num_rows($query)>0){
				$res=mysqli_fetch_array($query);
				$hoten=$res['tm_ten'];
			}else $hoten='.';
		} else $hoten='!';
	}
	return $hoten;
}
//----------------
function nguoiTruc($arr){
	if(isset($arr['value']) && (strlen($arr['value'])>0)) $value=$arr['value']; 
	else $value=NULL;
	require './config/config.php';
	$sql='SELECT * FROM truc_mod ORDER BY tm_ten ASC';
	$query=mysqli_query($source,$sql);
	if($query){
		$list='<select name="'.$arr['bien'].'" class="txt" required > <option value="-1"> Chọn người trực</option>';
		while ($res = mysqli_fetch_array( $query )){
			$list=$list.'<option value="'.$res['tm_id'].'"';
			if($value==$res['tm_id']) $list=$list.'selected';
			$list=$list.'> '.$res['tm_ten'].' </option>';
		}
		$list=$list.'</select>';
	} else $list='';
	$tmp='<div class="row dong">
	      <div class="col-sm-4 text4row-left"> '.$arr['noidung'].'</div>
	      <div class="col-sm-3 text-center">'.$list.'</div>
	    </div>';

	return $tmp;	
}// hết nguoiTruc
function nguoiTruc2($arr){

	if(isset($arr['value'])) $ten=hoTenNguoiTruc($arr['value']); else $ten=null;
	$tmp='<div class="row dong">
      <div class="col-sm-1"> </div>
      <div class="col-sm-8">
        <span class="text4row-left"> '.$arr['noidung'].' </span>
        <span id="ketQua"><input type="text" class="txt" value="'.$ten.'" placeholder="Hãy chọn ca trực" readonly > </span>
      </div>
    </div>';
	return $tmp;	
}// hết nguoiTruc2
function ngayKiemTra($arr){
	if(isset($arr['value'])) {
		$ngay_truc=$arr['value']; 
		$required='';
	}
	else {
		$required=' required ';
		require './config/config.php';
		$date=date("Y-m-d");
		$kiemtra_sql='SELECT grcl_ngay_kiem_tra FROM grcl WHERE grcl_ngay_kiem_tra="'.$date.'"';
		$kiemtra_query=mysqli_query($source,$kiemtra_sql);
		if($kiemtra_query){
			if(mysqli_fetch_array( $kiemtra_query )>0)	$ngay_truc=NULL;
			else $ngay_truc=$date;
		}
		else $ngay_truc=NULL;
	}
	if(is_null($ngay_truc)) $ngay_ok= -1; else $ngay_ok=2;
	
	if(isset($arr['readonly'])) $readonly=' readonly'; else $readonly='';
	$tmp='<div class="row dong">
      <div class="col-sm-4 text4row-left">'.$arr['noidung'].' </div>
      <div class="col-sm-3 text-center">
         
          <input type="date" id="ngaykiemtra" class="txt" name="'.$arr['bien'].'" value="'.$ngay_truc.'" required '.$readonly.' '.$required.'>
      </div>
    </div>
    <div class="row"><div class="col-sm-12 text-center"> <span id="ketQua" > <input type="hidden" name="ngay_ok" value="'.$ngay_ok.'"></span> </div></div>';
	return $tmp;
}// hết ngày kiểm tra
function ngayKiemTra2($arr){
	//global $grcl;
	require './config/config.php';
	if(isset($arr['value1'])) $ngay_truc=$arr['value1']; 
	else $ngay_truc=date('Y-m-d');
	$ngay=date('d');
	$thang=date('m');
	$nam=date('Y');
	$catrucmod=loadCaTruc();
	if($ngay>25){
		if($thang>11){
			$thang_truc=1;
			$nam_truc=$nam+1;
		} else{
			$thang_truc=$thang+1;
			$nam_truc=$nam;
		}
	}else {
		$thang_truc=$thang;
		$nam_truc=$nam;
	}
	if($thang==1) {
		$thang_truoc=12;
		$nam_cua_thang_truoc=$nam-1;
	}else {
		$thang_truoc=$thang-1;
		$nam_cua_thang_truoc=$nam;
	}
	$so_ngay_trong_thang_truoc=cal_days_in_month(CAL_GREGORIAN,$thang_truoc,$nam_cua_thang_truoc);
	$so_ngay_lech=$so_ngay_trong_thang_truoc-25;
	if($ngay>25) $bien_sql=$ngay-25; else $bien_sql=$so_ngay_lech+$ngay;
	$bien_sql='ltm_ngay'.$bien_sql;
	$sql='SELECT '.$bien_sql.' FROM lichtrucmod WHERE (ltm_thang='.$thang_truc.') AND( ltm_nam='.$nam_truc.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$ngay_data=explode(':', $res[$bien_sql]);
		} else{
			$ngay_data['error']=1;
			$ngay_data['status']=' không có lịch trực của ngày '.$ngay.'/'.$thang.'/'.$nam;
		}
	} else {
		$ngay_data['error']=2;
		$ngay_data['status']=' lỗi kết nối csdl'.mysqli_error($source).$sql;
	}
//var_dump($ngay_data);
	if(isset($ngay_data['error'])){
		$select_ca=chonCa($catrucmod,'ca_truc');
	} else{
		$arr_ca=array();
		$select_ca='<select name="ca_truc" class="txt" id="ca_truc"><option value="0"> Chọn ca trực </option>';
		$i=0;
		if(isset($mod_c[1]['value'])) $ca_defaul=$mod_c[1]['value']; else $ca_defaul=0;
		foreach ($ngay_data as $key) {

			$arr_ca[$i]['id_ca']=(int)substr($key,2,2);
			$arr_ca[$i]['id_nguoitruc']=(int)substr($key,0,2);
			$arr_ca[$i]['catruc']=$key;
			if($ca_defaul==$arr_ca[$i]['id_ca']) $tmp2=' selected '; else $tmp2='';
			$select_ca.='<option value="'.$key.'" '.$tmp2.' > '.tenCaTruc($arr_ca[$i]['id_ca']).'</option>';
		}
		$select_ca.='</select>';
	}
	$tmp='<div class="row dong">
      <div class="col-sm-1"> </div>
      <div class="col-sm-10">
        <span class="text4row-left"> '.$arr['noidung'].' 
          <input type="date" name="'.$arr['bien1'].'" class="txt" value="'.$ngay_truc.'" readonly > &emsp; Ca trực '.$select_ca.'
        </span>
      </div>
    </div>';
	
	return $tmp;
	
} // ngày kiem tra 2
function ngayMOD($arr){
	if(isset($arr['value'])) $ngay_truc=$arr['value']; 
	else {
		require './config/config.php';
		$date=date("Y-m-d");
		$kiemtra_sql="SELECT grcl_mod_ngay FROM grcl WHERE (grcl_mod_ngay=".$date.")";
		$kiemtra_query=mysqli_query($source,$kiemtra_sql);
		if($kiemtra_query){
			if(mysqli_fetch_array( $kiemtra_query )>0)	$ngay_truc=NULL;
			else $ngay_truc=$date;
		}
		else $ngay_truc=NULL;
	}
	
	
	if(isset($arr['readonly'])) $readonly=' readonly'; else $readonly='';
	$tmp='<div class="row dong">
      <div class="col-sm-4 text4row-left"> '.$arr['noidung'].'</div>
      <div class="col-sm-3 text-center"> 
          <input type="date" name="'.$arr['bien'].'" value="'.$ngay_truc.'">        
      </div>
    </div>';
	return $tmp;
}
function noiDungText($arr){
	global $menu;
	if(isset($arr['value']) && (strlen($arr['value'])>0)) $value=$arr['value']; 
	else $value=NULL;
	if($menu==1){
		$tmp4='</div></div>';
		$menu=0;
	}		else	$tmp4='';
	$tmp=$tmp4.'<div class="row dong lienke" >
	      
	      <div class="col-sm-4 text4caption text-right">'.$arr['noidung'].'</div>
	      <div class="col-sm-5 text4caption"> <input type="text" name="'.$arr['bien'].'" value="'.$value.'"> </div>
	    </div>';
	
	return $tmp;	
}// end noiDungText
function noiDungText2($arr){
	if(isset($arr['value']) && (strlen($arr['value'])>0)) $value=$arr['value']; 
	else $value=NULL;
	$tmp='<br><div class="row dong " >
	      <div class="col-sm-4 text4row-left">'.$arr['noidung'].'</div>
	      <div class="col-sm-3 text-center"> <input type="text" name="'.$arr['bien'].'" value="'.$value.'"> </div>
	    </div>';
	
	return $tmp;	
}// end noiDungText
function roomName($arr){
	if(isset($arr['value1']) && (strlen($arr['value1'])>0)) $value1=$arr['value1']; 
	else $value1=NULL;
	if(isset($arr['value2']) && (strlen($arr['value2'])>0)) $value2=$arr['value2']; 
	else $value2=NULL;
	
	$tmp='<div class="row dong">
	      <div class="col-sm-4 text4row-left">'.$arr['noidung'].' </div>
	      <div class="col-sm-3 text-center">
	        <input type="text" name="'.$arr['bien1'].'" value="'.$value1.'">
	        <br><i class="fa fa-arrow-down text-primary" ></i>
	       </div>
	       <div class="col-sm-3 text-center">
	        <input type="text" name="'.$arr['bien2'].'" value="'.$value2.'">
	        <br>
	        <i class="fa fa-arrow-down  text-primary"></i>
	       </div>
	       </div>
	    </div>';

	return $tmp;	
}// hết roomName
function taoNoiDung($grcl){	
	global $tieude_submit;
$menu=0;
$noidung='';
for ($i=0; $i < count($grcl); $i++) { 
	switch ($grcl[$i]['type']) {
		case '1':
			$noidung=$noidung.nguoiTruc2($grcl[$i]);
			break;
		case '2':
			$noidung=$noidung.ngayKiemTra2($grcl[$i]);
			break;
		case '3':
			$noidung=$noidung.roomName($grcl[$i]);
			break;
		case '4':
			$noidung=$noidung.tieuDe($grcl[$i]);
			break;
		case '5':
			$noidung=$noidung.okNi($grcl[$i]);
			break;
		case '6':
			$noidung=$noidung.noiDungText($grcl[$i]);
			break;
		case '8':
			$noidung=$noidung.noiDungText2($grcl[$i]);
			break;
		case '9':
			$noidung=$noidung.ngayMOD($grcl[$i]);
			break;
	}
}
$noidung=$noidung.'</div></div><br>';
$noidung=$noidung.'<div class="row">
            <div class="col-sm-12  text-center ">
                 <input type="submit" id="submit" class="submitbutton" value="'.$tieude_submit.'" name="submit" > 
                 <p></p>
            </div>
        </div>';
return $noidung;
}
//-----------------------
function loadCaTruc(){
	//Trả về mảng chứa thông tin các ca trực
	// [id]= id ca trực
	// [ten]= tên ca trực
	// [kyhieu]= Ký hiệu ca trực
	// [ghichu]= ghi chú về ca trực
	require './config/config.php';
	$danhsach_sql='SELECT * FROM catrucmod';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach['error']=1; // không có ca trực nào cả
		}
		else{
			$danhsach=array();
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$tmp=array();
				$tmp['id']=(int)$result['ca_id'];
				$tmp['ten']=$result['ca_ten'];
				$tmp['kyhieu']=$result['ca_ky_hieu'];
				$tmp['ghichu']=$result['ca_ghi_chu'];
				$danhsach[]=$tmp;
			}
		}
	}else $danhsach['error']=2; // không có kết nối đc CSDL 
	return $danhsach;
} // hết loadCaTruc;
function chonCa($danhsachca,$ten_bien){
	// trả về hộp thoại select dùng chọn các ca
	// value = id ngươi trực(2 ký tự) . $id ca(2 ký tự) (chuỗi 4 ký tự)
	$tmp='<select name="'.$ten_bien.'" class="txt"><option value="0"> &nbsp; </option> ';
	$i=0;
	foreach ($danhsachca as $key) {
		if($i==0) {
			$selected=' selected '; 
			$i++;
		} else $selected='';
		$tmp.='<option value="'.$key['id'].'" '.$selected.'>'.$key['ten'].'</option>';
	}
	$tmp.='</select>';
	return $tmp;
} // hết chonCa
function tenCaTruc($id_ca){
	require './config/config.php';
	$sql='SELECT * FROM catrucmod WHERE ca_id='.$id_ca;
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$tenca=$res['ca_ten'];
		} else $tenca='';
	}else	$tenca='';
	return $tenca;
} // hết tencatruc;
function kiemTraNgayTruc($ngay,$ca){
	$ngay=date_format(date_create($ngay),'Y-m-d');
	require './config/config.php';
	$sql='SELECT grcl_id FROM grcl WHERE (grcl_ngay_kiem_tra="'.$ngay.'") AND (grcl_ngay_kiem_tra='.$ca.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$exist=true;
		} else $exist=false;
	}
	return $exist;
} // hết kiemTraNgayTruc
function selectThang($bien='thang',$default=0){
	$tmp='<select name="'.$bien.'" id="'.$bien.'" class="txt"><option value="0"> Chọn tháng </option>';
	if($default==0) $default=date('m');
	for ($i=1; $i <=12 ; $i++) { 
		if($i==$default) $selected=' selected '; else $selected='';
		$tmp.='<option value="'.$i.'" '.$selected.' > Tháng '.$i.' </option>';
	}
	$tmp.='</select>';
	return $tmp;
} // hết  selectThang
function selectNam($bien='nam',$default=0){
	$tmp='<select name="'.$bien.'" id="'.$bien.'" class="txt"><option value="0"> Chọn năm </option>';
	if($default==0) $default=date('Y');
	for ($i=2017; $i <2025 ; $i++) { 
		if($i==$default) $selected=' selected '; else $selected='';
		$tmp.='<option value="'.$i.'" '.$selected.' > năm '.$i.' </option>';
	}
	$tmp.='</select>';
	return $tmp;
} // hết  selectNam
function ketQuaTrucMod($thang=null,$nam=null){
	
	//echo 'Tháng: '.$thang.' - năm: '.$nam;
	require './config/config.php';
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	if($thang==1) {
		$thang_truoc=12;
		$nam_cua_thang_truoc=$nam-1;
	}else {
		$thang_truoc=$thang-1;
		$nam_cua_thang_truoc=$nam;
	}
	$so_ngay_trong_thang_truoc=cal_days_in_month(CAL_GREGORIAN,$thang_truoc,$nam_cua_thang_truoc);
	$so_ngay_lech=$so_ngay_trong_thang_truoc-25;// vì tính ngày 26 là ngày bắt đầu của tháng mới
		
	$ngaybatdau=$nam_cua_thang_truoc.'-'.$thang_truoc.'-25';// 
	$ngayketthuc=$nam.'-'.$thang.'-26';
	// tìm các ngày từ sau ngày 25 tháng trước đến trước ngày 26 tháng này.
	$sql='SELECT grcl_id,grcl_nguoi_kiem_tra,grcl_ca_truc, grcl_ngay_kiem_tra FROM grcl WHERE (grcl_ngay_kiem_tra >"'.$ngaybatdau.'") AND( grcl_ngay_kiem_tra < "'.$ngayketthuc.'") ORDER BY grcl_ngay_kiem_tra ASC';
	$ngay=array();
	$ngay2=array();
	$query=mysqli_query($source,$sql);
	if($query){
		if (mysqli_num_rows($query)>0){
			while ($res=mysqli_fetch_array($query)) {
				$n=(int)substr($res['grcl_ngay_kiem_tra'],8,2);
				$ngay2[$n]=$res['grcl_ngay_kiem_tra'];
				$ca=$res['grcl_ca_truc'];
				$nguoi=$res['grcl_nguoi_kiem_tra'];
				if(strlen($ca)<2) $ca='0'.$ca;
				if(strlen($nguoi)<2) $nguoi='0'.$nguoi;
				$trucca=$nguoi.$ca;
				if(!isset($m)) $m=$n;
				if(isset($ngay[$m])){
					if($m==$n){
						if(strlen($ngay[$m])>2 ) $ngay[$m].=':'.$trucca;
						else $ngay[$m]=$trucca;
					} else {
						$m=$n;
						$ngay[$m]=$trucca;
					}
				} else{
					$m=$n;
					$ngay[$m]=$trucca;
				}
			}
		} else {
			$ngay['error']=1;
			$ngay['status']='<div class="alert alert-info  text-center">Không có ca trực nào trong tháng '.$thang.'/'.$nam.'</div>';
			$ngay2['error']=1;
		} 
	} else {
		$ngay2['error']=2;
		$ngay['error']=2; 
		$ngay['status']='<div class="alert alert-info  text-center">Không kết nối đc với CSDL</div>'.mysqli_error($source);
	}
	if(isset($ngay['error'])){
		$trave=$ngay['status'];
	}else {
		$trave='<div class="table-responsive"><table class="table">';
		$trave.='<tr class="bg-success">
				<th class="text-center cell-date" colspan="'.$so_ngay_lech .'"> Tháng '.$thang_truoc.' - '.$nam_cua_thang_truoc.'</th><th class="text-center cell-date" colspan="25"> Tháng '.$thang.' - '.$nam.'</th></tr>
				<tr class="bg-success">';
		$dinh_dang_ngay=array();
		for ($i=1; $i <= $so_ngay_trong_thang_truoc; $i++) { 	
			if(($i+25)<=$so_ngay_trong_thang_truoc){
				$ngaytruc=$i+25;
				$thang_truc=$thang_truoc;
				$nam_truc=$nam_cua_thang_truoc;
			}  else {
				$ngaytruc=$i-$so_ngay_lech;
				$thang_truc=$thang;
				$nam_truc=$nam;
			}
			$timedata=cal_to_jd(CAL_GREGORIAN,$thang_truc,$ngaytruc,$nam_truc);
			$wd=jddayofweek($timedata,0);
			if($wd==0)	$day_style='text-center badge-danger text-white';
			else $day_style='text-center ';
			if($ngaytruc<10) $ngaytruc='0'.$ngaytruc;
			$dinh_dang_ngay[$i]=$day_style;
			$trave.='<th class="'.$day_style.' cell-date"> &nbsp;'.$ngaytruc.'&nbsp; </th>';
		}
		$trave.='</tr><tr>';
		$catruc=loadCaTruc();
		for ($i=1; $i <= $so_ngay_trong_thang_truoc; $i++) {  
			if(($i+25)<=$so_ngay_trong_thang_truoc)	$ngaytruc=$i+25;
			else $ngaytruc=$i-$so_ngay_lech;
			$trave.='<td class="'.$dinh_dang_ngay[$i].'">';
			if(isset($ngay[$ngaytruc])){
				$tmp=explode(':',$ngay[$ngaytruc]);
				$j=0;
				foreach ($tmp as $key) {
					$nguoi=(int)substr($key,0,2);
					$ca=(int)substr($key,2,2);
					$ca_ten='';
					$ca_kyhieu='';
					$ca_ghichu='';
					foreach ($catruc as $key1 ) {
						if($key1['id']==$ca){
							$ca_ten=$key1['ten'];
							$ca_kyhieu=$key1['kyhieu'];
							$ca_ghichu=$key1['ghichu'];
						}
					}					
					$tennguoitruc=hoTenNguoiTruc($nguoi);
					if($j>0) $trave.='<br>';
					$link='./grcl_xem&id='.strtotime($ngay2[$ngaytruc]).'&c='.$ca;
					$tooltip='data-toggle="tooltip" title=" Người trực: '.$tennguoitruc.' - '.$ca_ten.' - '.$ca_ghichu.'"';
					if(strlen($ca_kyhieu)<2) $ca_kyhieu.='&nbsp;';
					$trave.='<a class="btn btn-secondary" href="'.$link.'" '.$tooltip.' >'.$ca_kyhieu.'</a>';
					$j++;
					
				}
			} 
			$trave.='</td>';
		}
		$trave.='</tr>';
  		$trave.='</table></div>';
	}
	return $trave;
} // hết ketQuaTrucMod
/*
span class="fa-stack fa-lg">
	        <i class="fa fa-arrow-down fa-stack-1x"></i>
	        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw fa-stack-2x text-danger"></i>
	        </span>
*/
?>