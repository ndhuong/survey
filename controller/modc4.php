<?php
include './controller/mod_func.php';
$noidung=ketQuaTrucMod($_GET['month'],$_GET['year']);
echo $noidung;
?>