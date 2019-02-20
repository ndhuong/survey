<?php
function box_radio($mang,$bien_radio,$bien_txt,$radio_value=0,$txt_value=NULL){
	// phần tử đầu tiên[0] của mảng sẽ là tiêu đề
	$tmp='<div class="row dong">
			<div class="col-sm-3"></div>
			<div class="col-sm-6" >
				<p class="title">'.$mang[0]['noidung'].'</p>
				<p class="noidung_box"> ';
	$h_random=rand();
	$co_txt=0;
	$id_radio='HL'.$h_random;
	$id_script='H'.$h_random.'()';
	$not_id_script='not'.$h_random.'()';

	if(strlen($txt_value)>0) $jv_script='onclick="'.$id_script.'" '; else $jv_script='';
	for ($i=1; $i < count($mang) ; $i++) { 
			// lấy dữ liệu từ biến thứ 2 trong mảng
			if($mang[$i]['giatri']==$radio_value) $radio_select=' checked '; else $radio_select='';
						
			if($mang[$i]['txt']==1){
				if(strlen($txt_value)>0) $sty='style="display: inline"'; else $sty='style="display: none"';
				$tmp=$tmp.'<input type="radio" name="'.$bien_radio.'" value="'.$mang[$i]['giatri'].'"  onclick="'.$id_script.'" id="'.$id_radio.'"'.$radio_select.' > &nbsp'.$mang[$i]['noidung'] .'<span id="'.$bien_txt.'" '.$sty.'>	<input type="text" name="'.$bien_txt.'"  placeholder="Nhập lý do" value="'.$txt_value.'">	</span>	' ;
				$co_txt=1;
			}
			else{
				$tmp=$tmp.'<input type="radio" name="'.$bien_radio.'" value="'.$mang[$i]['giatri'].'" '.$jv_script.$radio_select.' onclick="'.$id_script.'"> &nbsp'.$mang[$i]['noidung'] .'<br>' ;
			}
			
		}	

		$tmp=$tmp.'</p>
			</div></div>
			';
			if($co_txt>0){
				$tmp=$tmp.'<script type="text/javascript">
				function '.$id_script.' {
					if(document.getElementById("'.$id_radio.'").checked)
						document.getElementById("'.$bien_txt.'").style.display="inline";
					else
						document.getElementById("'.$bien_txt.'").style.display="none";
				};
				
			</script>';
			}
	return $tmp;
}// hết Box radio
function title($text){
	return '<div class="row ">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 title" >
				'.$text.'
			</div></div>';
			
}// hết title
function macDinh($gt1,$gt2){
if($gt1==$gt2) return ' checked ';
}// hết mặc định
function box_radio2($title,$bien_radio,$radio_value=0){
		$tmp='<div class="row dong">
			<div class="col-sm-3"></div>
			<div class="col-sm-8" >
				<p class="title2">'.$title.'</p>
			<p class="noidung_box"> ';
	
			$tmp=$tmp.'<input type="radio" name="'.$bien_radio.'" value="5" '.macDinh($radio_value,5).'> &nbsp Tuyệt vời &emsp;
			<input type="radio" name="'.$bien_radio.'" value="4" '.macDinh($radio_value,4).'> &nbsp Tốt &emsp;
			<input type="radio" name="'.$bien_radio.'" value="3" '.macDinh($radio_value,3).'> &nbsp Trung bình &emsp;
			<input type="radio" name="'.$bien_radio.'" value="2" '.macDinh($radio_value,2).'> &nbsp Tệ &emsp;
			<input type="radio" name="'.$bien_radio.'" value="1" '.macDinh($radio_value,1).'> &nbsp Rất tệ &emsp;
			<input type="radio" name="'.$bien_radio.'" value="-1" > &nbsp Không chọn';
			
	$tmp=$tmp.'</p></div></div>';
	return $tmp;
} // Hết box radio2
function box_check($title,$bien_checkbox,$checkbox_value=0){
	$tmp='<p class="noidung_box"><input type="checkbox" name="'.$bien_checkbox.'" value="1" '.macDinh($checkbox_value,1).'> &nbsp '.$title.'</p>';
	return $tmp;
}// hết func box_checkbox
function box_check_khac($title,$bien_checkbox,$bien_txt,$checkbox_value=0,$txt_value=NULL){
	$id_script='H'.rand().'()';
	$span_id='H'.rand();
	if(strlen($txt_value)>0) $sty='style="display: inline"'; else $sty='style="display: none"';
	$tmp='<p class="noidung_box"><input type="checkbox" name="'.$bien_checkbox.'" value="1" '.macDinh($checkbox_value,1).' id="'.$bien_checkbox.'" onclick="'.$id_script.'"> &nbsp '.$title.'<span id="'.$span_id.'" '.$sty.'>	<input type="text" name="'.$bien_txt.'"  placeholder="Nhập vấn đề" value="'.$txt_value.'">	</span>	</p>';
	$tmp=$tmp.'<script type="text/javascript">
				function '.$id_script.' {
					if(document.getElementById("'.$bien_checkbox.'").checked)
						document.getElementById("'.$span_id.'").style.display="inline";
					else
						document.getElementById("'.$span_id.'").style.display="none";
				};
				
			</script>';
	return $tmp;
}// hết func box_checkbox
function box_yesno($title,$bien,$value=0){
	$tmp='<div class="row dong">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 text-center" >
				<p class="title">'.$title.'</p>
				<p class="noidung_box "> 
				<input type="radio" name="'.$bien.'" value="2" '.macDinh($value,2).'> &nbsp Có &emsp;
				<input type="radio" name="'.$bien.'" value="1" '.macDinh($value,1).'> &nbsp Không &emsp;	</p></div></div>';	

	return $tmp;
}// hết func box_checkbox
function box_nhanxet($title,$bien,$value=NULL){
	$tmp='<div class="row dong">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 text-center" >
				<p class="title">'.$title.'</p>
				<p class="noidung_box "> 
				<input type="text" class="text" name="'.$bien.'" value="'.$value.'" >
				</p></div></div>';	

	return $tmp;
}
function box_sophieu($value=NULL){
	
	if($value > 0 ){
		$tmp1=' readonly ';
		$sua='<input type=hidden name="sua" value="'.encode($value).'">';
	}
	else{
		require './config/config.php';
		$tmp1='';
		$sua='';
		$sql='SELECT MAX(`ks18_id`) FROM khaosat2018';
		$query=mysqli_query($source,$sql);
		if($query){
			$result=mysqli_fetch_array( $query );
			$value=$result[0]+1;
		}
	}
	$tmp='<div class="row dong">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 text-center" >
				<p class="title">Số phiếu</p>
				<p class="noidung_box "> 
				<input type="number" id="sophieu" min="0" stept="1" class="text" name="sophieu" value="'.$value.'" palaceholder=" Nhập số phiếu" readonly >
				<span id="ketQua"></span></p>'.$sua.'</div></div>';	

	return $tmp;
}// hết func box_so_phieu
function box_ngay($value=0){
	if($value==0) $value=date("Y-m-d");
	$tmp='<div class="row dong">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 text-center" >
				<p class="title">Ngày khảo sát</p>
				<p class="noidung_box "> 
				<input type="date" class="text" name="ngaynhap" value="'.$value.'">
				<span id="ketQua"></span></p></div></div>';	

	return $tmp;
}// hết func box_nhanxet
?>