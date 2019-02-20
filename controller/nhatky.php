<?php
checkadmin();
$coketqua=0;
$so_dong_hien_thi=20;
if ( isset($_POST['submit']))
{
 	$ngay1=$_POST['batdau'];
 	$ngay2=$_POST['ketthuc'];
    //Kiểm tra xem ngày bắt đầu có trc ngày kết thúc không
    $day1=strtotime($_POST['batdau']);
    $day2=strtotime($_POST['ketthuc']);
    $days=$day2-$day1;
 //   echo ('Ngày:'.$days/24/60/60);
    if( $days<0) 
    {
            $error="Ngày bắt đầu phải trước ngày kết thúc";
            $ketqua=" <div class='error'>".$error."</div>";
    } 
    else
    {
    if( ($_POST['batdau']!= '') && ($_POST['ketthuc']!=''))   //Kiểm tra xem ngày bắt đầu và kết thúc có tồn tại hay không??
    { 
        $ketqua='Nhật ký hệ thống từ  '.$_POST['batdau'].' đến  '.$_POST['ketthuc'].'<br><br>';
        $listkq='';
       
       
// chuyển định dạng ngày tháng sang d/m/Y
        $tmp= new DateTime($_POST['batdau']);
        $tmp1=date_format($tmp, 'd-m-Y');
        $tmp= new DateTime($_POST['ketthuc']);
        $tmp2=date_format($tmp, 'd-m-Y');
     
     	$ketqua='Nhật ký hệ thống từ  '.$tmp1.' đến  '.$tmp2.'<br>';
 //trừ ngày kết thúc đi 1 vì ngày lấy từ thẻ input type =date có giá trị H:m:s =00:00:00, có nghĩa là đầu tiên trong ngày. -1 để về đầu tiên của ngày sau
        $batdau=$_POST['batdau'];
        $date = new DateTime($_POST['ketthuc']);
        $days = -1;
        // cộng vào 1 ngày
        date_sub($date, date_interval_create_from_date_string($days.' days'));
        $ketthuc = date_format($date, 'Y-m-d H:i');
            //-------------------------------
		$sodong_sql='SELECT nk_id FROM nhatky where (nk_date > "'.$batdau.'") AND (nk_date < "'.$ketthuc.'")';
		$sodong_query=mysqli_query($source,$sodong_sql);
		$sodong=mysqli_num_rows($sodong_query);
		if($sodong<1)
		{
			$ketqua='Không có dữ liệu nhật ký từ '.$tmp1.' đến  '.$tmp2.'<br>';
			
		}
		else
		{
		//-----------------------------------------
			
			$stt=0;
			$coketqua=1;
			$nhatky_sql='Select * from nhatky where (nk_date > "'.$batdau.'") AND (nk_date < "'.$ketthuc.'")';
			$nhatky_query=mysqli_query($source,$nhatky_sql);
// lấy số dòng để phân trang
			$tong_so_dong=mysqli_num_rows($nhatky_query);
			$tong_so_trang = floor($tong_so_dong/$so_dong_hien_thi) + 1;
// lấy dữ liệu chính thức
			$nhatky_sql='Select * from nhatky join login on nhatky.nk_user=login.log_id 
			where (nk_date > "'.$batdau.'") AND (nk_date < "'.$ketthuc.'") ORDER BY nhatky.nk_date ASC LIMIT 0,'.$so_dong_hien_thi;
			$nhatky_query=mysqli_query($source,$nhatky_sql);
			while ($row = mysqli_fetch_array( $nhatky_query ))
			{
				$stt=$stt+1;
				$tmp= new DateTime($row['nk_date']);
				$tmp3=date_format($tmp, 'd-m-Y H:i:s');
				$listkq=$listkq.'<tr><td>'.$stt.'</td>
				<td>'.$tmp3.'</td>
				<td>'.$row['log_user'].'</td>
				<td>'.$row['nk_noi_dung'].'</td>
				</tr>';
			}
		if($tong_so_trang>1) {

			$listtrang='<ul class="pagination"> <li class="active"><a href="#">1</a></li>';
			for ($i=2 ; $i<=$tong_so_trang ; $i++) {
				//$listtrang=$listtrang.' - ';
			$listtrang.='<li><a href= "index.php?ylan=nhatky&trang='.$i.'&batdau='.$batdau.'&ketthuc='.$ketthuc.'&st='.$tong_so_trang.'"> '.$i.' </a></li> ';
			}
			$listtrang.='</ul>';
		}
		else {
			$listtrang='';
		}
		// ghi vào log     
		 nhatky("Xem nhật ký từ ".$tmp1." đến ".$tmp2." ");
		}
    }
    else 
    {
        $ketqua='Chọn thời gian bắt đầu và kết thúc xem';
        $coketqua=0;
     
    }
    }
   
}
elseif( isset($_GET['trang'])){
	$trang=$_GET['trang'];
	$ngaybatdau=$_GET['batdau'];
	$ngayketthuc=$_GET['ketthuc'];
	$ngay1=$_GET['batdau'];
	$ngay2=$_GET['ketthuc'];
	$tong_so_trang=$_GET['st'];
	
	$stt=($trang-1)*$so_dong_hien_thi;
	$coketqua=1;
	$listkq="";
	//=====
	$tmp= new DateTime($_GET['batdau']);
        $tmp1=date_format($tmp, 'd-m-Y');
        $tmp= new DateTime($_GET['ketthuc']);
        $tmp2=date_format($tmp, 'd-m-Y');
     
     	$ketqua='Nhật ký hệ thống từ  '.$tmp1.' đến  '.$tmp2.'<br>';
	
	$nhatky_sql='Select * from nhatky join login on nhatky.nk_user=login.log_id 
			where (nk_date > "'.$ngaybatdau.'") AND (nk_date < "'.$ngayketthuc.'") ORDER BY nhatky.nk_date ASC LIMIT '.$stt.','.$so_dong_hien_thi;
			$nhatky_query=mysqli_query($source,$nhatky_sql);
			while ($row = mysqli_fetch_array( $nhatky_query ))
			{
				$stt=$stt+1;
				$tmp= new DateTime($row['nk_date']);
				$tmp3=date_format($tmp, 'd-m-Y H:i:s');
				$listkq=$listkq.'<tr><td>'.$stt.'</td>
				<td>'.$tmp3.'</td>
				<td>'.$row['log_user'].'</td>
				<td>'.$row['nk_noi_dung'].'</td>
				</tr>';
			}
		
			$listtrang='<ul class="pagination"> ';
			for ($i=1 ; $i<=$tong_so_trang ; $i++) {
				if($i==$trang){
					$listtrang=$listtrang.' <li class="active"><a href="#">'.$i.'</a></li>';
				}
				else
				{
					//$listtrang=$listtrang.' - ';
					$listtrang=$listtrang.'<li><a href= "index.php?ylan=nhatky&trang='.$i.'&batdau='.$ngaybatdau.'&ketthuc='.$ngayketthuc.'&st='.$tong_so_trang.'"> '.$i.' </a>  </li>';
				}
			}
			$listtrang.='</ul>';
	
	
	
}
if(!isset($ngay1)) $ngay1=date('Y-m-d');
if(!isset($ngay2)) $ngay2=date('Y-m-d');
$arr=array();
$tieudechinh='Xem nhật ký hệ thống';
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include_once './views/nhatky.phtml';
?>