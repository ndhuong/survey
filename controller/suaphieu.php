<?php
function macDinh($gt1,$gt2){
if($gt1==$gt2) return ' checked ';
}
function chon($text,$default='0'){
	$tmp2='H_'.rand();
	$tmp ='<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left">'.$text.'</span><br>
			<span class="text-center"> 
				<span>
				<input id="'.$tmp2.'5" name="" value="5" type="radio" class="with-font" '.macDinh($default,5).' readonly/>
    			<label for="'.$tmp2.'5">5 &emsp; </label>
    			</span>
    			<span>
				<input id="'.$tmp2.'4" name="" value="4" type="radio" class="with-font" '.macDinh($default,4).' readonly/>
    			<label for="'.$tmp2.'4">4 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'3" name="" value="3" type="radio" class="with-font" '.macDinh($default,3).' readonly/>
    			<label for="'.$tmp2.'3">3 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'2" name="" value="2" type="radio" class="with-font" '.macDinh($default,2).' readonly/>
    			<label for="'.$tmp2.'2">2 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'1" name="" value="1" type="radio" class="with-font" '.macDinh($default,1).' readonly/>
    			<label for="'.$tmp2.'1">1 &emsp; </label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'0" name="" value="9" type="radio" class="with-font" '.macDinh($default,9).' readonly/>
    			<label for="'.$tmp2.'0">Không ý kiến </label>
				</span>
    			


			</span>
		</div>
	</div>';
	return $tmp;
}
function chonYesNo($text,$default='0'){
	$tmp2='H_'.rand();
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left">'.$text.'</span><br>
			<span class="text-center"> 
				<span>
    			<input id="'.$tmp2.'2" name="" value="2" type="radio" class="with-font" '.macDinh($default,2).' readonly/>
    			<label for="'.$tmp2.'2">Có &emsp;</label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'1" name="" value="1" type="radio" class="with-font" '.macDinh($default,1).' readonly />
    			<label for="'.$tmp2.'1">Không &emsp;</label>
    			</span>
    			<span>
    			<input id="'.$tmp2.'0" name="" value="9" type="radio" class="with-font" '.macDinh($default,9).' readonly />
    			<label for="'.$tmp2.'0">Không ý kiến </label>
				</span>
    			


			</span>
		</div>
	</div>';
	return $tmp;
}
function dongTxt($text,$default=''){
	if(strlen($default)>30) $cao=3; else $cao=1;
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left">'.$text.'</span><br>
			<span class="text-center"> 
			<textarea rows="'.$cao.'" cols="50">'.$default.'</textarea>
			</span>
		</div>
	</div>';
	return $tmp;
}
function soPhieu($default='-1'){
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left"> Số phiếu khảo sát ý kiến khách hàng</span><br>
			<span class="text-center"> 
				<input type="number" name="" id="sophieu" placeholder="Nhập số phiếu" ';
	if($default>0) $tmp=$tmp.' value="'.$default.'" readonly ';
	else $tmp=$tmp.' value="" required';
			$tmp=$tmp.' class="txt" min="1">
			</span>
			<span id="ketQua"> </span>	
		</div>
	</div>';
	return $tmp;
}
function ngayKhaoSat($default=NULL){
	$tmp ='
		<div class="row dong">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
			<span class="text-left"> Ngày khảo sát:<b>'.$default.'</b> </span><br>
			
			
		</div>
	</div>';
	return $tmp;
}
function tieuDe($text){
	return '<br><div class="row">
		<div class="col-sm-2"> </div>
		<div class="col-sm-6 text1">
			'.$text.'
			
		</div>
	</div>';
}
function tieuDe2($text){
	return '<br><div class="row">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6 text2">
			'.$text.'
			
		</div>
	</div>';
}
function noiDungMau(){
	require './config/config.php';
	$sql='SELECT * FROM noidungkhaosat ORDER BY nd_stt ASC';
	$query=mysqli_query($source,$sql);
	if($query){
		while ( $res = mysqli_fetch_array( $query )) {
			$tmp['stt']=$res['nd_stt'];
			$tmp['noidung']=$res['nd_noidung'];
			$tmp['loai']=$res['nd_loai'];
			$tmp['bien']=$res['nd_ten_bien'];
			$tmp['sql']=$res['nd_ten_sql'];
			
			$tmp2[$res['nd_stt']]=$tmp;
		}
		return $tmp2;
	}
	else{
		$tmp2='Có lỗi';
	}
	return $tmp2;
}
if(isset($_GET['xoa'])&&($_SESSION['token']==decodetoken($_GET['xoa'])) ){
	$id=decode($_GET['xoa']);
	$sql='SELECT * FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	$res=mysqli_fetch_array($query);
	$sql='DELETE FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		nhatky('xóa phiếu khảo sát số: '.$res['ks_so_phieu'].'- Ngày khảo sát: '.$res['ks_ngay_khao_sat']);
			header('location: index.php?ylan=xemphieu&ok=3');
	}
	else{
		header('location: index.php?ylan=xemphieu&err=1');	
	}

}
elseif(isset($_GET['sua'])&&($_SESSION['token']==decodetoken($_GET['sua'])) ){
	$id=decode($_GET['sua']);
	$token =token();
	$_SESSION['token']=$token;
	$sql= 'SELECT * FROM khao_sat WHERE ks_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		$res = mysqli_fetch_array( $query );
		// load nội dung mẫu
		$mau=noiDungMau();
		//echo count($mau);
		//var_dump($mau);
		$noidungphieu='<br>';
		$tieudechinh='Phiếu khảo sát khách hàng số '.$res['ks_so_phieu'];
		for ($i=0; $i < count($mau) ; $i++) { 
			/*
			if($mau[$i]['sql']=='ks_so_phieu'){
				$noidung=$noidung.sophieu($res['ks_so_phieu']);
			}
			else
			*/
			if($mau[$i]['sql']=='ks_ngay_khao_sat'){
				$noidungphieu=$noidungphieu.ngayKhaoSat($res['ks_ngay_khao_sat']);
			}
			elseif ($mau[$i]['loai']==1) { // cau tra loi van ban chu
				$noidungphieu=$noidungphieu.dongTxt($mau[$i]['noidung'],$res[$mau[$i]['sql']]);
			}
			elseif ($mau[$i]['loai']==2) { // cau tra loi co khong
				$noidungphieu=$noidungphieu.chonYesNo($mau[$i]['noidung'],$res[$mau[$i]['sql']]);
			}
			elseif ($mau[$i]['loai']==3) { // cau tra loi lua chọn 5->1
				$noidungphieu=$noidungphieu.chon($mau[$i]['noidung'],$res[$mau[$i]['sql']]);
			}
			elseif ($mau[$i]['loai']==4) { // tieu de chinh
				$noidungphieu=$noidungphieu.tieuDe($mau[$i]['noidung']);
			}
			elseif ($mau[$i]['loai']==5) { // tieu de phu
				$noidungphieu=$noidungphieu.tieuDe2($mau[$i]['noidung']);
			}
			else {

			}
		}
		$tmp1=encode($res['ks_id']);
		$txt='<br><br><div class="row">
          	    <div class="col-sm-10 text-center ">
                     <button type="button" class="btn btn-warning btn-lg" onclick=\'window.location="index.php?ylan=phieumoi&sua='.$tmp1.'"\'> Cập nhật nội dung phiếu </button>
          		</div>
     		</div><br><br><br><br>';
		$noidungphieu=$noidungphieu.$txt;
	}
	else 
		echo "Có lỗi. ". mysqli_error($source).$sql;
}
include './views/suaphieu.phtml';
?>