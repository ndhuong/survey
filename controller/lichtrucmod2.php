<?php
$thang=substr($_GET['month'],6,2);
$nam=substr($_GET['month'],1,4);
require './controller/lichtrucmod_func.php';
$lich=loadLichTrucThang($thang,$nam);
if(isset($lich['error'])) $lich=$lich['status'];
echo $lich;
?>