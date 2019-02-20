<?php
require './controller/lichtrucmod_func.php';
if(isset($_GET['ngay'])){
	$ngay=$_GET['ngay'];
	$id=$_SESSION['ltm_id'];
	$bien_sql='ltm_ngay'.$ngay;
	$sql='SELECT '.$bien_sql.' FROM lichtrucmod WHERE ltm_id='.$id;
	$query=mysqli_query($source,$sql);
	if($query){
		if(isset($_GET['type'])&&($_GET['type']==1)) $bien='giatringay1'; else $bien='giatringay2';
		$noidung='<select name="'.$bien.'" class="txt">';
		$res=mysqli_fetch_array($query);
		$ngay_data=array();
		if(strlen($res[$bien_sql])>2)	$ngay_data=explode(':',$res[$bien_sql]);
		if(count($ngay_data)>0){
			$_SESSION[$bien]=$ngay_data;
			for ($k=0; $k < count($ngay_data) ; $k++) { 
				$t=(int)substr($ngay_data[$k],0,2);
				$t1=(int)substr($ngay_data[$k],2,2);
				if($k==0) $selected=' selected'; else $selected='';
				$tenca=tenCaTruc($t1);
				$tennguoi=hoTenNguoiTruc($t);
				$noidung.='<option value="'.$ngay_data[$k].'" '.$selected.' > '.$tenca.' - '.$tennguoi.'</option>';
			}
		}
		$noidung.='</select>';
	} else $noidung='Không có Ca trực/ Người trực MOD';
	//$url=$_SERVER['QUERY_STRING'];
	//$noidung.=$url;
	echo $noidung;
	//echo $ngay.' / '.$thang.' / '.$nam.'<br> Tháng session:'.$thang_check.'/'.$nam_check;
}

?>