<?php
  //  echo 'Quản lý='.$_SESSION['user_quanly'];
if(!isset($_SESSION['user_quanly'] ) )  header('location:./index.php?ylan=main');

function chon($text,$giatri){
	$tong=$giatri['s1']+$giatri['s2']+$giatri['s3']+$giatri['s4']+$giatri['s5'];
	$tongso=$tong+$giatri['s0'];
	$tmp ='<div class="row dong">
				<div class="col-sm-2"> </div>
				<div class="col-sm-8">
					<span class="text-left"><b>'.$text.'</b> :<i> Có '.$tong.'/'.$tongso.' phiếu bình chọn</i></span><br>
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
     	// <b><h3>BÁO CÁO PHIẾU KHẢO SÁT KHÁCH HÀNG</h3></b> <br>
		//trừ ngày kết thúc đi 1 vì ngày lấy từ thẻ input type =date có giá trị H:m:s =00:00:00, có nghĩa là đầu tiên trong ngày. -1 để về đầu tiên của ngày sau
        $batdau=$_POST['ngay_bat_dau'];
        $date = new DateTime($_POST['ngay_ket_thuc']);
        $days = -1;
        // cộng vào 1 ngày
        date_sub($date, date_interval_create_from_date_string($days.' days'));
        $ketthuc = date_format($date, 'Y-m-d H:i');
            //-------------------------------
		$sql='SELECT * FROM khao_sat where (ks_ngay_khao_sat > "'.$batdau.'") AND (ks_ngay_khao_sat < "'.$ketthuc.'")';
		$query=mysqli_query($source,$sql);
		$sodong=mysqli_num_rows($query);
		if($sodong<1)
		{
			$ketqua='Không có dữ liệu nhật ký từ ngày '.$tmp1.' đến ngày '.$tmp2.'<br>';
		}
		else
		{
		//-----------------------------------------
			$ketqua=tieuDe('Có tất cả '.$sodong.' phiếu khảo sát từ ngày '.$tmp1.' đến ngày '.$tmp2);
			$noidung=noiDungMau();
			
			resetNoiDung($noidung);
			//var_dump($noidung);
			$dong=0;
			while ( $res = mysqli_fetch_array( $query )) {
				$dong++;
			//	var_dump($res);
				for ($i=0; $i < count($noidung); $i++) { 
					$tmp1=$noidung[$i]['sql'];
					
					switch ($noidung[$i]['loai']) {
						case '1':
							if(substr($noidung[$i]['sql'],0,8)=='ks_guest'){
								//echo $noidung[$i]['sql'].'<br>';
								switch ($noidung[$i]['sql']) {
									case 'ks_guest_ten':
										$guest['ten']=$res[$tmp1];
										break;
									case 'ks_guest_email':
										$guest['email']=$res[$tmp1];
										break;
									case 'ks_guest_tel':
										$guest['tel']=$res[$tmp1];
										break;
									case 'ks_guest_so_phong':
										$guest['so_phong']=$res[$tmp1];
										break;
									case 'ks_guest_thoi_gian':
										$guest['thoi_gian']=$res[$tmp1];
										break;
									case 'ks_guest_cong_ty':
										$guest['cong_ty']=$res[$tmp1];
										break;
								}
							}
							else
							$noidung[$i]['giatri']['text']=$noidung[$i]['giatri']['text'].$res[$tmp1].'<br>';
							break;
						case '2':
							switch ($res[$tmp1]) {
								case '1':
									$noidung[$i]['giatri']['no']++ ;
									break;
								case '2':
									$noidung[$i]['giatri']['yes']++ ;
									break;
								case '9':
									$noidung[$i]['giatri']['none']++ ;
									break;
							}
							break;
						case '3':
							switch ($res[$tmp1]) {
								case '1':
									$noidung[$i]['giatri']['s1']++ ;
									break;
								case '2':
									$noidung[$i]['giatri']['s2']++ ;
									break;
								case '3':
									$noidung[$i]['giatri']['s3']++ ;
									break;
								case '4':
									$noidung[$i]['giatri']['s4']++ ;
									break;
								case '5':
									$noidung[$i]['giatri']['s5']++ ;
									break;
								case '9':
									$noidung[$i]['giatri']['s0']++ ;
									break;
							}
							break;
					} // end swicht $noidung[$i]['loai']
					 
				} // end for
				$khach[$dong]=$guest;
			} //end while
			//var_dump($khach);

			// tạo nội dung báo cáo
			for ($i=2; $i <count($noidung) ; $i++) { 
				switch ($noidung[$i]['loai']) {
				case '1':
					//lọc không hiện khách ở đây.
					if(substr($noidung[$i]['sql'],0,8)=='ks_guest'){
						
					}
					else{
						$ketqua=$ketqua.dongTxt($noidung[$i]['noidung'],$noidung[$i]['giatri']['text'],$noidung[$i]['bien']);
						//echo $noidung[$i]['bien'].'<br>';
					}	
					break;
				case '2':
					$ketqua=$ketqua.chonYesNo($noidung[$i]['noidung'],$noidung[$i]['giatri']);
					break;
				case '3':
					$ketqua=$ketqua.chon($noidung[$i]['noidung'],$noidung[$i]['giatri']);
					break;
				case '4':
						$ketqua=$ketqua.tieuDe($noidung[$i]['noidung']);
						break;
					case '5':
						$ketqua=$ketqua.tieuDe2($noidung[$i]['noidung']);
						break;
				} // hết switch
			} // hết for nội dung
			$danhsachkhach='';
			for ($i=1; $i < count($khach)+1 ; $i++) { 
				$danhsachkhach=$danhsachkhach.'Họ tên:'.$khach[$i]['ten'].'<br>';
				$danhsachkhach=$danhsachkhach.'&emsp;Email:'.$khach[$i]['email'].'<br>';
				$danhsachkhach=$danhsachkhach.'&emsp;Điện thoại:'.$khach[$i]['tel'].'<br>';
				$danhsachkhach=$danhsachkhach.'&emsp;Số phòng:'.$khach[$i]['so_phong'].'<br>';
				$danhsachkhach=$danhsachkhach.'&emsp;Thời gian lưu trú:'.$khach[$i]['thoi_gian'].'<br>';
				$danhsachkhach=$danhsachkhach.'&emsp;Công ty:'.$khach[$i]['cong_ty'].'<br>';
			}
			$ketqua=$ketqua.dongTxt('Danh sách khách hàng khảo sát',$danhsachkhach,'khach');
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
$arr['1']['name']='Báo cáo phiếu khảo sát khách hàng';
$arr['1']['active']=1;
include './views/baocao.phtml';
?>