<?php
function okNi($arr){
	$ngauNhien=rand();
	$ngauNhien2=$ngauNhien.'H';
	if(isset($arr['value1']) && ($arr['value1']>0)) $value1=$arr['value1']; else $value1=0;
	if(isset($arr['value2']) && ($arr['value2']>0)) $value2=$arr['value2']; else $value2=0;
	if(isset($arr['value_txt_1']) && (strlen($arr['value_txt_1'])>0)) $value_txt_1=$arr['value_txt_1']; else $value_txt_1=NULL;
	if(isset($arr['value_txt_2']) && (strlen($arr['value_txt_2'])>0)) $value_txt_2=$arr['value_txt_2']; else $value_txt_2=NULL;
	$tmp='<br><div class="row dong">
	    <div class="col-sm-4 text4row-left">'.$arr['noidung'].' </div>
	      <div class="col-sm-3 text-center">';
	        if($value1==2){
	        	$tmp=$tmp.'<button class="btn btn-secondary"> OK </button>';
	        } elseif($value1==1){
	        	$tmp=$tmp.'<button class="btn btn-warning"> NI </button>';
	        } else $tmp=$tmp.'<button class="btn btn-light"> &nbsp; </button>';
	        $tmp=$tmp.'<br>'.$value_txt_1.'
	      </div>
	      <div class="col-sm-3 text-center">';
	        if($value2==2){
	        	$tmp=$tmp.'<button class="btn btn-secondary"> OK </button>';
	        } elseif($value2==1){
	        	$tmp=$tmp.'<button class="btn btn-warning"> NI </button>';
	        } else $tmp=$tmp.'<button class="btn btn-light"> &nbsp; </button>';
	        $tmp=$tmp.'<br>'.$value_txt_2.'
	      </div>
	    </div>';

	return $tmp;
}// hết okNi
function tieuDe($arr){
	global $menu;	
		$random='ndh'.rand();
		$tmp2='<span id="id_'.$random.'" onclick="'.$random.'_script()"> <button> Hiện nội dung</button> </span>
		<script type="text/javascript">
				function '.$random.'_script() {
					if(document.getElementById("'.$random.'").style.display=="none"){
						document.getElementById("'.$random.'").style.display="inline";
						document.getElementById("goTop_'.$random.'").style.display="inline";
						document.getElementById("'.$random.'_top").classList.add("select-bar");
						document.getElementById("id_'.$random.'").innerHTML="<button> Ẩn nội dung</button>";
					}
					else{
						document.getElementById("'.$random.'").style.display="none";
						document.getElementById("goTop_'.$random.'").style.display="none";
						document.getElementById("id_'.$random.'").innerHTML="<button> Hiện nội dung</button>";
						document.getElementById("'.$random.'_top").classList.remove("select-bar");
					}
				};	
			</script>';

		$tmp3='<div class="row"><div class="col-12"></div><div id="'.$random.'" class="select-area" style="display: none">';
		$tmp4='';
	if($menu==0){	
		$tmp4='';
		$menu=1;
	}
	else{
		$tmp4='</div></div>';
	}
	$tmp=$tmp4.'<div class="row dong lienke" id="'.$random.'_top">
	      <div class="col-sm-4 text4caption text-right">'.$arr['noidung'].'</div>
	      <div class="col-sm-4 text4caption">'.$tmp2.' </div>
	      <div class="col-sm-2 go-top-icon" id="goTop_'.$random.'" style="display: none"> <a href="#top" data-toggle="tooltip" title="Lên trên cùng" ><i class="fa fa-arrow-up" aria-hidden="true"></i> </a></div>
	    </div>'.$tmp3;
	
	return $tmp;	
}// end tieuDe
function nguoiTruc($arr){
	if(isset($arr['value']) && (strlen($arr['value'])>0)) $value=$arr['value']; 
	else $value=NULL;
	$tmp='<div class="row dong">
	      <div class="col-sm-4 text4row-left"> '.$arr['noidung'].'</div>
	      <div class="col-sm-3 text4row-right">'.$value.' </div>
	      </div>';
	return $tmp;	
}// hết nguoiTruc
function ngayKiemTra($arr){
	if(isset($arr['value'])) $ngay_truc=$arr['value']; else $ngay_truc=NULL;
	
	$tmp='<div class="row dong">
      <div class="col-sm-4 text4row-left">'.$arr['noidung'].' </div>
      <div class="col-sm-3 text4row-right">'.$ngay_truc.'</div>
    </div>';
	return $tmp;
}

