<?php
//require './controller/lichtrucmod_func.php';
function loadTrucMod(){
	// load danh sách người trực mod trả về 1 mảng 
	//[][id]= id người trực, 
	//[][ten]= họ và tên người trực
	require './config/config.php';
	$sql='SELECT * FROM truc_mod ORDER BY tm_ten ASC';
	$query=mysqli_query($source,$sql);
	if($query){
		$danhsach=array();
		$i=0;
		while ($res=mysqli_fetch_array($query)) {
			$danhsach[$i]['ten']=$res['tm_ten'];
			$danhsach[$i]['id']=$res['tm_id'];
			$danhsach[$i]['value']=$res['tm_nhan_email'];
			$danhsach[$i]['bien']='h_'.$res['tm_id'];
			$danhsach[$i]['email']=$res['tm_email'];
			$i++;
		}
	} else $danhsach['error']='có lỗi.'.msqli_error($source);
	return $danhsach;
} // hết loadTrucMod
function show($arr){
	if(isset($arr['error'])) $tmp='Lỗi load danh sách.<br>'.$arr['error'];
	else{
		$tmp='<div class="row">
			    <div class="col-sm-2"> </div>
			    <div class="col-sm-8">
			    <table class="table-striped">
			    <tr><th class="text-center">Chọn &emsp; </th><th class="text-center">Họ và tên </th><th class="text-center">Email </th></tr>';

		for ($i=0; $i < count($arr); $i++) { 
			if($arr[$i]['value']>0 ) $checked=' checked '; else $checked='';
			$checkbox='<input type="checkbox" name="'.$arr[$i]['bien'].'" value="1" '.$checked.'>';
			$tmp=$tmp.'<tr class="dong "><td class="text-center">'.$checkbox.'</td>
			<td class="text-left">'.$arr[$i]['ten'].'&emsp;</td>
			<td class="text-left">'.$arr[$i]['email'].'</td></tr>';
		}
		$tmp=$tmp.'</table></div></div>';
		$tmp=$tmp.'<br><div class="row">
			    
			    <div class="col-sm-8 text-center"> <input type="submit" class="submitbutton" value="Cập nhật" name="submit" ></div></div>';
	}
	return $tmp;
} // hết function show;
if(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$nguoidung=loadTrucMod();
	$err=0;
	for ($i=0; $i < count($nguoidung) ; $i++) { 
		//echo '<br>'.$nguoidung[$i]['ten'];
		//var_dump($_POST[$nguoidung[$i]['bien']]);
		if(isset($_POST[$nguoidung[$i]['bien']]))	$giatri=1; else $giatri=0;
		if($giatri!=$nguoidung[$i]['value']){
			$nguoidung[$i]['value_new']=$giatri;
			$sql='UPDATE truc_mod SET tm_nhan_email='.$giatri.' WHERE tm_id='.$nguoidung[$i]['id'];
			$query=mysqli_query($source,$sql);
			if($query){
				$nguoidung[$i]['error']=0;
				nhatky('Cập nhật người nhận email:'.$nguoidung['id'].' | Họ và tên:'.$nguoidung[$i]['ten'].' từ '.$nguoidung[$i]['value'].' -> '.$giatri);
			} else $err++;
		}
	}
	if($err==0) header('location: index.php?ylan=main6&ok=1');
	else var_dump($nguoidung);
}
$list=show(loadTrucMod());
$token =token();
$_SESSION['token']=$token;
$arr=array();
$tieudechinh='Danh sách người nhận email NI trực MOD';
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/nhanemailni.phtml';

?>