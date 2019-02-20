<?php
function okNi($arr){
	
	if(isset($arr['value']) && ($arr['value']>0)) $value1=$arr['value']; 
	else $value1=0;
	if(isset($arr['value_txt']) && (strlen($arr['value_txt'])>0)) $value2=$arr['value_txt']; 
	else $value2=NULL;
	$tmp='<div class="row dong">
	    <div class="col-sm-4 text4row-left">'.$arr['noidung'].' </div>
	      <div class="col-sm-3">';
	        if($value1==2){
	        	$tmp=$tmp.'<button class="btn btn-secondary"> OK </button>';
	        } elseif($value1==1){
	        	$tmp=$tmp.'<button class="btn btn-warning"> NI </button>';
	        } else $tmp=$tmp.'<button class="btn btn-light"> &nbsp; </button>';
	$tmp=$tmp.'</div>
	      <div class="col-sm-4 text4row-right">
	        Ghi chú: '.$value2.'
	      </div>
	    </div>';

	return $tmp;
}// hết okNi
function tieuDe($arr){
	global $menu;
	if(isset($arr['value']) && (strlen($arr['value'])>0)) $value=$arr['value']; 
	else $value=NULL;
	
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
	      <div class="col-sm-1"> </div>
	      <div class="col-sm-4 text4caption">'.$arr['noidung'].'</div>
	      <div class="col-sm-4 text4caption"> Thời gian
	          <input type="time" name="'.$arr['bien'].'" value="'.$value.'" readonly>
	        '.$tmp2.'
	      </div>
	      <div class="col-sm-2 go-top-icon" id="goTop_'.$random.'" style="display: none"> <a href="#top" data-toggle="tooltip" title="Lên trên cùng" ><i class="fa fa-arrow-up" aria-hidden="true"></i> </a></div>
	    </div>'.$tmp3;
	
	return $tmp;	
}// end tieuDe
function nguoiTruc($arr){
	if(isset($arr['value']) && (is_numeric($arr['value']))) $value=$arr['value']; 
	else $value=0;
	if($value==0){
		if(strlen($arr['value'])>0) $hoten=$arr['value'];
		else $hoten = '';
	} else{
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
	

	$tmp='<div class="row dong">
	      <div class="col-sm-1"> </div>
	      <div class="col-sm-8">
	        <span class="text4row-left"> '.$arr['noidung'].' 
	          <input type="text" name="" value="'.$hoten.'" readonly >
	        </span>
	      </div>
	    </div>';

	return $tmp;	
}// hết nguoiTruc
function ngayTruc($arr){
	if(isset($arr['val_ngay_truc'])) $ngay_truc=$arr['val_ngay_truc']; 
	else {
		require './config/config.php';
		$date=date("Y-m-d");
		$kiemtra_sql="SELECT modc_ngay_truc FROM mod_c WHERE (modc_ngay_truc=".$date.")";
		$kiemtra_query=mysqli_query($source,$kiemtra_sql);
		if($kiemtra_query){
			if(mysqli_fetch_array( $kiemtra_query )>0)	$ngay_truc=NULL;
			else $ngay_truc=$date;
		}
		else $ngay_truc=NULL;
	}
	if(is_null($ngay_truc)) $ngay_ok= -1; else $ngay_ok=2;
	if(isset($arr['val_gio_bat_dau'])) $bat_dau=$arr['val_gio_bat_dau']; else $bat_dau='18:00';
	if(isset($arr['val_gio_ket_thuc'])) $ket_thuc=$arr['val_gio_ket_thuc']; else $ket_thuc='22:00';
	if(isset($arr['readonly'])) $readonly=' readonly'; else $readonly='';
	$tmp='<div class="row dong">
      <div class="col-sm-1"> </div>
      <div class="col-sm-8">
        <span class="text4row-left"> '.$arr['noidung'].' 
          <input type="date" id="ngaytruc" name="'.$arr['bien'].'" value="'.$ngay_truc.'" readonly >
        </span>
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
	      <div class="col-sm-1"> </div>
	      <div class="col-sm-4 text4caption">'.$arr['noidung'].'</div>
	      <div class="col-sm-5 text4caption"> '.$value.' </div>
	    </div>';
	
	return $tmp;	
}// end noiDungText
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
function loadCaTruc($ngay){
	// load những ca trực có trong ngày $ngay trong bảng mod_c
	require './config/config.php';
	$sql='SELECT modc_id,modc_ca_truc FROM mod_c WHERE modc_ngay_truc="'.$ngay.'"';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$select_ca['noidung']='<select name="ca_truc" class="txt" id="ca_truc">';//<option value="0"> Chọn ca trực </option>
			$j=0;
			while ($res=mysqli_fetch_array($query)) {
				if($j==0){
					$select_ca['defaul']=$res['modc_ca_truc'];
					$selected=' selected ';
				} else $selected='';
				$select_ca['noidung'].='<option value="'.$res['modc_ca_truc'].'" '.$selected.'> '.tenCaTruc($res['modc_ca_truc']).' </option>';
				$j++;
			}
			$select_ca['noidung'].='</select>';
		}else {
			$select_ca['error']=1;
			$select_ca['noidung']=' Không có ca trực nào cả';
		}
	} else {
		$select_ca['error']=2;
		$select_ca['noidung']=' Không kết nối đc csdl';
	}
	return $select_ca;
}
function hienThi($arr){
	$noidung='';
	for ($i=0; $i < count($arr) ; $i++) { 
		switch ($arr[$i]['type']) {
			case '0':
				$noidung.=okNi($arr[$i]);	
				break;
			case '1':
				$noidung.=tieuDe($arr[$i]);
				break;
			case '2':
				$noidung.=noiDungText($arr[$i]);
				break;
			case '3':
				$noidung.=nguoiTruc($arr[$i]);
				break;
			case '4':
				//$noidung.=ngayTruc($arr[$i]);
				break;	
		}
	}		
	return $noidung;		
}// hết hienThi()
function loadData($ngay,$ca){
	// $ngay: định hang Ymd
	// ca: id của ca trực
	global $mod_c;
	require './config/config.php';
	$kiemtra_sql='SELECT * FROM mod_c WHERE (modc_ngay_truc="'.$ngay.'") AND (modc_ca_truc='.$ca.')';
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
					if(strlen($res[$mod_c[$i]['sql']])>0) $mod_c[$i]['value']=$res[$mod_c[$i]['sql']];
					break;
				case '4':
						$mod_c[$i]['val_ngay_truc']=$res[$mod_c[$i]['sql']];
						$mod_c[$i]['value']=$res[$mod_c[$i]['sql2']];						
					break;
				}
			}
			//var_dump($mod_c);
			$noidung['error']=0;
			$noidung['status']=' Load dữ liệu thành công';
			$noidung['id']=$res['modc_id'];
		}else {
			//$ngay=date_format($ngay,"d-m-Y");
			$noidung['error']=1;
			$noidung['status']='<div class="row dong"><div class="col-sm-10 text-center"><div class="alert alert-warning text-center"> Không tìm thấy dữ liệu ngày này </div></div></div>';
			//var_dump($ngay);'.$ngay.'
		}
	}else {
		$noidung['error']=2;
		$noidung['status']=' Load dữ liệu thành công';$error='có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql;
	}
	return $noidung;
} // hết loadData

?>