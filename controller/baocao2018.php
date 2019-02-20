<?php
include './controller/noidungmau3.php';

function title2($text){
	return '<div class="row ">
			<div class="col-sm-2"></div>
			<div class="col-sm-9 title" >
				'.$text.'
			</div></div>';
			
}// hết title
function showDanhGia($mang){
	//global $sodong;
	//$tong=$mang['excellent']+$mang['good']+$mang['fair']+$mang['bad']+$mang['poor'];
	//$tongso=$sodong;
	$tmp ='<div class="row ">';
	$tmp=$tmp.title2($mang['danhgia']['noidung']);
	$tmp=$tmp.'</div>';
	
	//$tmp=$tmp.'<i> Có '.$tong.'/'.$tongso.' phiếu bình chọn</i></span><br>';
	foreach ($mang as $key => $value) {
		if($key=='danhgia') continue;
		else{
			$tmp=$tmp.'<div class="row dong"><div class="col-sm-2"> </div>
				<div class="col-sm-8">';
			$tmp=$tmp.title($mang[$key]['noidung']);
			$tmp=$tmp.'<span class="text-left"> 
			&emsp;Đánh giá Tuyệt vời = '.$mang[$key]['excellent'].' phiếu.<br>
			&emsp;Đánh giá Tốt = '.$mang[$key]['good'].' phiếu.<br>
			&emsp;Đánh giá Trung bình = '.$mang[$key]['fair'].' phiếu.<br>
			&emsp;Đánh giá Tệ = '.$mang[$key]['bad'].' phiếu.<br>
			&emsp;Đánh giá Rất tệ = '.$mang[$key]['poor'].' phiếu.</span></div></div>';
		}
	}
		//$tmp=$tmp.'</div></div>';
	// &emsp;<i>Có '.$giatri['s0'].' phiếu không bình chọn mục này</i>.
	return $tmp;
}
function showMucDich($mang){
	$tmp ='<div class="row dong">';
	
	$tmp=$tmp.'<div class="col-sm-2"> </div>
				<div class="col-sm-8">';
	$tmp=$tmp.title($mang[0]['noidung']);
	$tmp=$tmp.'<span class="text-left"> 
			&emsp;'.$mang[1]['noidung'].' = '.$mang['congtac'].' phiếu.<br>
			&emsp;'.$mang[2]['noidung'].' = '.$mang['kethop'].' phiếu.<br>
			&emsp;'.$mang[3]['noidung'].' = '.$mang['dulich'].' phiếu.<br>
			&emsp;'.$mang[4]['noidung'].' = '.$mang['khac'].' phiếu.</span><span id="mucdichkhac" onclick="mucdichkhac_script()"> <button> Hiện nội dung</button> </span><br><div id="khac2" style="display: none">'.$mang['khac_txt'].' </div>
			<script type="text/javascript">
				function mucdichkhac_script() {
					if(document.getElementById("khac2").style.display=="none"){
						document.getElementById("khac2").style.display="inline";
						document.getElementById("mucdichkhac").innerHTML="<button> Ẩn nội dung</button>";
					}
					else{
						document.getElementById("khac2").style.display="none";
						document.getElementById("mucdichkhac").innerHTML="<button> Hiện nội dung</button>";
					}
				};
				
			</script></div></div>';
	return $tmp;
}
function showKenhDatPhong($mang){
	$tmp ='<div class="row dong">';
	
	$tmp=$tmp.'<div class="col-sm-2"> </div>
				<div class="col-sm-8">';
	$tmp=$tmp.title($mang[0]['noidung']);
	$tmp=$tmp.'<span class="text-left"> 
			&emsp;'.$mang[1]['noidung'].' = '.$mang['tructiep'].' phiếu.<br>
			&emsp;'.$mang[2]['noidung'].' = '.$mang['ctydulich'].' phiếu.<br>
			&emsp;'.$mang[3]['noidung'].' = '.$mang['congty'].' phiếu.<br>
			&emsp;'.$mang[4]['noidung'].' = '.$mang['webhotel'].' phiếu.<br>
			&emsp;'.$mang[5]['noidung'].' = '.$mang['webkhac'].' phiếu.</span><span id="kenhkhac" onclick="kenhkhac_script()"> <button> Hiện nội dung</button> </span><br><div id="kenhkhac2" style="display: none">'.$mang['webkhac_txt'].' </div>
			<script type="text/javascript">
				function kenhkhac_script() {
					if(document.getElementById("kenhkhac2").style.display=="none"){
						document.getElementById("kenhkhac2").style.display="inline";
						document.getElementById("kenhkhac").innerHTML="<button> Ẩn nội dung</button>";
					}
					else{
						document.getElementById("kenhkhac2").style.display="none";
						document.getElementById("kenhkhac").innerHTML="<button> Hiện nội dung</button>";
					}
				};
				
			</script></div></div>';
	return $tmp;
}
function showLydo($mang){
	$tmp ='<div class="row dong">';
	
	$tmp=$tmp.'<div class="col-sm-2"> </div>
				<div class="col-sm-8">';
	$tmp=$tmp.title($mang[0]['noidung']);
	$tmp=$tmp.'<span class="text-left"> 
			&emsp;'.$mang[1]['noidung'].' = '.$mang['hailong'].' phiếu.<br>
			&emsp;'.$mang[2]['noidung'].' = '.$mang['vitri'].' phiếu.<br>
			&emsp;'.$mang[3]['noidung'].' = '.$mang['gia'].' phiếu.<br>
			&emsp;'.$mang[3]['noidung'].' = '.$mang['duocgioithieu'].' phiếu.<br>
			&emsp;'.$mang[4]['noidung'].' = '.$mang['ctychon'].' phiếu.</span></div></div>';
	return $tmp;
}
function showVanDe($mang){
	$tmp ='<div class="row ">';
	$tmp=$tmp.title2($mang['chung']['noidung']);
	$tmp=$tmp.'</div>';
	foreach ($mang as $key => $value) {
		$tmp=$tmp.'<div class="row dong">';
		$tmp=$tmp.'<div class="col-sm-2"> </div>
				<div class="col-sm-8">';
		
		switch ($key) {
			case 'chung':
				$tmp=$tmp.'</div></div>';
				continue;
				break;
			case 'nhanxet':
				$tmp=$tmp.title($mang[$key]['noidung']);
				$tmp=$tmp.'<span class="text-left"> ';
				$tmp=$tmp.'</span><span id="nhanxet" onclick="nhanxet_script()"> <button> Hiện nội dung</button> </span><br><div id="nhanxet2" style="display: none">'.$mang[$key]['txt'].' </div>
			<script type="text/javascript">
				function nhanxet_script() {
					if(document.getElementById("nhanxet2").style.display=="none"){
						document.getElementById("nhanxet2").style.display="inline";
						document.getElementById("nhanxet").innerHTML="<button> Ẩn nội dung</button>";
					}
					else{
						document.getElementById("nhanxet2").style.display="none";
						document.getElementById("nhanxet").innerHTML="<button> Hiện nội dung</button>";
					}
				};
				
			</script></div></div>';
				
				break;
				case 'vandekhac':
				$tmp=$tmp.title($mang[$key]['noidung']);
				$tmp=$tmp.'<span class="text-left"> ';
				$tmp=$tmp.$mang[$key]['noidung'].'</span><span id="vandekhac" onclick="vandekhac_script()"> <button> Hiện nội dung</button> </span><br><div id="vandekhac2" style="display: none">'.$mang[$key]['txt'].' </div>
			<script type="text/javascript">
				function vandekhac_script() {
					if(document.getElementById("vandekhac2").style.display=="none"){
						document.getElementById("vandekhac2").style.display="inline";
						document.getElementById("vandekhac").innerHTML="<button> Ẩn nội dung</button>";
					}
					else{
						document.getElementById("vandekhac2").style.display="none";
						document.getElementById("vandekhac").innerHTML="<button> Hiện nội dung</button>";
					}
				};
				
			</script></div></div>';
				
				break;
			case 'cachgiaiquyet':
				$tmp=$tmp.title($mang[$key]['noidung']);
				$tmp=$tmp.'<span class="text-left"> ';
				$tmp=$tmp.'&emsp;Có hài lòng: '.$mang[$key]['yes'].' phiếu<br>&emsp;Không hài lòng: '.$mang[$key]['no'].' phiếu</span></div></div>';
				break;
	
			default:
				$tmp=$tmp.title($mang[$key]['noidung']);
				$tmp=$tmp.'<span class="text-left"> ';
				$tmp=$tmp.'&emsp;Có '.$mang[$key]['number'].' phiếu</span></div></div>';	
				break;
		}
	}

	return $tmp;
}