function noiDungText($arr){
	global $menu;
	if(isset($arr['value']) && (strlen($arr['value'])>0)) $value=$arr['value']; 
	else $value=NULL;
	if($menu==1){
		$tmp4='</div></div>';
		$menu=0;
	}		else	$tmp4='';
	$tmp=$tmp4.'<div class="row dong lienke" >
	      
	      <div class="col-sm-4 text4caption text-right">'.$arr['noidung'].'</div>
	      <div class="col-sm-5 text4row-right"> '.$value.' </div>
	    </div>';
	
	return $tmp;	
}// end noiDungText
function noiDungText2($arr){
	if(isset($arr['value']) && (strlen($arr['value'])>0)) $value=$arr['value']; 
	else $value=NULL;
	$tmp='<br><div class="row dong " >
	      <div class="col-sm-4 text4row-left">'.$arr['noidung'].'</div>
	      <div class="col-sm-3 text-center">'.$value.' </div>
	    </div>';
	
	return $tmp;	
}// end noiDungText
function roomName($arr){
	if(isset($arr['value1']) && (strlen($arr['value1'])>0)) $value1=$arr['value1']; 
	else $value1=NULL;
	if(isset($arr['value2']) && (strlen($arr['value2'])>0)) $value2=$arr['value2']; 
	else $value2=NULL;
	
	$tmp='<div class="row dong">
	      <div class="col-sm-4 text4row-left">'.$arr['noidung'].' </div>
	      <div class="col-sm-3 text-center">'.$value1.'
	        <br><i class="fa fa-arrow-down text-primary" ></i>
	       </div>
	       <div class="col-sm-3 text-center">'.$value2.'
	        <br>
	        <i class="fa fa-arrow-down  text-primary"></i>
	       </div>
	       </div>
	    </div>';

	return $tmp;	
}// hết roomName
function tenCaTruc($id_ca){
	require './config/config.php';
	$sql='SELECT * FROM catrucmod WHERE ca_id='.$id_ca;
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$res=mysqli_fetch_array($query);
			$tenca=$res['ca_ten'];
		} else $tenca='';
	}else	$tenca='';
	return $tenca;
} // hết tencatruc;
function loadCaTruc($ngay){
	// load những ca trực có trong ngày $ngay trong bảng mod_c
	require './config/config.php';
	$sql='SELECT grcl_id,grcl_ca_truc FROM grcl WHERE grcl_ngay_kiem_tra="'.$ngay.'"';
	$query=mysqli_query($source,$sql);
	if($query){
		if(mysqli_num_rows($query)>0){
			$select_ca['noidung']='<select name="ca_truc" class="txt" id="ca_truc">';//<option value="0"> Chọn ca trực </option>
			$j=0;
			while ($res=mysqli_fetch_array($query)) {
				if($j==0){
					$select_ca['defaul']=$res['grcl_ca_truc'];
					$selected=' selected ';
				} else $selected='';
				$select_ca['noidung'].='<option value="'.$res['grcl_ca_truc'].'" '.$selected.'> '.tenCaTruc($res['grcl_ca_truc']).' </option>';
				$j++;
			}
			$select_ca['noidung'].='</select>';
		}else {
			$select_ca['error']=1;
			$select_ca['noidung']=' Không có ca trực nào cả';
		}
	} else {
		$select_ca['error']=2;
		$select_ca['noidung']=' Không kết nối đc csdl';
	}
	return $select_ca;
}// hết loadCatruc
function hoTenNguoiTruc($value=null){
	// trả về họ và tên người trực theo id người trực;
	if($value==null) $hoten='';
	else{
		require './config/config.php';
		$sql='SELECT * FROM truc_mod WHERE tm_id='.$value;
		$query=mysqli_query($source,$sql);
		if($query){
			if(mysqli_num_rows($query)>0){
				$res=mysqli_fetch_array($query);
				$hoten=$res['tm_ten'];
			}else $hoten='.';
		} else $hoten='!';
	}
	return $hoten;
} // hết hoTenNGuoiTruc
function showLichTruc($ngay,$ca){
	require './config/config.php';
    require './controller/grcl_data.php';
	$kiemtra_sql='SELECT * FROM grcl WHERE (grcl_ngay_kiem_tra="'.$ngay.'") AND (grcl_ca_truc='.$ca.')';
	$kiemtra_query=mysqli_query($source,$kiemtra_sql);
	if($kiemtra_query){
		if(mysqli_num_rows( $kiemtra_query )>0)	{
			$res=mysqli_fetch_array( $kiemtra_query );
			//var_dump($res);
			for ($i=0; $i < count($grcl) ; $i++) {
				switch ($grcl[$i]['type']) {
				case '1':
					$grcl[$i]['value']=hoTenNguoiTruc((int)$res[$grcl[$i]['sql']]);
					break;
				case '6':
				case '8':
				case '9':
					if(strlen($res[$grcl[$i]['sql']])>0){
						$grcl[$i]['value']=$res[$grcl[$i]['sql']];
					}
					break;
				case '2':
						$grcl[$i]['value1']=$res[$grcl[$i]['sql1']];
						
						$grcl[$i]['value2']=$res[$grcl[$i]['sql2']];
						
					break;
				case '3':
					if(strlen($res[$grcl[$i]['sql1']])>0){
						$grcl[$i]['value1']=$res[$grcl[$i]['sql1']];
					}
					if(strlen($res[$grcl[$i]['sql2']])>0){
						$grcl[$i]['value2']=$res[$grcl[$i]['sql2']];
					}
					break;
				case '5':
					if($res[$grcl[$i]['sql1']]>0){
						$grcl[$i]['value1']=$res[$grcl[$i]['sql1']];
						if(strlen($res[$grcl[$i]['sql_txt_1']])>0){
							$grcl[$i]['value_txt_1']=$res[$grcl[$i]['sql_txt_1']];
						}
					}
					if($res[$grcl[$i]['sql2']]>0){
						$grcl[$i]['value2']=$res[$grcl[$i]['sql2']];
						if(strlen($res[$grcl[$i]['sql_txt_2']])>0){
							$grcl[$i]['value_txt_2']=$res[$grcl[$i]['sql_txt_2']];
						}
					}
					break;
					
				}
			}
			//var_dump($grcl);
			$noidung='';
			for ($i=0; $i < count($grcl) ; $i++) { 
				switch ($grcl[$i]['type']) {
					case '1':
						$noidung=$noidung.nguoiTruc($grcl[$i]);
						break;
					//case '2':
					case '9':
						$noidung=$noidung.ngayKiemTra($grcl[$i]);
						break;
					case '3':
						$noidung=$noidung.roomName($grcl[$i]);
						break;
					case '4':
						$noidung=$noidung.tieuDe($grcl[$i]);
						break;
					case '5':
						$noidung=$noidung.okNi($grcl[$i]);
						break;
					case '6':
						$noidung=$noidung.noiDungText($grcl[$i]);
						break;
					case '8':
						$noidung=$noidung.noiDungText2($grcl[$i]);
						break;
				}
			}		
			$noidung=$noidung.'</div></div><br><br><div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-6  text-center ">
                <br>
                 <a class="submitbutton" href="index.php?ylan=grcl&sua='.encode($res['grcl_id']).'"> Sửa phiếu </a> 
                 <p></p>
            </div>
        </div><br>';
		}// end num rows
		else {
			$noidung='<div class="row dong"><div class="col-sm-10 text-center"><div class="alert alert-warning text-center"> Không tìm thấy dữ liệu ngày này</div></div></div>';
		}
	}
	else
		$noidung='<div class="alert alert-warning text-center">có lỗi khi truy xuất CSDL'.mysqli_error($source)."|".$kiemtra_sql.'</div>';
	return $noidung;	
} //hết showLichTruc
?>