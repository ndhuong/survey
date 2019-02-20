<?php
function loadDanhSach(){
	// trả về danh sách người nhận email đc cấu hình ở trong người nhận email NI
	// [id]= id người nhận
	// [ten]= Họ và tên người nhận
	// [email] email người nhận
	require './config/config.php';
	$sql='SELECT * FROM truc_mod WHERE tm_nhan_email=1';
	$query=mysqli_query($source,$sql);
	if($query){
		$danhsach=array();
		$danhsach[0]['id']=0;
		$danhsach[0]['name']='Nguyễn Đức Hưởng';
		$danhsach[0]['email']='itofficer@halong.muongthanh.vn';
		$i=1;
		if(mysqli_num_rows($query)>0){
			while ($res=mysqli_fetch_array($query)) {
				$danhsach[$i]['id']=$res['tm_id'];
				$danhsach[$i]['name']=$res['tm_ten'];
				$danhsach[$i]['email']=$res['tm_email'];
				$i++;
			}
		}
	} else $danhsach['error']='có lỗi.'.msqli_error($source);
	return $danhsach;
}
function guiEmailMODC($arr){
	/* tạo nội dung email từ cho trước của trực mod ngày
		Trả về nội dung của email.
		mảng cho trước có định dạng
		[type]= loại: 1= tiêu đề dòng chính, 2 = tiêu đề phụ, 3= họ vè tên người trực
		[noidung]=' Nội dung của dòng chính hoặc phụ'
		[ghichu] = Ghi chú nếu có 
	*/
	include './controller/email.php';
	$maildata='<h3 > CÁC KẾT QUẢ NI CỦA TRỰC MOD </h3><br>';
	$tmp=count($arr)-1;
	//if($arr[$tmp]['type']==2) unset($arr[$tmp]); 
	for ($i=0; $i < count($arr) ; $i++) { 
		switch ($arr[$i]['type']) {
			case '1':
				$maildata=$maildata.'<br>&emsp;&emsp;'.$arr[$i]['noidung'].': &emsp;'.$arr[$i]['ghichu'];
				break;
			case '2':
				$maildata=$maildata.'<br><b>'.$arr[$i]['noidung'].'</b> &emsp;'.$arr[$i]['ghichu'];
				break;
			case '3':
				$maildata=$maildata.'<br>&emsp;&emsp;'.$arr[$i]['noidung'].': &emsp;'.$arr[$i]['value'];

				break;
		}
	}
	$maildata=$maildata.'<br><br>';
	$noidung['tieude']='Kết quả trực mod ngày '.$arr[1]['value'];
	$noidung['noidung']=$maildata;
	$nguoinhan=loadDanhSach();
	$ketqua=sendMail($nguoinhan,$noidung);
	if($ketqua['error']>0) nhatky('Gửi email cho người nhận ngày '.$arr[1]['value'].' không thành công.'.$ketqua['status']);
	else {
		$tmp='Danh sách người nhận email trực mod ngày '.$arr[1]['value'];
		for ($i=0; $i < count($nguoinhan); $i++) { 
			$tmp=$tmp.'<br>'.$nguoinhan[$i]['name'].' - '.$nguoinhan[$i]['email'];
		}
		nhatky($tmp);
	};
} // Hết guiEmailMODC
function guiEmailGRCL($arr){
	/* tạo nội dung email từ cho trước của trực mod phòng khách
		Trả về nội dung của email.
		mảng cho trước có định dạng
		[type]= loại: 1= tiêu đề dòng chính, 2 = tiêu đề phụ, 3= họ vè tên người trực
		[noidung]=' Nội dung của dòng chính hoặc phụ'
		[ghichu] = Ghi chú nếu có 
	*/
	include './controller/email.php';
	$maildata='<h3 > CÁC KẾT QUẢ NI CỦA TRỰC MOD PHÒNG KHÁCH</h3><br>';
	//$tmp=count($arr)-1;
	//if($arr[$tmp]['type']==2) unset($arr[$tmp]); 
	$maildata=$maildata.'<table boder=0><tr><td colspan="3">'.$arr[0]['noidung'].' :<b> '.$arr[0]['value'].'</b></td></tr><tr><td colspan="3">'.$arr[1]['noidung'].' : <b>'.$arr[1]['value'].'</b></td></tr><tr><td >'.$arr[2]['noidung'].'</td><td><b>'.$arr[2]['value1'].' </b></td><td><b> '.$arr[2]['value2'].'</b></td></tr>';
	$max1=0;
	$max2=0;
	$max3=0;
	for ($i=3; $i < count($arr) ; $i++) {
		if($i % 2 ==0) $dong=' bgcolor="#B5DBE5" '; else $dong='';
		switch ($arr[$i]['type']) {
			case '2':
				$maildata.='<tr '.$dong.'><td colspan="3">'.$arr[$i]['noidung'].' : <b>'.$arr[$i]['value'].'</b></td></tr>';
				break;
			case '4':
				$maildata.='<tr '.$dong.'><td colspan="3"><b>'.$arr[$i]['noidung'].'</b></td></tr>';
				break;
			case '5':
				if((isset($arr[$i]['noidung']))&&(strlen($arr[$i]['noidung'])>$max1)) $max1=strlen($arr[$i]['noidung']);
				if((isset($arr[$i]['value1_txt']))&&(strlen($arr[$i]['value1_txt'])>$max2)) $max2=strlen($arr[$i]['value1_txt']);
				if((isset($arr[$i]['value2_txt']))&&(strlen($arr[$i]['value2_txt'])>$max3)) $max3=strlen($arr[$i]['value2_txt']);
				if(isset($arr[$i]['value1_txt'])) $value1=$arr[$i]['value1_txt']; else $value1='';
				if(isset($arr[$i]['value2_txt'])) $value2=$arr[$i]['value2_txt']; else $value2='';
				$maildata.='<tr '.$dong.' ><td>&emsp;&emsp;'.$arr[$i]['noidung'].'</td><td>'.$value1.'</td><td>'.$value2.'</td></tr>';
				break;
		}
	}
	$maildata.='<tr><td> <font color="white">';
	for ($i=0; $i < $max1+4; $i++) { 
		$maildata.='_';
	}
	$maildata.='</font></td><td> <font color="white">';
	for ($i=0; $i < $max2+4; $i++) { 
		$maildata.='_';
	}
	$maildata.='</font></td><td> <font color="white">';
	for ($i=0; $i < $max3+4; $i++) { 
		$maildata.='_';
	}
	$maildata.='</font></td></tr>';
	$maildata.='</table><br><br>';
	$noidung['tieude']='Kết quả kiểm tra phòng khách ngày '.$arr[1]['value'];
	$noidung['noidung']=$maildata;
	$nguoinhan=loadDanhSach();
	$ketqua=sendMail($nguoinhan,$noidung);
	if($ketqua['error']>0) nhatky('Gửi email cho người nhận ngày '.$arr[1]['value'].' không thành công.'.$ketqua['status']);
	else {
		$tmp='Danh sách người nhận email trực mod ngày '.$arr[1]['value'];
		for ($i=0; $i < count($nguoinhan); $i++) { 
			$tmp=$tmp.'<br>'.$nguoinhan[$i]['name'].' - '.$nguoinhan[$i]['email'];
		}
		nhatky($tmp);
	};
}
?>