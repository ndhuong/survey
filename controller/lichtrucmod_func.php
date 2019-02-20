<?php
function encodeThangNam($thang=null,$nam=null){
	// nhan vao thang, nam, tra ve chuoi da ma hoa
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	$tmp=$nam.$thang;
	$tmp=(int)$tmp+791980;
	$tmp=encode($tmp);
	return $tmp;
}
function decodeThangNam($code){
	// nhập vào chuỗi đã mã hóa, trả về mảng chứa [thang]= tháng. [nam]= năm
	$tmp=decode($code);
	$tmp=(int)$tmp-791980;
	$arr['thang']=(int)substr($tmp,4,2);
	$arr['nam']=(int)substr($tmp,0,4);
	return $arr;
}
function kiemTraQuyen(){
	require './config/config.php';
	$sql='SELECT log_admin,log_bo_phan FROM login WHERE log_id='.$_SESSION['user_id'];
	$query=mysqli_query($source,$sql);
	if($query){
		$res=mysqli_fetch_array($query);
		if($res['log_admin']>0) $tmp=true;
		elseif($res['log_bo_phan']==8 ) $tmp=true; // 8 = id bộ phận nhân sự
		else $tmp=false;
	}
	return $tmp;
}
function macDinh($gt1,$gt2){
	if($gt1==$gt2) return ' checked ';
	else return ' ';
}// hết mặc định
function macDinh2($gt1,$gt2){
	if($gt1==$gt2) return ' selected ';
	else return ' ';
}// hết mặc định
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
function chonCa($danhsachca,$ten_bien,$id_nguoitruc,$giatri=0){
	// trả về hộp thoại select dùng chọn các ca
	// value = id ngươi trực(2 ký tự) . $id ca(2 ký tự) (chuỗi 4 ký tự)
	$tmp='<select name="'.$ten_bien.'"> <option value="0"> &nbsp; </option>';
	foreach ($danhsachca as $key) {
		if(strlen($id_nguoitruc)<2) $id_nguoitruc='0'.$id_nguoitruc;
		if(strlen($key['id'])<2) $id_ca='0'.$key['id']; else $id_ca=$key['id'];
		$value=$id_nguoitruc.$id_ca;
		$tmp.='<option value="'.$value.'" '.macDinh2($giatri,$value).'>'.$key['kyhieu'].'</option>';
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
function loadDanhSachDonVi($default=0){
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi ORDER BY dv_name ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có đơn vị nào cả, hãy tạo đơn vị mới đi';
		}
		else{
			$danhsach='<select name="donvi" class="txt" required> <option value="-1"> &darr; Chọn đơn vị &darr; </option>';
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$danhsach=$danhsach.'<option value="'.$result['dv_id'].'" ';
				if($result['dv_id']==$default) $danhsach=$danhsach.' selected ';
				$danhsach=$danhsach.' > '. $result['dv_name'].' </option>';				
			}
			$danhsach=$danhsach.'</select>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function loadDanhSachDonVi()
//----------------------------------------
function loadDanhSachNguoiTruc($name,$default=-1){
	// trả về dropbox danh sách người trực
	// $name: biến cho select.
	// $default: chọn mặc định 
	require './config/config.php';
	$danhsach_sql='SELECT * FROM truc_mod ORDER BY tm_ten ASC';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có người nào cả, hãy tạo mới đi';
		}
		else{
			$danhsach='<select name="'.$name.'" class="txt" required> <option value="-1"> &darr; Chọn người dùng &darr; </option>';
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$danhsach=$danhsach.'<option value="'.$result['tm_id'].'" ';
				if($result['tm_id']==$default) $danhsach=$danhsach.' selected ';
				$danhsach=$danhsach.' > '. $result['tm_ten'].' </option>';				
			}
			$danhsach=$danhsach.'</select>';
		
		}
	}
	else{
		$danhsach="Có lỗi kết nối CSDL của danh sách người trực";
	}
	return $danhsach;
} // Hết function loadDanhSachNguoiTruc()
//----------------------------------------
function loadNguoiTrucMod(){
	// khởi tạo mảng.
	//Trả về 1 mảng có các phần tử
	//[id] = id của người trực mod
	//[ten] = họ và tên của người trực
	//[donvi]= tên đơn vị của người trực
	//[id_dv]= mã đơn vị của ng trực
	
	require './config/config.php';
	$sql='SELECT * FROM truc_mod ORDER BY tm_donvi DESC';
	$query=mysqli_query($source,$sql);
	$arr=array();
	if($query){
		$stt=0;
		while ($res = mysqli_fetch_array( $query )){
			$arr[$stt]['id']=(int)$res['tm_id'];
			$arr[$stt]['ten']=$res['tm_ten'];
			$arr[$stt]['donvi']=loadTenDonVi($res['tm_donvi']);
			$arr[$stt]['id_dv']=(int)$res['tm_donvi'];
			$stt++;
		}
	}	else $arr['error']='có lỗi.';
	return $arr;
}// hết loadNguoiTrucMod
function loadLichTruc($thang,$nam){
	//lấy thông tin lịch trực ra từ cơ sở dữ liệu
	// [id]= id của bản ghi tháng/năm
	// [songay]= Số ngày trong tháng. vd: t6=30 ngày, T7=31 ngày..
	// [thu]= thứ của ngày 26 trong tháng, gtri 0= Chủ nhật, 1 = thứ 2, 2=thứ 3..
	// [ngay*]= chứa thông tin các ngày từ 26 tháng trc đến 25 tháng sau. *=26,27,28... 25
	// giá trị cua bien ngay se là thông tin ca trực  đc gom thành 4 ký tự 1, ngày có 1 ca sẽ
	// có 4 ký tự, 2 ca = 8 ký tự, 3 ca = 12 ký tự (tương ứng mỗi ng` trực 1 ca)
	require './config/config.php';
	$ngay=array();
	$sql='SELECT * FROM lichtrucmod WHERE (ltm_thang='.$thang.') AND( ltm_nam<='.$nam.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query); 
			$ngay['id']=$res['ltm_id'];
			$ngay['songay']=$res['ltm_so_ngay'];
			$ngay['thu']=$res['ltm_thu1'];
			for ($i=1; $i <=$res['ltm_so_ngay'] ; $i++) { 
				$sql_name='ltm_ngay'.$i;
				$arr_name='ngay'.$i;
				if(strlen($res[$sql_name])>0){
					//$tmp=array();
					$ngay[$arr_name]=$res[$sql_name];
				}
			}	
		} else {
			$ngay['error']=2;// không có lịch trực
			
		}
	} else{
		$ngay['error']=1; // không kết nối đc CSDL
	}
	return $ngay;
} // hết loadLichTruc

