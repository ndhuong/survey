<?php
include './controller/grcl_func.php';
$noidung=ketQuaTrucMod($_GET['month'],$_GET['year']);
echo $noidung;
/*
//require_once('./config/config.php');
//$date = $_GET['date'];
$thang=substr($_GET['month'],6,2);
$nam=substr($_GET['month'],1,4);
//echo 'tháng: '.$thang.' năm '.$nam.'<br>';
//$thang=date('m');
//$nam=date('Y');
$ngayhomnay=date('d');
$thanghientai=date('m');
$hangngay='<table class="table-striped text-center table-bordered res-table"  >';
$stt=0;
$so_ngay_trong_thang=cal_days_in_month(CAL_GREGORIAN,$thang,$nam);
$hangngay=$hangngay.'<tr class="bg-success"><th class="text-center" colspan="'.$so_ngay_trong_thang.'"> Tháng '.$thang.' - '.$nam.'</th></tr><tr class="bg-success">';
for ($i=1; $i <= $so_ngay_trong_thang; $i++) { 
	if(($i==$ngayhomnay) && ($thang==$thanghientai)){
		$hangngay=$hangngay.'<th class="text-center badge-danger text-white"> &nbsp;'.$i.'&nbsp; </th>';
	}
	else {
		$hangngay=$hangngay.'<th class="text-center"> &nbsp;'.$i.'&nbsp; </th>';
	}
}
$hangngay=$hangngay.'</tr>';

$hangngay=$hangngay.'<tr >';
$a='';
	for ($i=1; $i <= $so_ngay_trong_thang; $i++) { 
		if($i<10) $ngay='0'.$i; else $ngay=$i;
		$namthangngay=$nam.'-'.$thang.'-'.$ngay;
		//$namthangngay=date_format(date_create($namthangngay),"Y-m-d");

		if(($i==$ngayhomnay) && ($thang==$thanghientai)) $today='text-center badge-danger text-white'; else $today='text-center';
		$sql='SELECT grcl_id  FROM grcl WHERE grcl_ngay_kiem_tra="'.$namthangngay.'"';
		$query=mysqli_query($source,$sql);
		
		if($query){
			$a=$a.$sql.'--'.mysqli_num_rows($query).'|'.$namthangngay.'<br>';	
			if(mysqli_num_rows($query)>0){

				//$res=mysqli_fetch_array( $query);
				$tmp=strtotime($namthangngay);
				$hangngay=$hangngay.'<td class="'.$today.'"><div data-toggle="tooltip" title="Bấm để xem báo cáo ngày '.$ngay.'/'.$thang.'/'.$nam.'" onclick=\'window.location="index.php?ylan=grcl_xem&id='.$tmp.'"\'> <span class="fa fa-check fa-1x"></span></div> </td>';
			}else {
				$hangngay=$hangngay.'<td class="'.$today.'"> &nbsp; </td>';
			}
		} else {
			$hangngay=$hangngay.'có lỗi'.mysqli_error($source).$sql;
		}
	}
$hangngay=$hangngay.'</tr>';
$hangngay=$hangngay.'</table><br>';

echo $hangngay;
*/
?>