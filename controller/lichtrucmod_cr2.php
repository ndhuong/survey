<?php
require './controller/lichtrucmod_func.php';
$thang=substr($_GET['month'],6,2);
$nam=substr($_GET['month'],1,4);
$lich=loadLichTrucThang($thang,$nam);
if(isset($lich['error'])) $lich=nhapLichTrucMoi($thang,$nam);

echo $lich;
?>