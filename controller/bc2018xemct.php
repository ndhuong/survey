<?php

if(isset($_GET['id']) && (isset($_SESSION['bc2018rand'])) && ($_GET['id']==$_SESSION['bc2018rand'])){
	$batdau=$_SESSION['bc2018batdau'];
	$ketthuc=$_SESSION['bc2018ketthuc'];
	$sql='SELECT * FROM khaosat2018 where (ks18_ngay_khao_sat > "'.$batdau.'") AND (ks18_ngay_khao_sat < "'.$ketthuc.'")';
	$query=mysqli_query($source,$sql);
	if($query){
		$sodong=mysqli_num_rows($query);
		$data=array();
		$stt=0;
		include './controller/noidungmau3.php';
		while ($res=mysqli_fetch_array( $query )) {
			$tmp_data=array();
			$stt++;
			$tmp_data['stt']=$stt;
			$tmp_data['doankhach']=$res['ks18_ten_doan_khach'];
			$tmp_data['ngaykhaosat']=$res['ks18_ngay_khao_sat'];
			if($res['ks18_muc_dich']>0) {
				$tmp_data['mucdich_congtac']=0;
				$tmp_data['mucdich_kethop']=0;
				$tmp_data['mucdich_dulich']=0;
				$tmp_data['mucdich_khac']=0;
				$tmp_data['mucdich_khac_txt']='';
				switch ($res['ks18_muc_dich']) {
					case '1':
						$tmp_data['mucdich_congtac']=1;
						break;
					case '2':
						$tmp_data['mucdich_kethop']=1;
						break;
					case '3':
						$tmp_data['mucdich_dulich']=1;
						break;
					case '4':
						$tmp_data['mucdich_khac']=1;
						$tmp_data['mucdich_khac_txt']=$res['ks18_muc_dich_txt'];
						break;
				}
			} else {
				$tmp_data['mucdich_congtac']=-1;
				$tmp_data['mucdich_kethop']=-1;
				$tmp_data['mucdich_dulich']=-1;
				$tmp_data['mucdich_khac']=-1;
				$tmp_data['mucdich_khac_txt']='';
			}
			if($res['ks18_ly_do']>0){
				$tmp_data['lydo_hailong']=0;
				$tmp_data['lydo_vitri']=0;
				$tmp_data['lydo_gia']=0;
				$tmp_data['lydo_duocgioithieu']=0;
				$tmp_data['lydo_ctychon']=0;
				switch ($res['ks18_ly_do']) {
					case '1':
						$tmp_data['lydo_hailong']=1;
						break;
					case '2':
						$tmp_data['lydo_vitri']=1;
						break;
					case '3':
						$tmp_data['lydo_gia']=1;
						break;
					case '4':
						$tmp_data['lydo_duocgioithieu']=1;
						break;
					case '5':
						$tmp_data['lydo_ctychon']=1;
						break;
				}
			} else {
				$tmp_data['lydo_hailong']=-1;
				$tmp_data['lydo_vitri']=-1;
				$tmp_data['lydo_gia']=-1;
				$tmp_data['lydo_duocgioithieu']=-1;
				$tmp_data['lydo_ctychon']=-1;
			}
			if($res['ks18_kenh_dat_phong']>0) {
				$tmp_data['kdp_tructiep']=0;
				$tmp_data['kdp_ctydulich']=0;
				$tmp_data['kdp_congty']=0;
				$tmp_data['kdp_webhotel']=0;
				$tmp_data['kdp_webkhac']=0;
				$tmp_data['kdp_webkhac_txt']='';
				switch ($res['ks18_kenh_dat_phong']) {
					case '1':
						$tmp_data['kdp_tructiep']=1;
						break;
					case '2':
						$tmp_data['kdp_ctydulich']=1;
						break;
					case '3':
						$tmp_data['kdp_congty']=1;
						break;
					case '4':
						$tmp_data['kdp_webhotel']=1;
						break;
					case '5':
						$tmp_data['kdp_webkhac']=1;
						$tmp_data['kdp_webkhac_txt']=$res['ks18_kenh_dat_phong_txt'];
						break;
				}
			}else {
				$tmp_data['kdp_tructiep']=-1;
				$tmp_data['kdp_ctydulich']=-1;
				$tmp_data['kdp_congty']=-1;
				$tmp_data['kdp_webhotel']=-1;
				$tmp_data['kdp_webkhac']=-1;
				$tmp_data['kdp_webkhac_txt']='';
			}
			foreach ($danhgia_arr as $key => $value) {
				if($key=='danhgia') {
					continue;
				}
				elseif($res[$danhgia_arr[$key]['sql']] >0 ){
					$tmp_data[$key]=$res[$danhgia_arr[$key]['sql']];
				} else 	$tmp_data[$key]=0;
			}
			foreach ($vande_arr as $key => $value) {
					switch ($key) {
						case 'chung':
							continue;
							break;
						case 'nhanxet':
							if(strlen($res[$vande_arr['nhanxet']['sql']])>0){
								$tmp_data['nhanxetcuaquykhach']=$res[$vande_arr['nhanxet']['sql']];
							}
							break;
						case 'cachgiaiquyet':
							if($res[$vande_arr['cachgiaiquyet']['sql']]==1) $vande_arr['cachgiaiquyet']['no']++;
							elseif($res[$vande_arr['cachgiaiquyet']['sql']]==2) $vande_arr['cachgiaiquyet']['yes']++;
							break;
						case 'vandekhac':
							if($res[$vande_arr['vandekhac']['sql']]>0) $vande_arr['vandekhac']['txt']=$vande_arr['vandekhac']['txt'].'<br>'.$res[$vande_arr['vandekhac']['sqltxt']];
							break;
						default:
							if($res[$vande_arr[$key]['sql']]>0) $vande_arr[$key]['number']++;
							break;
					}
				}
		}// end while
	} else {

	}
	
} else header('location:baocao2018');

$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='baocao2018';
$arr['1']['name']='Báo cáo phiếu khảo sát khách hàng';
$arr['1']['active']=0;
$arr['2']['stt']=2;
$arr['2']['link']='';
$arr['2']['name']='Báo cáo chi tiết';
$arr['2']['active']=1;
include './views/bc2018xemct.phtml';
?>