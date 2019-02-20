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
	return $tmp;
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
	return $tmp;
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
	return $tmp;
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
	return $tmp;
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
	return $tmp;
}
function tieuDe($text){
	$tmp= '<br><div class="row">
		<div class="col-sm-2"> </div>
		<div class="col-sm-6 text1">
			'.$text.'
			
		</div>
	</div>';
	return $tmp;
}
function tieuDePhu($text){
	$tmp= '<br><div class="row">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6 text2">
			'.$text.'
			
		</div>
	</div>';
	return $tmp;
}
function noiDungMau($data=1,$data2=1){
	// $data=1: Nha hang, =2: Le tan, =3 Kinh doanh
	//$data2 = 1: tra ve chi so mang là so thu tu, =2 ten_sql
	require './config/config.php';
	switch ($data) {
		case '1':
			$loai=' nd_nhahang=1 ';	
			break;
		case '2':
			$loai=' nd_letan=1 ';	
			break;
		case '3':
			$loai=' nd_kinhdoanh=1 ';	
			break;
	}

	$sql='SELECT * FROM noidungkhaosat WHERE ('.$loai.') ORDER BY nd_stt ASC';
	$query=mysqli_query($source,$sql);
	if($query){
		while ( $res = mysqli_fetch_array( $query,MYSQLI_ASSOC )) {
			$tmp['stt']=$res['nd_stt'];
			$tmp['noidung']=$res['nd_noidung'];
			$tmp['loai']=$res['nd_loai'];
			$tmp['bien']=$res['nd_ten_bien'];
			$tmp['sql']=$res['nd_ten_sql'];
			
			if($data2==1) $tmp2[$res['nd_stt']]=$tmp;
			else $tmp2[$res['nd_ten_sql']]=$tmp;
		}
		return $tmp2;
	}
	else{
		$tmp2='Có lỗi';
	}
	return $tmp2;
}

?>