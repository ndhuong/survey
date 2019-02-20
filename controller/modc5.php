<?php
include './controller/modc_xem_func.php';
require './controller/modc_data.php';
    for ($i=0; $i < count($mod_c) ; $i++) { 
		if($mod_c[$i]['type']==0) $mod_c[$i]['ghichu']=$mod_c[$i]['bien'].'_txt';			
	}
$tmp=loadData($_GET['ngay'],$_GET['ca']);
	if($tmp['error']==0){
		$noidung=hienThi($mod_c);	
		$noidung.='<br><br><div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-6  text-center ">
                <br>
                 <a class="submitbutton" href="index.php?ylan=modc&sua='.encode($tmp['id']).'" > Sửa phiếu </a> 
                 <p></p>
            </div>
        </div><br>';
	} else {
		$noidung=$tmp['status'];
	}

//	$noidung='ngày:'.$_GET['ngay'].' ca:'.$_GET['ca'];
echo $noidung;
?>