function loadLichTruc2($thang=null,$nam=null){
	require './config/config.php';
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	$catruc=loadCaTruc();
	if(isset($catruc['error'])) { $tmp['error']=1; return $tmp;}
	$mang=array();
	foreach ($catruc as $key) {
		$sql='SELECT * FROM lichtrucmod WHERE (ltm_thang='.$thang.') AND( ltm_nam='.$nam.') AND (ltm_ca='.$key['id'].') ORDER BY ltm_ngay ASC';
		$query=mysqli_query($source,$sql);
		if($query){
			if (mysqli_num_rows($query)>0){
				while ($res=mysqli_fetch_array($query)) {
					for ($i=1; $i <= $res['ltm_so_ngay']; $i++) { 
						$bien='ltm_ngay'.$i;
						if($res[$bien]>0) $mang[$key['id']][$i]=$res[$bien];	
					}
				}
			} else $tmp['error']=3; 
		} else  $tmp['error']=2; 
	}
	if(isset($tmp['error'])) return $tmp; else return $mang;
} // hết loadLichTruc2
function loadLichTrucThang($thang=null,$nam=null){
	//lấy thông tin lịch trực ra từ cơ sở dữ liệu
	// trả về bảng HTML 
	// 
	// 
	// 
	// 
	// 
	require './config/config.php';
	if(is_null($nam) || is_null($thang)){
		$nam=date('Y');
		$thang=date('m');
		$ngay=date('d');
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
	} else{
		if(is_null($nam))	$nam=date('Y');
		if(is_null($thang)) $thang=date('m');
		$nam_truc=$nam;
		$thang_truc=$thang;
	}
	
		
	
	//$ngay=array();
	$sql='SELECT * FROM lichtrucmod WHERE (ltm_thang='.$thang_truc.') AND( ltm_nam<='.$nam_truc.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query); 
			$nguoitruc=loadNguoiTrucMod();
			$catruc=loadCaTruc();
			$ngay_data=array();
			for ($i=1; $i <=$res['ltm_so_ngay'] ; $i++) { 
				$sql_name='ltm_ngay'.$i;
				if(strlen($res[$sql_name])>0){
					$tmp=explode(':',$res[$sql_name]);
					$arr=array();
					for ($j=0; $j < count($tmp); $j++)	{
						$arr[$j]['id']=(int)substr($tmp[$j],0,2);
						$tmp1=(int)substr($tmp[$j],2,2);
						foreach ($catruc as $key) {
							if($tmp1==$key['id']) $arr[$j]['ca']=$key['kyhieu'];
						}
					}
					$ngay_data[$i]=$arr;
				}
			} // hết for duyệt lấy dữ liệu ngày từ sql
			for ($i=0; $i < count($nguoitruc); $i++) { 
				$stt=$i+1;	
				$key=$nguoitruc[$i];
				$table_data[$i][0]=$stt.' - '.$key['ten'].' ('.$key['donvi'].' )';
				for ($j=1; $j <=$res['ltm_so_ngay'] ; $j++) {
					if(isset($ngay_data[$j]) && (count($ngay_data[$j])>0)){
						$tmp=$ngay_data[$j];
						for ($k=0; $k < count($tmp) ; $k++) { 
							if($tmp[$k]['id']==$key['id']) $table_data[$i][$j]=$tmp[$k]['ca'];
						}
					}
				}
			}
			$lich=hienLichTruc3($table_data,$thang_truc,$nam_truc);
			if(kiemTraQuyen()) $lich.='<div class="text-center"> <br> <a class="btn btn-secondary" href="./lichtrucmod_update&id='.encodeThangNam($thang,$nam).'"> cập nhật lịch trực MOD </a> &emsp; <a class="btn btn-warning" href="./lichtrucmod_change&id='.encodeThangNam($thang,$nam).'"> Đổi ca trực MOD </a></div>';
		} else {
			$ngay['error']=2;// không có lịch trực
			if(kiemTraQuyen()) $tmp= '<div class="text-center">Không có lịch trực MOD của tháng '.$thang.'/'.$nam.'<br><br><a class="btn btn-secondary" href="./lichtrucmod_cr&id='.encodeThangNam($thang,$nam).'"> tạo mới lịch trực tháng '.$thang.'/'.$nam.' </a></div>';
			else $tmp='Không có lịch trực MOD của tháng '.$thang.'/'.$nam;
			$ngay['status']=$tmp;
		}
	} else{
		$ngay['error']=1; // không kết nối đc CSDL
		$ngay['status']='Không kết nối đc CSDL';
	}
	if(isset($ngay['error'])) return $ngay;	
	return $lich;
} // hết loadLichTrucThang
function loadLichTrucThang2Array($thang=null,$nam=null){
	require './config/config.php';
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	$sql='SELECT * FROM lichtrucmod WHERE (ltm_thang='.$thang.') AND( ltm_nam<='.$nam.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query); 
			$nguoitruc=loadNguoiTrucMod();
			$catruc=loadCaTruc();
			$ngay_data=array();
			for ($i=1; $i <=$res['ltm_so_ngay'] ; $i++) { 
				$sql_name='ltm_ngay'.$i;
				if(strlen($res[$sql_name])>0){
					$tmp=explode(':',$res[$sql_name]);
					$arr=array();
					for ($j=0; $j < count($tmp); $j++)	{
						$arr[$j]['id']=(int)substr($tmp[$j],0,2);
						$tmp1=(int)substr($tmp[$j],2,2);
						foreach ($catruc as $key) {
							if($tmp1==$key['id']) $arr[$j]['ca']=$key['kyhieu'];
						}
					}
					$ngay_data[$i]=$arr;
				}
			} // hết for duyệt lấy dữ liệu ngày từ sql
			for ($i=0; $i < count($nguoitruc); $i++) { 
				$stt=$i+1;	
				$key=$nguoitruc[$i];
				$table_data[$i][0]=$stt.' - '.$key['ten'].' ('.$key['donvi'].' )';
				for ($j=1; $j <=$res['ltm_so_ngay'] ; $j++) {
					if(isset($ngay_data[$j]) && (count($ngay_data[$j])>0)){
						$tmp=$ngay_data[$j];
						for ($k=0; $k < count($tmp) ; $k++) { 
							if($tmp[$k]['id']==$key['id']) $table_data[$i][$j]=$tmp[$k]['ca'];
						}
					}
				}
			}
		} else {
			$table_data['error']=1;
			$table_data['status']='Không có lịch trực của tháng '.$thang.'/'.$nam;
		}
	} else {
		$table_data['error']=2;
		$table_data['status']='Không kết nối đc với CSDL ';
	}
	return $table_data;
}
function nhapLichTrucMoi($thang=null,$nam=null){
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
		
	$nguoitruc=loadNguoiTrucMod(); 
	$ngay_data=array();
	$catruc=loadCaTruc();
	$max_hoten=0;
	$max_donvi=0;
	for ($i=0; $i <=count($nguoitruc); $i++) { 
		if($i==count($nguoitruc)){
			for ($j=0; $j <=$so_ngay_trong_thang_truoc ; $j++) { 
				$ngay_data[$i][$j]='';
			}
			continue;
		}
		$key=$nguoitruc[$i];
		for ($j=0; $j <=$so_ngay_trong_thang_truoc ; $j++) { 
			if($j==0){
				$stt=$i+1;
				$ngay_data[$i][$j]=$stt.' - '.$key['ten'].' ('.$key['donvi'].' )'.$key['id'];
			} else {
				$ten_bien='ngay['.$i.']['.$j.']';
				//if(isset($table_data[$i][$j])) $tmp_val=$table_data[$i][$j]; else $tmp_val=0;
			 	$ngay_data[$i][$j]=chonCa($catruc,$ten_bien,$key['id']);
			}
		}
	}
	$lich=hienLichTruc2($ngay_data,$thang,$nam);
	$lich.='<br><div class="text-center"><input type="submit" class="submitbutton" value=" Tạo mới" name="submit" ></div>';
	return $lich;
} // hết nhập lịch trực mới
function nhapLichTrucMoi2($thang=null,$nam=null){
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
	$nguoitruc=loadNguoiTrucMod(); 
	$catruc=loadCaTruc();
	$sql='SELECT * FROM lichtrucmod WHERE (ltm_thang='.$thang.') AND( ltm_nam<='.$nam.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query); 
			$ngay_sql_data=array();
			for ($i=1; $i <=$res['ltm_so_ngay'] ; $i++) { 
				$sql_name='ltm_ngay'.$i;
				if(strlen($res[$sql_name])>0){
					$ngay_sql_data[$i]=explode(':',$res[$sql_name]);
				}
			} // hết for duyệt lấy dữ liệu ngày từ sql
			for ($i=0; $i < count($nguoitruc); $i++) { 
				$stt=$i+1;	
				$key=$nguoitruc[$i];
				$table_data[$i][0]='';//$value=$id_nguoitruc.$id_ca;
				for ($j=1; $j <=$res['ltm_so_ngay'] ; $j++) {
					if(isset($ngay_sql_data[$j]) && (count($ngay_sql_data[$j])>0)){
						$tmp=$ngay_sql_data[$j];
						for ($k=0; $k < count($tmp) ; $k++) { 
							$t=(int)substr($tmp[$k],0,2);
							if($t==$key['id']) $table_data[$i][$j]=$tmp[$k];
						}
					}
				}
			}
		} else $ngay_sql_data['error']=1;// không có dữ liệu
	} else $ngay_sql_data['error']=2;// không kết nối đc với CSDL
	
	$ngay_data=array();
	
	$max_hoten=0;
	$max_donvi=0;
	for ($i=0; $i <=count($nguoitruc); $i++) { 
		if($i==count($nguoitruc)){
			for ($j=0; $j <=$so_ngay_trong_thang_truoc ; $j++) { 
				$ngay_data[$i][$j]='';
			}
			continue;
		}
		$key=$nguoitruc[$i];
		for ($j=0; $j <=$so_ngay_trong_thang_truoc ; $j++) { 
			if($j==0){
				$stt=$i+1;
				$ngay_data[$i][$j]=$stt.' - '.$key['ten'].' ('.$key['donvi'].' )'.$key['id'];
			} else {
				$ten_bien='ngay['.$i.']['.$j.']';
				if(isset($table_data[$i][$j])) $tmp_val=$table_data[$i][$j]; else $tmp_val=0;
			 	$ngay_data[$i][$j]=chonCa($catruc,$ten_bien,$key['id'],$tmp_val);
			}
		}

	}
	$lich=hienLichTruc2($ngay_data,$thang,$nam);
	return $lich;
} // hết nhập lịch trực mới2
function hienLichTruc2($arr,$thang=null,$nam=null){
	// hiện lịch trực của tháng, năm, dữ liệu lấy từ mảng $arr
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
	$hangngay='<div class="zui-wrapper"><div class="zui-scroller"><table class="zui-table">';
	$hangngay.='<tr class="bg-success">
				<th class="zui-sticky-col"> STT - Họ và tên (Đơn vị)  </th>
				<th class="text-center cell-date" colspan="'.$so_ngay_lech .'"> Tháng '.$thang_truoc.' - '.$nam_cua_thang_truoc.'</th><th class="text-center cell-date" colspan="25"> Tháng '.$thang.' - '.$nam.'</th></tr>
				<tr class="bg-success"><th></th>';
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
		$hangngay.='<th class="'.$day_style.' cell-date"> &nbsp;'.$ngaytruc.'&nbsp; </th>';
	}
	$hangngay.='</tr>';
	//var_dump($arr);
	$t1=count($arr); // dòng
	$t2=count($arr); // cột
	for ($i=0; $i < $t1 ; $i++) { 
		$hangngay.='<tr>';
		for ($j=0; $j <= $so_ngay_trong_thang_truoc; $j++) {
			if($j==0){
				if($i<$t1) $style='zui-sticky-col '; else $style='';
			}  else $style=$dinh_dang_ngay[$j];
			if(isset($arr[$i][$j])) $val=$arr[$i][$j]; else $val='';
			if(($i==$t1-1)&&($j>0)) $hangngay.='<td></td>';
			else $hangngay.='<td class = "'.$style.'">'.$val.'</td>';
		}
		$hangngay.='</tr>';
	}
	
	$hangngay.='</table></div></div>';
	
	return $hangngay;
} // hết hiện lịch2
function hienLichTruc3($arr,$thang=null,$nam=null){
	// hiện lịch trực của tháng, năm, dữ liệu lấy từ mảng $arr
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
	$hangngay='<div class="zui-wrapper"><div class="zui-scroller"><table class="zui-table">';
	$hangngay.='<tr class="bg-success">
				<th class="zui-sticky-col"> STT - Họ và tên (Đơn vị)  </th>
				<th class="text-center cell-date" colspan="'.$so_ngay_lech .'"> Tháng '.$thang_truoc.' - '.$nam_cua_thang_truoc.'</th><th class="text-center cell-date" colspan="25"> Tháng '.$thang.' - '.$nam.'</th></tr>
				<tr class="bg-success"><th></th>';
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
		$hangngay.='<th class="'.$day_style.' cell-date"> &nbsp;'.$ngaytruc.'&nbsp; </th>';
	}
	$hangngay.='</tr>';
	//var_dump($arr);
	$t1=count($arr)+1; // dòng
	$t2=count($arr[0]); // cột
	for ($i=0; $i < $t1 ; $i++) { 
		$hangngay.='<tr>';
		for ($j=0; $j <= $so_ngay_trong_thang_truoc; $j++) {
			if($j==0){
				if($i<$t1) $style='zui-sticky-col1 '; else $style='';
			}  else $style=$dinh_dang_ngay[$j];
			if(isset($arr[$i][$j])) $val=$arr[$i][$j]; else $val='';
			if(($i==$t1-1)&&($j>0)) $hangngay.='<td></td>';
			else $hangngay.='<td class = "'.$style.' cell-date">'.$val.'</td>';
		}
		$hangngay.='</tr>';
	}
	
	$hangngay.='</table></div></div>';
	
	return $hangngay;
} // hết hiện lịch3
//----------------------------------------
function loadTenDonVi($id=0){
	// $id= id của đơn vị
	require './config/config.php';
	$danhsach_sql='SELECT * FROM donvi WHERE dv_id='.$id;
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach=1;//'Không có tên đơn vị này';
		}
		else{
			$result = mysqli_fetch_array( $danhsach_query );
			$danhsach=$result['dv_name'];
		}
	}
	else{
		$danhsach=0;//"Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function loadDanhTenDonVi()
function danhSach(){
	// trả về danh sách người trực mod
	require './config/config.php';
	$danhsach_sql='SELECT * FROM truc_mod';
	$danhsach_query=mysqli_query($source,$danhsach_sql);
	if($danhsach_query){
		if(mysqli_num_rows($danhsach_query)<1){
			$danhsach='Chưa có người nào cả, hãy tạo mới đi';
		}
		else{
			$danhsach='<table class="table-striped">
			<tr><th class="text-center">STT</th>
			<th class="text-center"> Họ và tên </th>
			<th class="text-center"> Đơn vị </th>
			<th class="text-center"> Email </th>
			<th class="text-center"> <span class="fa fa-pencil fa-1x"></span> - Sửa </th>
			<th class="text-center">&nbsp; <span class="fa fa-trash fa-1x"></span> - Xóa </th></tr>';
			$stt=0;
			while ($result = mysqli_fetch_array( $danhsach_query )){
				$stt++;
				$id=encode($result['tm_id']);
				$tmp5="onclick=\"return confirm('Bạn có chắc chắn xóa người này không ?')\" ";
				$sua='<a href="./index.php?ylan=trucmod&sua='.$id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
				$xoa='<a href="./index.php?ylan=trucmod&xoa='.$id.'" '.$tmp5.' ><span class="fa fa-trash fa-1x"></span></a>';
				
				$danhsach=$danhsach.'<tr><td class="text-center">'.$stt.'</td>
							<td class="text-left">'.$result['tm_ten'].'&emsp;</td>
							<td class="text-center">'.loadTenDonVi($result['tm_donvi']).' &emsp;</td>
							<td class="text-center">'.$result['tm_email'].' &emsp;</td>
							<td class="text-center">'.$sua.' </td>
							<td class="text-center">'.$xoa.'  </td></tr>';
			}
			$danhsach=$danhsach.'</table>';
		
		}
	}
	else{
		$danhsach=0;//"Có lỗi kết nối CSDL của danh sách đơn vị";
	}
	return $danhsach;
} // Hết function danhSach():
function loadDanhSachGuiEmail($value=null){
	// trả về danh sách email người trực mod
	// [id]= id người nhận
	// [ten]= Họ và tên người nhận
	// [email] email người nhận
	// =1 dùng để testemail
	if($value==1){
		$danhsach=array();
		$danhsach[0]['id']=0;
		$danhsach[0]['name']='Nguyễn Đức Hưởng';
		$danhsach[0]['email']='itofficer@halong.muongthanh.vn';
		$danhsach[1]['id']=1;
		$danhsach[1]['name']='Nguyễn Đức Hưởng Gmail';
		$danhsach[1]['email']='ndhuongit@gmail.com';
	} else{
		require './config/config.php';
		$sql='SELECT * FROM truc_mod';
		$query=mysqli_query($source,$sql);
		if($query){
			$danhsach=array();
			$danhsach[0]['id']=0;
			$danhsach[0]['name']='Nguyễn Đức Hưởng';
			$danhsach[0]['email']='itofficer@halong.muongthanh.vn';
			$i=1;
			if(mysqli_num_rows($query)>0){
				while ($res=mysqli_fetch_array($query)) {
					$danhsach[$i]['id']=$res['tm_id'];
					$danhsach[$i]['name']=$res['tm_ten'];
					$danhsach[$i]['email']=$res['tm_email'];
					$i++;
				}
			}
		} else $danhsach['error']='có lỗi.'.msqli_error($source);
	}
	
	return $danhsach;
} // hết loadDanhSachGuiEmail
function loadVersion($thang=null,$nam=null){
	require './config/config.php';
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	$sql='SELECT ltm_version FROM lichtrucmod WHERE (ltm_thang='.$thang.') AND( ltm_nam<='.$nam.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$ver=$res['ltm_version'];
		} else $ver=0;
	} else $ver='';
	return $ver;
}
function sendEmailLich($thang=null,$nam=null){
	
	//Hàm này sẽ gửi mail đến tất cả những người trong trực mod về lịch trực mod của tháng/năm
	
	
	include './controller/email.php';
	if(is_null($nam)) $nam=date('Y');
	if(is_null($thang)) $thang=date('m');
	
	$nguoinhan=loadDanhSachGuiEmail(); // để =1 = test ndh
	$nguoitruc=loadNguoiTrucMod();
	$lich=loadLichTrucThang2Array($thang,$nam);
	if(isset($lich['error'])){
		if($lich['error']==1) return 1;
		else return -1;
	} 
	$version=loadVersion($thang,$nam);
	if($thang==1) {
		$thang_truoc=12;
		$nam_cua_thang_truoc=$nam-1;
	}else {
		$thang_truoc=$thang-1;
		$nam_cua_thang_truoc=$nam;
	}
	$so_ngay_trong_thang_truoc=cal_days_in_month(CAL_GREGORIAN,$thang_truoc,$nam_cua_thang_truoc);
	$so_ngay_lech=$so_ngay_trong_thang_truoc-25;// vì tính ngày 26 là ngày bắt đầu của tháng mới
	$ts=' style="color:blue;border-left: 1px solid blue;"'; // table style border-bottom: 1px solid blue;background-color: #f2f2f2;
	$chunhat_style='style="background-color:#FF0000; color:white;" align="center"';
	$ngaythuong_style='style="color:black;" align="center"';
	$nen1='style="background-color:#7FFFFF;"';
	$nen2='style="background-color:#f2f2f2;"';
	$all_colums=$so_ngay_trong_thang_truoc+1;
	if($version >0) $ver=' Cập nhật lần thứ '.$version; else $ver='';
	$hangngay='<br><table><tr> <td colspan="'.$all_colums.'" align="center" > <h3> LỊCH TRỰC MOD THÁNG '.$thang.' NĂM '.$nam.'</h3><i>'.$ver.'</i></td></tr>';

	$hangngay.='<tr '.$nen1.'><th align="center" '.$ts.'> STT - Họ và tên (Đơn vị)  </th>
				<th align="center" '.$ts.' colspan="'.$so_ngay_lech .'"> Tháng '.$thang_truoc.' - '.$nam_cua_thang_truoc.'</th><th align="center" '.$ts.' colspan="25"> Tháng '.$thang.' - '.$nam.'</th></tr>
				<tr '.$nen1.'><th></th>';
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
		if($wd==0)	$day_style=$chunhat_style;
		else $day_style=$ngaythuong_style;
		if($ngaytruc<10) $ngaytruc='0'.$ngaytruc;
		$dinh_dang_ngay[$i]=$day_style;
		$hangngay.='<th '.$day_style.'> &nbsp;'.$ngaytruc.'&nbsp; </th>';
	}
	$hangngay.='</tr>';
	//var_dump($dinh_dang_ngay);
	$max_row=0;
	$t1=count($nguoitruc); // dòng
	$t2=$all_colums; // cột
	for ($i=0; $i < $t1 ; $i++) { 
		if($i % 2 == 0) $bg=$nen2; else $bg='';
		$hangngay.='<tr '.$bg.'>';
		for ($j=0; $j < $t2; $j++) {
			if($j==0){
				$style='';
				if(strlen($lich[$i][$j])>$max_row) $max_row=strlen($lich[$i][$j]);
			}  else $style=$dinh_dang_ngay[$j];
			if(isset($lich[$i][$j])) $val=$lich[$i][$j]; else $val='';
			$hangngay.='<td '.$style.'>'.$val.'</td>';
		}
		$hangngay.='</tr>';
	}
	$hangngay.='<tr><td style="color:white;">';
	for ($i=0; $i < $max_row; $i++) { 
		$hangngay.='_';
	}
	for ($i=1; $i <=$all_colums ; $i++) { 
		$hangngay.='<td></td>';
	}
	$hangngay.='</tr></table>';
	// thêm đoạn diễn giải ca
	// [id]= id ca trực
	// [ten]= tên ca trực
	// [kyhieu]= Ký hiệu ca trực
	// [ghichu]= ghi chú về ca trực
	$catruc=loadCaTruc();
	$hangngay.='<br><b><u><i>Ghi chú:</i></u></b><br>';
	foreach ($catruc as $key) {
		$hangngay.='&emsp;&emsp;<i> <b>'.$key['ten'].':</b> '.$key['ghichu'].'</i><br>';
	}

	// hết diễn giải ca
	if(isset($_SESSION['update'])){
		$hangngay.='<br><b><u><i> Nội dung cập nhật:</i></u></b><br>'.$_SESSION['update'];
	}
	$noidung['tieude']='Lịch trực MOD tháng '.$thang.' năm '.$nam.' '.$ver;
	$noidung['noidung']=$hangngay;
	$ketqua=sendMail($nguoinhan,$noidung);
	if($ketqua['error']>0) nhatky('Gửi email lịch trực mod tháng '.$thang.'/'.$nam.' cho người nhận không thành công.'.$ketqua['status']);
	else {
		$tmp='Danh sách nhận lịch trực MOD tháng '.$thang.'/'.$nam;
		for ($i=0; $i < count($nguoinhan); $i++) { 
			$tmp.='<br>'.$nguoinhan[$i]['name'].' - '.$nguoinhan[$i]['email'];
		}
		nhatky($tmp);
	};
} // end sendEmailLich
function chonNgay($tenbien,$songay){
	$tmp='<select name="'.$tenbien.'" id="'.$tenbien.'" class="txt"> <option value="0"> Chọn ngày </option>';
	if(isset($_SESSION['thang'])){
		if($_SESSION['thang']==1){
			$thang=' - T1';
			$thang_truoc=' - T12';
		} else{
			$thang=' - T'.$_SESSION['thang'];
			$thang_truoc=' - T'.($_SESSION['thang']-1);
		}
	} else{
		$thang='';
		$thang_truoc='';
	}
	for ($i=1; $i <=$songay ; $i++) { 
		if(($i+25)<=$songay) 	$ngaytruc=($i+25).$thang_truoc;  else 	$ngaytruc=($i-($songay-25)).$thang;
		$tmp.='<option value="'.$i.'" > Ngày '.$ngaytruc.'</option>';
	}
	$tmp.='</select>';
	
	return $tmp;
}
?>