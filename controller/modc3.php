<?php
include './controller/mod_func.php';

$noidung=ketQuaTrucMod();
$token =token();
$_SESSION['token']=$token;	
$tieudechinh='MOD Checklist';
$chonthang=selectThang();
$chonnam=selectNam();

$arr=array();
$arr['0']['stt']=0;
$arr['0']['link']='main6';
$arr['0']['name']='<span class="fa fa-home fa-1x"> Trang chính </span>';
$arr['0']['active']=0;
$arr['1']['stt']=1;
$arr['1']['link']='';
$arr['1']['name']=$tieudechinh;
$arr['1']['active']=1;
include './views/modc3.phtml';
?>