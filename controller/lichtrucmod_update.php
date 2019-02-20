<?php
require './controller/lichtrucmod_func.php';
if(isset($_POST['submit']) && ($_POST['token']=$_SESSION['token'])){
	$dtime=$_POST['dtime'];
	$tmp=decodeThangNam($_POST['dtime']);	
	$thang=$tmp['thang'];
	$nam=$tmp['nam'];
	$newid=decode($_POST['newid']);
	$ngay=$_POST['ngay'];
	$timer=encodeThangNam($thang,$nam);
	//var_dump($tmp);
	$sql='SELECT ltm_so_ngay,ltm_version FROM lichtrucmod WHERE ltm_id='.$newid;
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$old_res=mysqli_fetch_array($query);
			$tmp1=(int)$old_res['ltm_version']+1;
			$update='ltm_version='.$tmp1;
			$co_update=0;
			$nguoitruc=loadNguoiTrucMod();
						
			for ($i=1; $i <=$old_res['ltm_so_ngay'] ; $i++) { 
				$val='';
				for ($j=0; $j < count($nguoitruc) ; $j++) { 
					if(strlen($ngay[$j][$i])>2) {
						if(strlen($val)>2) $val.=':';
						$val.=$ngay[$j][$i];
						$co_update=1;
					}
				}
				if(strlen($val>0)){
					$bien_sql='ltm_ngay'.$i;
					$update.=','.$bien_sql.'="'.$val.'"';
				}
			}
			
			//var_dump($ngay);
			//echo $update;
			
			if($co_update>0){
				$sql='UPDATE lichtrucmod SET '.$update.' WHERE ltm_id='.$newid;
				$query=mysqli_query($source,$sql);
				if($query){
					nhatky('Cập nhật toàn bộ lịch trực MOD tháng '.$thang.'/'.$nam);
					$_SESSION['ok']='Cập nhật thành công lịch trực MOD của tháng'.$thang.'/'.$nam;
					$_SESSION['update']='Cập nhật lại toàn bộ lịch trực MOD của tháng'.$thang.'/'.$nam;
					sendEmailLich($thang,$nam);
					header('location: ./lichtrucmod&id='.$timer.'&ok=1');
				}
			} else {
				$_SESSION['ok']='Không có sự cập nhật lịch trực MOD của tháng'.$thang.'/'.$nam;
				header('location: ./lichtrucmod&id='.$timer.'&ok=1');
			}
			
		}else {
			$_SESSION['err']='Không tìm thấy dữ liệu về tháng'.$thang.'/'.$nam;
			header('location: ./lichtrucmod_update&id='.$timer.'&err=1');
		}
	} else {
		header('location: ./lichtrucmod_update&id='.$timer.'&err='.urlencode('Có lỗi về dữ liệu của tháng'.$thang.'/'.$nam));
	}
}elseif(isset($_GET['id'])&&($_SESSION['token']==decodetoken($_GET['id'])) ){
	$dtime=$_GET['id'];
	$tmp=decodeThangNam($_GET['id']);
	$thang=$tmp['thang'];
	$nam=$tmp['nam'];
	$sql='SELECT ltm_id FROM lichtrucmod WHERE (ltm_thang='.$thang.') AND( ltm_nam<='.$nam.')';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$newid=encode($res['ltm_id']);
			$hangngay=nhapLichTrucMoi2($thang,$nam);
		} else {
			$hangngay='Không có dữ liệu của tháng '.$thang.'/'.$nam;
		}
	} else {
		$hangngay='Không kết nối được với CSDL';
	}
	if(isset($_GET['err'])) $error="<br><div class='alert alert-danger text-center'>".$_SESSION['err']." </div>" ;
	$tieudechinh='Cập nhật lịch trực MOD tháng '.$thang.' năm '.$nam;
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
	include './views/lichtrucmod_update.phtml';	
}

?>