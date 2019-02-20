<?php
  //  echo 'Quản lý='.$_SESSION['user_quanly'];
if(!isset($_SESSION['user_quanly'] ) )  header('location:./index.php?ylan=main');
include './controller/baocao_func.php';
if(isset($_REQUEST['loaibaocao'])) {
	$loai=$_REQUEST['loaibaocao'];
	$loaibaocao='<input type=hidden name="loaibaocao" value="'.$loai.'">';
}
else{
	header('location:./index.php?ylan=main');
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
		if($loai==1){ //  nhà hàng
			$sql='SELECT * FROM khao_sat where (ks_ngay_khao_sat > "'.$batdau.'") AND (ks_ngay_khao_sat < "'.$ketthuc.'") AND(ks_nha_hang > 0)';
		}
		elseif($loai==2){ //lễ tân
			$sql='SELECT * FROM khao_sat where (ks_ngay_khao_sat > "'.$batdau.'") AND (ks_ngay_khao_sat < "'.$ketthuc.'") AND(ks_le_tan > 0)';
		}
		else{ //kinhdoanh
			$sql='SELECT * FROM sale_ks where (sale_ngay_khao_sat > "'.$batdau.'") AND (sale_ngay_khao_sat < "'.$ketthuc.'")';
		}
		$query=mysqli_query($source,$sql);
		$sodong=mysqli_num_rows($query);
		if($sodong<1)
		{
			$ketqua='Không có dữ liệu báo cáo từ ngày '.$tmp1.' đến ngày '.$tmp2.'<br>';
		}
		else
		{
		//-----------------------------------------
			$ketqua='<div class= "text-center">Có tất cả '.$sodong.' phiếu khảo sát từ ngày '.$tmp1.' đến ngày '.$tmp2.'</div>';
			if($loai<3){ //le tan, nha hang
				$noidung=noiDungMau($loai,1); //loai=1 nha hang, =2 le tan, 1= trả về số thứ tự
				resetNoiDung($noidung);
				$dong=0;
				while ( $res = mysqli_fetch_array( $query )) {
					$dong++;
					for ($i=0; $i < count($noidung); $i++) { 
						$cokhach=-1;
						$tmp1=$noidung[$i]['sql'];
						
						switch ($noidung[$i]['loai']) {
							case '1':
								if(substr($noidung[$i]['sql'],0,8)=='ks_guest'){
									//echo $noidung[$i]['sql'].'<br>';
									$cokhach=1;
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
					if($cokhach>0) $khach[]=$guest;
				} //end while
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
						$ketqua=$ketqua.tieuDePhu($noidung[$i]['noidung']);
						break;
					} // hết switch
				} // hết for nội dung
				$danhsachkhach='';
				if(isset($khach)){
					for ($i=0; $i < count($khach) ; $i++) { 
						$danhsachkhach=$danhsachkhach.'Họ tên:'.$khach[$i]['ten'].'<br>';
						$danhsachkhach=$danhsachkhach.'&emsp;Email:'.$khach[$i]['email'].'<br>';
						$danhsachkhach=$danhsachkhach.'&emsp;Điện thoại:'.$khach[$i]['tel'].'<br>';
						$danhsachkhach=$danhsachkhach.'&emsp;Số phòng:'.$khach[$i]['so_phong'].'<br>';
						$danhsachkhach=$danhsachkhach.'&emsp;Thời gian lưu trú:'.$khach[$i]['thoi_gian'].'<br>';
						$danhsachkhach=$danhsachkhach.'&emsp;Công ty:'.$khach[$i]['cong_ty'].'<br>';
					}
					$ketqua=$ketqua.dongTxt('Danh sách khách hàng khảo sát',$danhsachkhach,'khach');
				}
				
			} //end if($loai<3)
			else{
				$noidung=noiDungMau(3,1); // kinh doanh , stt
				
				$dong=0;
				// xử lý sql sale
				for ($i=0; $i < count($noidung); $i++) { 
					switch ($noidung[$i]['bien']) {
						case 'how_dich_vu':
							$noidung[$i]['sql']='sale_dich_vu';
							break;
						case 'how_trang_bi':
							$noidung[$i]['sql']='sale_trang_bi';
							break;
						case 'employ_chung':
							$noidung[$i]['sql']='sale_empl_chung';
							break;
						case 'employ_tu_tin':
							$noidung[$i]['sql']='sale_empl_tu_tin';
							break;
						case 'employ_nhanh':
							$noidung[$i]['sql']='sale_empl_hieu_qua';
							break;
						case 'employ_chuyen_nghiep':
							$noidung[$i]['sql']='sale_empl_chuyen_nghiep';
							break;
						case 'employ_hai_long':
							$noidung[$i]['sql']='sale_empl_hai_long';
							break;
						case 'employ_ten_nhan_vien':
							$noidung[$i]['noidung']=$noidung[$i-1]['noidung'].'<br>'.$noidung[$i]['noidung'];
							$noidung[$i]['sql']='sale_empl_ten_nhan_vien';
							break;
						case 'overall_how':
							$noidung[$i]['sql']='sale_overall_how';
							break;
						case 'overall_chung':
							$noidung[$i]['sql']='sale_overall_chung';
							break;
						case 'overall_ho_ten':
							$noidung[$i]['sql']='sale_guest_ten';
							break;
						case 'overall_email':
							$noidung[$i]['sql']='sale_guest_email';
							break;
						case 'overall_dien_thoai':
							$noidung[$i]['sql']='sale_guest_tel';
							break;
						case 'overall_so_phong':
							$noidung[$i]['sql']='sale_guest_so_phong';
							break;
						case 'overall_thoi_gian':
							$noidung[$i]['sql']='sale_guest_thoi_gian';
							break;
						case 'overall_cong_ty':
							$noidung[$i]['sql']='sale_guest_cong_ty';
							break;						
					}
					if(($noidung[$i]['loai'] >0 )&&($noidung[$i]['loai'] <4 )){
						$noidung[$i]['loai']=1;
						$noidung[$i]['giatri']='';
					}
				} // hết xử lý sql sale

				//var_dump($noidung);
				while ( $res = mysqli_fetch_array( $query )) {
					$dong++;
					//$noidung['ks_how_dich_vu']['giatri']
					$dong++;
					for ($i=0; $i < count($noidung); $i++) { 
						$cokhach=-1;
						$tmp1=$noidung[$i]['sql'];
						if($noidung[$i]['loai']==1) {
							//echo substr($noidung[$i]['sql'],0,8).'<br>';
							if(substr($noidung[$i]['sql'],0,10)=='sale_guest'){
								//echo substr($noidung[$i]['sql'],0,10).'<br>';
								$cokhach=1;
									switch ($noidung[$i]['sql']) {
										case 'sale_guest_ten':
											$guest['ten']=$res[$tmp1];
											break;
										case 'sale_guest_email':
											$guest['email']=$res[$tmp1];
											break;
										case 'sale_guest_tel':
											$guest['tel']=$res[$tmp1];
											break;
										case 'sale_guest_so_phong':
											$guest['so_phong']=$res[$tmp1];
											break;
										case 'sale_guest_thoi_gian':
											$guest['thoi_gian']=$res[$tmp1];
											break;
										case 'sale_guest_cong_ty':
											$guest['cong_ty']=$res[$tmp1];
											break;
									}
							}
							else
								if($noidung[$i]['sql']=='ks_empl_mong_doi'){
									// bỏ dòng này
								}
								else
									$noidung[$i]['giatri']=$noidung[$i]['giatri'].$res[$tmp1].'<br>';
						} // end if $noidung[$i]['loai']
						 
					} // end for
					if($cokhach>0) $khach[]=$guest;
				} //end while
				// tạo nội dung báo cáo
				for ($i=3; $i <count($noidung) ; $i++) { 

					switch ($noidung[$i]['loai']) {
					case '1':
						//lọc không hiện khách ở đây.
						if(substr($noidung[$i]['sql'],0,10)=='sale_guest'){
							
						}
						elseif($noidung[$i]['bien']=='employ_mong_doi'){
							// không hiện dòng mong đợi
						}
						else{
							$ketqua=$ketqua.dongTxt($noidung[$i]['noidung'],$noidung[$i]['giatri'],$noidung[$i]['bien']);
							//echo $noidung[$i]['bien'].'<br>';
						}	
						break;
					case '4':
						$ketqua=$ketqua.tieuDe($noidung[$i]['noidung']);
						break;
					case '5':
						$ketqua=$ketqua.tieuDePhu($noidung[$i]['noidung']);
						break;
					} // hết switch
				} // hết for nội dung
				$danhsachkhach='';
				if(isset($khach)){
					for ($i=0; $i < count($khach) ; $i++) { 
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
    }
}
$tieudechinh="Báo cáo Phiếu KSKH -";
if($loai==1){ // lễ tân
	$tieudechinh=$tieudechinh.'Bộ phận Nhà hàng';
}
elseif($loai==2){ //nhà hàng
	$tieudechinh=$tieudechinh.'Bộ phận Lễ tân';
}
else{ //kinhdoanh
	$tieudechinh=$tieudechinh.'Bộ phận Kinh doanh';
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
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/baocao2.phtml';
?>