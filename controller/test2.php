<?php
/*
require './controller/grcl_data.php';
//include './controller/mod_func.php';
//for ($i=0; $i < count($crcl) ; $i++) { 
	//if($grcl[$i]['type']==0) $grcl[$i]['ghichu']=$grcl[$i]['bien'].'_txt';			
//}
// đoạn này dùng để tạo mới các trường trong cơ sở dữ liệu, chỉ chạy 1 lần duy nhất.
$noidung='ALTER TABLE `grcl` ';
$old_sql='grcl_id';
for ($i=0; $i < count($grcl) ; $i++) { 
	switch ($grcl[$i]['type']) {
		case '5':
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql1'].'` TINYINT NOT NULL DEFAULT \'0\' AFTER `'.$old_sql.'`';
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql2'].'` TINYINT NOT NULL DEFAULT \'0\' AFTER `'.$grcl[$i]['sql1'].'`';
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql_txt_1'].'` TEXT NULL DEFAULT NULL AFTER `'.$grcl[$i]['sql2'].'`';
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql_txt_2'].'` TEXT NULL DEFAULT NULL AFTER `'.$grcl[$i]['sql_txt_1'].'`';
			$old_sql=$grcl[$i]['sql_txt_2'];	
			break;
		case '2':
		case '9':
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql'].'` DATE NULL DEFAULT NULL AFTER `'.$old_sql.'`';
			$old_sql=$grcl[$i]['sql'];
			break;
		
		case '1':
			$noidung=$noidung.' ADD `'.$grcl[$i]['sql'].'` TEXT NULL DEFAULT NULL AFTER `'.$old_sql.'`';
			$old_sql=$grcl[$i]['sql'];
			break;
		case '6':
		case '8':
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql'].'` TEXT NULL DEFAULT NULL AFTER `'.$old_sql.'`';
			$old_sql=$grcl[$i]['sql'];
			break;
		case '3':
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql1'].'` TEXT NULL DEFAULT NULL AFTER `'.$old_sql.'`';
			$old_sql=$grcl[$i]['sql1'];
			$noidung=$noidung.', ADD `'.$grcl[$i]['sql2'].'` TEXT NULL DEFAULT NULL AFTER `'.$old_sql.'`';
			$old_sql=$grcl[$i]['sql2'];
			break;
		case '4':
			
			break;	
	}
}	
$dai_trc=strlen($noidung);
$noidung=$noidung.';';
//$noidung=substr($noidung,0,strlen($noidung)-1).';';
$noidung='Độ dài trc='.$dai_trc.'<br>Độ dài sau='.strlen($noidung).'<br>'.$noidung;
ALTER TABLE `lichtrucmod` ADD `ltm_ngay1` TINYINT NOT NULL DEFAULT '0' AFTER `ltm_ca`, ADD `ltm_ngay2` TINYINT NOT NULL DEFAULT '0' AFTER `ltm_ngay1`, ADD `ltm_ngay3` TINYINT NOT NULL DEFAULT '0' AFTER `ltm_ngay2` ADD `ltm_ngay4` TINYINT NOT NULL DEFAULT '0' AFTER `ltm_ngay3` 
*/
/*
$noidung = 'ALTER TABLE `lichtrucmod` ADD `ltm_ngay1` TINYINT NOT NULL DEFAULT \'0\' AFTER `ltm_ca`';
$old_sql='ltm_ngay1';
for ($i=2; $i <=31; $i++) { 
	$tmp='ltm_ngay'.$i;
	$noidung.=', ADD `'.$tmp.'` TINYINT NOT NULL DEFAULT \'0\' AFTER `'.$old_sql.'`';
	$old_sql=$tmp;
}
echo $noidung;

$kiemtra_query=mysqli_query($source,$noidung);
if($kiemtra_query){
	$noidung='Truy vấn thành công';
}
else{
	$noidung='Có lỗi.'.mysqli_error($source);
}
*/
//var_dump($grcl);

//$date=date("Y-m-d");
//$addate=date_add($date,date_interval_create_from_date_string('1 day'));
//echo $date.'|'.$addate;

$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']='Tieu de';
$arr['1']['active']=1;

include './views/test.phtml';
?>