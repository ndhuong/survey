<?php
  //  echo 'Quản lý='.$_SESSION['user_quanly'];
if(!isset($_SESSION['user_quanly'] ) )  header('location:./index.php?ylan=main');
function chon($text,$giatri){
	$tong=$giatri['s1']+$giatri['s2']+$giatri['s3']+$giatri['s4']+$giatri['s5'];
	$tongso=$tong+$giatri['s0'];
	$tmp ='<div class="row dong">
				<div class="col-sm-2"> </div>
				<div class="col-sm-8">
					<span class="text-left"><b>'.$text.'</b> : Có '.$tong.'/'.$tongso.' phiếu bình chọn</span><br>
					<span class="text-left"> 
			&emsp;Đánh giá 5 = '.$giatri['s5'].' phiếu.<br>
			&emsp;Đánh giá 4 = '.$giatri['s4'].' phiếu.<br>
			&emsp;Đánh giá 3 = '.$giatri['s3'].' phiếu.<br>
			&emsp;Đánh giá 2 = '.$giatri['s2'].' phiếu.<br>
			&emsp;Đánh giá 1 = '.$giatri['s1'].' phiếu.<br>
			
				</div>
			</div>';
	// &emsp;<i>Có '.$giatri['s0'].' phiếu không bình chọn mục này</i>.
	return $tmp;
}
function chonYesNo($text,$giatri){
	$tong=$giatri['yes']+$giatri['no'];
	$tongso=$tong+$giatri['none'];
	$tmp ='<div class="row dong">
		<div class="col-sm-2"> </div>
		<div class="col-sm-8">
			<span class="text-left"><b>'.$text.'</b> : Có '.$tong.'/'.$tongso.' phiếu bình chọn</span><br>
			<span class="text-left"> 
			&emsp;Đánh giá Yes/Có = '.$giatri['yes'].' phiếu.<br>
			&emsp;Đánh giá No/Không = '.$giatri['no'].' phiếu.<br>
		</div>
	</div>';
	return $tmp;
}
function dongTxt($text,$giatri,$div_id){
	$tmp ='
		<div class="row dong">
		<div class="col-sm-2"> </div>
		<div class="col-sm-8">
			<span class="text-left"><b>'.$text.'</b></span><br>
			<span >
				<input type="hidden" id="'.$div_id.'Status" value="1">
				<p id="'.$div_id.'Hien" class="btn-info"> Hiện +</p>
			</span>
			<div id="'.$div_id.'">
				<span class="text-left"> '.$giatri.'</span>
			</div>
		</div>
	</div>';
	return $tmp;
}
function tieuDe($text){
	$tmp='<br><div class="row">
		<div class="col-sm-2"> </div>
		<div class="col-sm-8 text1">
			'.$text.'
			
		</div>
	</div>';
	return $tmp;
}
function tieuDePhu($text){
	$tmp= '<br><div class="row">
		<div class="col-sm-3"> </div>
		<div class="col-sm-8 text2">
			'.$text.'
			
		</div>
	</div>';
	return $tmp;
}
/*
function noiDungMau(){
	require './config/config.php';
	$sql='SELECT * FROM noidungkhaosat ORDER BY nd_stt ASC';
	$query=mysqli_query($source,$sql);
	if($query){
		while ( $res = mysqli_fetch_array( $query,MYSQLI_ASSOC )) {
			$tmp['stt']=$res['nd_stt'];
			$tmp['noidung']=$res['nd_noidung'];
			$tmp['loai']=$res['nd_loai'];
			$tmp['bien']=$res['nd_ten_bien'];
			$tmp['sql']=$res['nd_ten_sql'];
			
			$tmp2[]=$tmp;
		}
		return $tmp2;
	}
	else{
		$tmp2='Có lỗi';
	}
	return $tmp2;
}// hết function
*/
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
			
			if($data2==1) $tmp2[]=$tmp;
			else $tmp2[$res['nd_ten_sql']]=$tmp;
		}
		return $tmp2;
	}
	else{
		$tmp2='Có lỗi';
	}
	return $tmp2;
}
function resetNoiDung(&$noidung){
	
/*
	if($result['nd_loai']==1) $tmp= ' Câu trả lời văn bản chữ';
				elseif($result['nd_loai']==2) $tmp= ' Câu trả lời Có / Không ';
				elseif($result['nd_loai']==3) $tmp= ' Câu trả lời lựa chọn 5->1';
				elseif($result['nd_loai']==4) $tmp= ' Tiêu đề chính';
				elseif($result['nd_loai']==5) $tmp= ' Tiêu đề phụ';
				elseif($result['nd_loai']==6) $tmp= ' Dòng số phiếu';
				elseif($result['nd_loai']==7) $tmp= ' Dòng ngày khảo sát';
*/
	for ( $i=0; $i < count($noidung) ; $i++) { 
		$giatri=null;
		
			switch ($noidung[$i]['loai']) {
				case '1':
					$giatri['text']='';
					break;
				case '2':
					$giatri['yes']=0;
					$giatri['no']=0;
					$giatri['none']=0;
					break;
				case '3':
					$giatri['s5']=0;
					$giatri['s4']=0;
					$giatri['s3']=0;
					$giatri['s2']=0;
					$giatri['s1']=0;
					$giatri['s0']=0;
					break;
				
			}
		
		$noidung[$i]['giatri']=$giatri;
	}
}

?>