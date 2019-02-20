<?php
session_start();

require './config/config.php';
require './lib/lib.php';
/*
if (!isset($_REQUEST['ylan'])) {
    include_once './controller/login.php';
//    include_once $base_url."index.html";
} */
if (!isset($_REQUEST['ylan'])) {
    include_once './controller/login.php';
    //include_once $base_url."index.html";
    //echo 1;
} 
else
	if ($_REQUEST['ylan']=='login') {
    include './controller/login.php';
    //echo 2;
}
else {
    include_once './controller/header.php';
    include_once '/controller/'.$_REQUEST['ylan'].'.php';
    //echo 3;
}

//var_dump($_REQUEST['ylan']);
?>