function chon2($giatri){
	$tong=$giatri['excellent']+$giatri['good']+$giatri['fair']+$giatri['bad']+$giatri['poor'];
	$tongso=$tong+$giatri['novotes'];
	$tmp ='<div class="row dong">
				<div class="col-sm-2"> </div>
				<div class="col-sm-8">
					<span class="text-left"><b>'.$text.'</b> :<i> Có '.$tong.'/'.$tongso.' phiếu bình chọn</i></span><br>
					<span class="text-left"> 
			&emsp;Đánh giá Tuyệt vời = '.$giatri['excellent'].' phiếu.<br>
			&emsp;Đánh giá Tốt = '.$giatri['good'].' phiếu.<br>
			&emsp;Đánh giá Trung bình = '.$giatri['fair'].' phiếu.<br>
			&emsp;Đánh giá Tệ = '.$giatri['bad'].' phiếu.<br>
			&emsp;Đánh giá Rất tệ = '.$giatri['poor'].' phiếu.<br>
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
			<span class="text-left"><b>'.$text.'</b> :<i> Có '.$tong.'/'.$tongso.' phiếu bình chọn</i></span><br>
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
function tieuDe2($text){
	$tmp= '<br><div class="row">
		<div class="col-sm-3"> </div>
		<div class="col-sm-8 text2">
			'.$text.'
			
		</div>
	</div>';
	return $tmp;
}
function title($value){
	return '<div class="style1" >
  <h3 class="tde">         
            <span >'.$value.'</span>   
  </h3>
  </div>';
} // hết function title
if(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
 	$ngay_bat_dau=$_POST['ngay_bat_dau'];
 	$ngay_ket_thuc=$_POST['ngay_ket_thuc'];
 	$day1=strtotime($_POST['ngay_bat_dau']);
    $day2=strtotime($_POST['ngay_ket_thuc']);
    $days=$day2-$day1;
 //   echo ('Ngày:'.$days/24/60/60);
    if( $days<0) 
    {
            $err="Ngày bắt đầu phải trước ngày kết thúc";
            $ketqua=" <div class='alert alert-danger text-center'>".$err."</div>";
    } 
    else
    {

		// chuyển định dạng ngày tháng sang d/m/Y
        $tmp= new DateTime($_POST['ngay_bat_dau']);
        $tmp1=date_format($tmp, 'd-m-Y');
        $tmp= new DateTime($_POST['ngay_ket_thuc']);
        $tmp2=date_format($tmp, 'd-m-Y');
     
     	$ketqua='<div class="text-center" ><i> Từ  '.$tmp1.' đến  '.$tmp2.'</i><br></div>';
     	
		//trừ ngày kết thúc đi 1 vì ngày lấy từ thẻ input type =date có giá trị H:m:s =00:00:00, có nghĩa là đầu tiên trong ngày. -1 để về đầu tiên của ngày sau
        $batdau=$_POST['ngay_bat_dau'];
        $date = new DateTime($_POST['ngay_ket_thuc']);
        $days = -1;
        // cộng vào 1 ngày
        date_sub($date, date_interval_create_from_date_string($days.' days'));
        $ketthuc = date_format($date, 'Y-m-d H:i');
            //-------------------------------
		$sql='SELECT * FROM khaosat2018 where (ks18_ngay_khao_sat > "'.$batdau.'") AND (ks18_ngay_khao_sat < "'.$ketthuc.'")';
		$query=mysqli_query($source,$sql);
		$sodong=mysqli_num_rows($query);
		if($sodong<1)
		{
			$ketqua='Không có phiếu KSKH 2018 từ ngày '.$tmp1.' đến ngày '.$tmp2.'<br>';
		}
		else
		{
		//-----------------------------------------
			$ketqua=tieuDe('Có tất cả '.$sodong.' phiếu khảo sát từ ngày '.$tmp1.' đến ngày '.$tmp2);
			$_SESSION['bc2018batdau']=$batdau;
			$_SESSION['bc2018ketthuc']=$ketthuc;
			$ngaunhien=rand();
			$_SESSION['bc2018rand']=$ngaunhien;
			$ketqua.=tieuDe2('<a href="bc2018xemct&id='.$ngaunhien.'" class="btn btn-secondary"> Xem chi tiết các phiếu khảo sát </a>');
			include './controller/noidungmau3.php';
		// Reset các giá trị đếm về 0
			foreach ($danhgia_arr as $key => $value ) {
					$danhgia_arr[$key]['excellent']=0 ;
					$danhgia_arr[$key]['good']=0 ;
					$danhgia_arr[$key]['fair']=0 ;
					$danhgia_arr[$key]['bad']=0 ;
					$danhgia_arr[$key]['poor']=0 ;
			}
			foreach ($vande_arr as $key => $value) {
					$vande_arr[$key]['number']=0;
			}
			$mucdich_arr['congtac']=0;
			$mucdich_arr['kethop']=0;
			$mucdich_arr['dulich']=0;
			$mucdich_arr['khac']=0;
			$mucdich_arr['khac_txt']='';
			$lydo_arr['hailong']=0;
			$lydo_arr['vitri']=0;
			$lydo_arr['gia']=0;
			$lydo_arr['duocgioithieu']=0;
			$lydo_arr['ctychon']=0;
			$kenhdatphong_arr['tructiep']=0;
			$kenhdatphong_arr['ctydulich']=0;
			$kenhdatphong_arr['congty']=0;
			$kenhdatphong_arr['webhotel']=0;
			$kenhdatphong_arr['webkhac']=0;
			$kenhdatphong_arr['webkhac_txt']='';
			$vande_arr['cachgiaiquyet']['yes']=0;
			$vande_arr['cachgiaiquyet']['no']=0;
			$vande_arr['nhanxet']['txt']='';
			$vande_arr['vandekhac']['txt']='';
					
		// Hết reset đếm
		// Bắt đầu tính toán kết quả
			while ($res=mysqli_fetch_array( $query )) {
						
				if($res['ks18_muc_dich']>0) {

					switch ($res['ks18_muc_dich']) {
						case '1':
							$mucdich_arr['congtac']++;
							break;
						case '2':
							$mucdich_arr['kethop']++;
							break;
						case '3':
							$mucdich_arr['dulich']++;
							break;
						case '4':
							$mucdich_arr['khac']++;
							$mucdich_arr['khac_txt']=$mucdich_arr['khac_txt'].'<br>'.$res['ks18_muc_dich_txt'];
							break;
					}
				}
				
				if($res['ks18_ly_do']>0){
					switch ($res['ks18_ly_do']) {
						case '1':
							$lydo_arr['hailong']++;
							break;
						case '2':
							$lydo_arr['vitri']++;
							break;
						case '3':
							$lydo_arr['gia']++;
							break;
						case '4':
							$lydo_arr['duocgioithieu']++;
							break;
						case '5':
							$lydo_arr['ctychon']++;
							break;
						
					}
				}

				if($res['ks18_kenh_dat_phong']>0) {
					switch ($res['ks18_kenh_dat_phong']) {
						case '1':
							$kenhdatphong_arr['tructiep']++;
							break;
						case '2':
							$kenhdatphong_arr['ctydulich']++;
							break;
						case '3':
							$kenhdatphong_arr['congty']++;
							break;
						case '4':
							$kenhdatphong_arr['webhotel']++;
							break;
						case '5':
							$kenhdatphong_arr['webkhac']++;
							$kenhdatphong_arr['webkhac_txt']=$kenhdatphong_arr['webkhac_txt'].'<br>'.$res['ks18_kenh_dat_phong_txt'];
							break;
						
						
					}
				}
				foreach ($danhgia_arr as $key => $value) {
					if($key=='danhgia') {
						continue;
					}
					elseif($res[$danhgia_arr[$key]['sql']] >0 ){
						switch ($res[$danhgia_arr[$key]['sql']]) {
							case '1':
								$danhgia_arr[$key]['poor']++;
								break;
							case '2':
								$danhgia_arr[$key]['bad']++;
								break;
							case '3':
								$danhgia_arr[$key]['fair']++;
								break;
							case '4':
								$danhgia_arr[$key]['good']++;
								break;
							case '5':
								$danhgia_arr[$key]['excellent']++;
								break;
						}
					}	
				}
				foreach ($vande_arr as $key => $value) {
					switch ($key) {
						case 'chung':
							continue;
							break;
						case 'nhanxet':
							if(strlen($res[$vande_arr['nhanxet']['sql']])>0){
								$vande_arr['nhanxet']['txt']=$vande_arr['nhanxet']['txt'].'<br>'.$res[$vande_arr['nhanxet']['sql']];
							}
							break;
						case 'cachgiaiquyet':
							if($res[$vande_arr['cachgiaiquyet']['sql']]==1) $vande_arr['cachgiaiquyet']['no']++;
							elseif($res[$vande_arr['cachgiaiquyet']['sql']]==2) $vande_arr['cachgiaiquyet']['yes']++;
							break;
						case 'vandekhac':
							if($res[$vande_arr['vandekhac']['sql']]>0) $vande_arr['vandekhac']['txt']=$vande_arr['vandekhac']['txt'].'<br>'.$res[$vande_arr['vandekhac']['sqltxt']];
							break;
						default:
							if($res[$vande_arr[$key]['sql']]>0) $vande_arr[$key]['number']++;
							break;
					}
				}
				
			}// end while
		// Kết thúc tính toán kết quả
			$ketqua=$ketqua.showMucDich($mucdich_arr);
			$ketqua=$ketqua.showLydo($lydo_arr);
			$ketqua=$ketqua.showKenhDatPhong($kenhdatphong_arr);
			$ketqua=$ketqua.showDanhGia($danhgia_arr);
			$ketqua=$ketqua.showVanDe($vande_arr);
			$ketqua=$ketqua.tieuDe('kết thúc báo cáo');
			//var_dump($mucdich_arr);
			//var_dump($lydo_arr);
			//var_dump($kenhdatphong_arr);
			//var_dump($danhgia_arr);
			//var_dump($vande_arr);	
		}
    }

}
if(isset($error)) $error="<div class='alert alert-danger text-center'>".$error." </div>" ;
if(isset($status))	$status="<div class='alert alert-success text-center'>".$status." </div>" ;
$token =token();
$_SESSION['token']=$token;
$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']='Báo cáo phiếu khảo sát khách hàng mẫu 2018';
$arr['1']['active']=1;
include './views/baocao2018.phtml';
?>