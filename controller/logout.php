<?php
//session_start();
nhatky("Đăng xuất khỏi hệ thống.");
if (session_destroy())
	header('location: ./login&q=1');
?>