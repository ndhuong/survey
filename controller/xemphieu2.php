<?php
if(isset($_GET['id'])){
	//require './config/config.php';	
	$month=substr($_GET['id'],6,2);
	$year=substr($_GET['id'],1,4);
	$bophan=$_SESSION['bophan'];

	//if(isset($_GET['dv'])) echo 'dv='.$_GET['dv']; else echo 'không bắt đc get dv';
	
	//echo 'Month='.$month.'| Year='.$year.'| '.$_GET['id'];
	if(($bophan==1)|| ($bophan==2) || ($bophan==3) ){
		if($bophan==1){
			$sql='SELECT ks_id,ks_so_phieu,ks_ngay_khao_sat FROM khao_sat WHERE (MONTH(ks_ngay_khao_sat)='.$month.') && (YEAR(ks_ngay_khao_sat)='.$year.') && (ks_nha_hang=1) ORDER BY ks_ngay_khao_sat ASC';
		}
		elseif($bophan==2){
			
			$sql='SELECT ks_id,ks_so_phieu,ks_ngay_khao_sat FROM khao_sat WHERE (MONTH(ks_ngay_khao_sat)='.$month.') && (YEAR(ks_ngay_khao_sat)='.$year.') && (ks_le_tan=1) ORDER BY ks_ngay_khao_sat ASC';
		}
		else{ // tất nhiên còn lại là 3 rồi
			
			$sql='SELECT sale_id,sale_so_phieu,sale_ngay_khao_sat FROM sale_ks WHERE (MONTH(sale_ngay_khao_sat)='.$month.') && (YEAR(sale_ngay_khao_sat)='.$year.') ORDER BY sale_ngay_khao_sat ASC';
		}
		$query=mysqli_query($source,$sql);
		if($query){
			if(mysqli_num_rows($query)>0)
			{
				$tmp='<table class="table-striped"><tr><th>&emsp; STT &emsp;</th><th>&emsp; Số phiếu &emsp; </th><th>&emsp; Ngày lập phiếu &emsp;</th><th>&emsp; Xem/Sửa nội dung &emsp;</th><th>&emsp; Xóa  &emsp;</th></tr>';
				$stt=0;
			 //echo 'Số dòng:'.mysqli_num_rows($query);
				while ($result = mysqli_fetch_array($query)) {
					//var_dump($result);
					$stt++;
					$msgXoa="onclick=\"return confirm('Bạn có chắc chắn xóa Phiếu khảo sát này không ?')\" ";
					if($bophan==1){
						$sophieu=$result["ks_so_phieu"];
						$ngaykhaosat=$result["ks_ngay_khao_sat"];
						$new_id=encode($result["ks_id"]);
						$sua='<a href="./index.php?ylan=phieu_nhahang&sua='.$new_id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
						$xoa='<a href="./index.php?ylan=phieu_nhahang&xoa='.$new_id.'" '.$msgXoa.' ><span class="fa fa-trash fa-1x"></span></a>';
					}
					elseif($bophan==2){
						$sophieu=$result["ks_so_phieu"];
						$ngaykhaosat=$result["ks_ngay_khao_sat"];
						$new_id=encode($result["ks_id"]);
						$sua='<a href="./index.php?ylan=phieu_letan&sua='.$new_id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
						$xoa='<a href="./index.php?ylan=phieu_letan&xoa='.$new_id.'" '.$msgXoa.' ><span class="fa fa-trash fa-1x"></span></a>';	
					}
					else{ // tất nhiên còn lại là 3 rồi
						$sophieu=$result["sale_so_phieu"];
						$ngaykhaosat=$result["sale_ngay_khao_sat"];
						$new_id=encode($result["sale_id"]);
						$sua='<a href="./index.php?ylan=phieu_kinhdoanh&sua='.$new_id.'"> <span class="fa fa-pencil fa-1x"></span> </a>';
						$xoa='<a href="./index.php?ylan=phieu_kinhdoanh&xoa='.$new_id.'" '.$msgXoa.' ><span class="fa fa-trash fa-1x"></span></a>';
					}
					$tmp=$tmp.'<tr> <td class="text-center">'.$stt.'</td>';
					$tmp=$tmp.'<td class="text-center">'.$sophieu.'</td>';
					$tmp=$tmp.'<td class="text-center">'.$ngaykhaosat.'</td>';		
					$tmp=$tmp. '<td class="text-center"> '.$sua.'</td>';
					$tmp=$tmp. '<td class="text-center">'.$xoa.'</td>';
					$tmp=$tmp. '</tr>';	
				}
				$tmp=$tmp. '</table>';	
			}
			else{
				$tmp='Tháng '.$month.' năm '.$year.' không có phiếu khảo sát nào cả';
			}
		}
		else{
			$tmp= "Có lỗi. ". mysqli_error($source).$sql;
		}
	
	}
	
	

	if(isset($tmp)) echo $tmp;
	
}

?>