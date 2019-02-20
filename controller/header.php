<?php
if ( !$_SESSION['user_id'] )
{
	header('location: ./login&t=1');
}
else
	check_time();

$user_id = intval($_SESSION['user_id']);

$sql1="select * from login where log_id='$user_id'";
$query=mysqli_query($source,$sql1);
$member = mysqli_fetch_array( $query );

$showheader='<div class="container"><table class="header"><tr><td rowspan=2 class="center" ><a href="./main6"> ';
$showheader=$showheader."<span class='fa fa-home fa-2x'> </span></a> &nbsp;</td>";
$showheader=$showheader.'<td rowspan=2 class="center"><i><marquee>'.ngayhientai().'</marquee></i></td><td colspan=2 class="text-center" >';
$showheader=$showheader." <span class='fa fa-user fa-1x'> </span> ".$member['log_name']." </td></tr><tr><td class=text-right> ";
$showheader=$showheader."<a class=none href='./user_up'><span class='fa fa-pencil fa-1x'></span> Cập nhật </a>";
$showheader=$showheader."|</td><td class=text-left> &nbsp; <a class=none href='./logout'><span class='fa fa-arrow-circle-right fa-1x'></span> Đăng xuất </a>";
$showheader=$showheader."</td></tr></table></div>";

?>