<?php
include './controller/grcl_xem_func.php';
require './controller/grcl_data.php';
    $noidung=showLichTruc($_GET['ngay'],$_GET['ca']);

//	$noidung='ngày:'.$_GET['ngay'].' ca:'.$_GET['ca'];
echo $noidung;
?>