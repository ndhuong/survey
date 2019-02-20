<?php

//------------------------------------------------------------------------------
function check_time()
 {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $url=$_SERVER['QUERY_STRING'];
    if(substr($url,0,4)=='ylan') $url=substr($url,5,strlen($url)-5);
	if(time() - $_SESSION['user_time'] > 60*60) // 60 phut
	{
		session_destroy();
        header('location: ./login&t=1&phonglam='.urlencode($url));
	}
	else 
	$_SESSION['user_time'] = time();
	
 }
 //---------------------------------------------------------------------------------

 //-----------------------------------------------------------------------------------
 function ngayhientai()
 {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $weekday = date("l");
    $weekday = strtolower($weekday);
    switch($weekday) {
        case 'monday':
            $weekday = 'Thứ hai';
            break;
        case 'tuesday':
            $weekday = 'Thứ ba';
            break;
        case 'wednesday':
            $weekday = 'Thứ tư';
            break;
        case 'thursday':
            $weekday = 'Thứ năm';
            break;
        case 'friday':
            $weekday = 'Thứ sáu';
            break;
        case 'saturday':
            $weekday = 'Thứ bảy';
            break;
        default:
            $weekday = 'Chủ nhật';
            break;
    }
    return $weekday.', ngày '.date('d').' tháng '.date('m').' năm '.date('Y');
}
//---------------------------------------------------------------------------------
function nhatky($noidung)
{
    require './config/config.php';
  //  $thoigian=date('Y-m-d H:i:s');
    $id=$_SESSION['user_id'];
    $nhatky_sql="INSERT INTO `nhatky`(`nk_user`, `nk_noi_dung`) VALUES ('$id','$noidung')";
    $nhatky_query=mysqli_query($source,$nhatky_sql);
				
	//	khong can kiem tra loi
    //      if  ($nhatky_query) echo ("Ghi NK OK");
    //               else echo ('có lỗi khi ghi nhật ký. Mã ').mysqli_error($source);
    /*
    
    
    */
}
//---------------------------------------------------------------------------------
function checkadmin(){
    if (!isset($_SESSION['user_admin']))
    {
        header('location:./logout');
    }
}
//---------------------------------------------------------------------------------

//------------------------------------------------------------------------------
function getMaxsizeUpload(){
    // load maxsize up load từ file php.ini
    // tra ve gia trị maxupload tinh = Mb
    $max_size = -1;
    $files = array_merge(array(php_ini_loaded_file()), explode(",\n", php_ini_scanned_files()));
    foreach (array_filter($files) as $file) {
      $ini = parse_ini_file($file);
      $regex = '/^([0-9]+)([bkmgtpezy])$/i';
      if (!empty($ini['post_max_size']) && preg_match($regex, $ini['post_max_size'], $match)) {
        $post_max_size = round($match[1] * pow(1024, stripos('bkmgtpezy', strtolower($match[2]))));
        if ($post_max_size > 0) {
          $max_size = $post_max_size;
        }
      }
      if (!empty($ini['upload_max_filesize']) && preg_match($regex, $ini['upload_max_filesize'], $match)) {
        $upload_max_filesize = round($match[1] * pow(1024, stripos('bkmgtpezy', strtolower($match[2]))));
        if (($upload_max_filesize > 0) && ($max_size <= 0 || $max_size > $upload_max_filesize)) {
          $max_size = $upload_max_filesize;
        }
      }
    }
$max_size=$max_size/1024/1024;
return $max_size;
}
//---------------------------------------------------------------------------------
function token(){
   // substr(md5(rand()), 0, 7);
    return substr(md5(rand()), 0, 7);
}
//------------------------------
function encode2($data1,$data2){
    return $data1.$data2;
}
//------------------------------
function encode($data){
    return $_SESSION['token'].$data;
}
//------------------------------
function decode($data1){
    return intval(substr($data1,7,strlen($data1)-7));
}
//------------------------------
function decodetoken($data){
    return substr($data, 0, 7);
}
//---------------------------------------------
function get_user_ip() {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
}
function thanhTieuDe($ten,$mang){
    require './config/config.php';
    $user_id = intval($_SESSION['user_id']);
    $sql1='select * from login where log_id='.$user_id;
    $query=mysqli_query($source,$sql1);
    $member = mysqli_fetch_array( $query );
    $tieude=' <div class="container">
                <div class="row breadcrumb">
                    <div class="col-sm-8 text-left">
        <h3>'.$ten.'</h3>
        <ol class="breadcrumb remove_margin" >';
    for ($i=0; $i < count($mang); $i++) { 
        $link=$mang[$i]['link'];
        $name=$mang[$i]['name'];
        if($mang[$i]['active']==1){
            $tieude=$tieude.'<li class="breadcrumb-item active">'.$name.'</a></li> ';
        }
        else{
            $tieude=$tieude.'<li class="breadcrumb-item "><a href="./'.$link.'">'.$mang[$i]['name'].'</a> &#10095;</li>  '; //&#10095;
        }
        
    }
    $tieude=$tieude.'</ol>
    </div>
    <div class="col-sm-4 text-right">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user fa-1x"> </span> &nbsp;'.$member['log_name'].'
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
              <li class="active"><a class ="btn btn-block btn-secondary" href="./user_up">Cập nhật</a></li>
              <li class="active"><a class ="btn btn-block btn-secondary" href="./logout">Đăng xuất</a></li>
            </ul>
        </div>
        </div>
        </div>
        </div>';
    return $tieude;
}
 
function stripUnicode($str){
      if(!$str) return false;
      $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd'=>'đ',
            'D'=>'Đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' =>'?|(|)|[|]|{|}|#|%|-|<|>|,|:|;|.|&|–|/'
      );

      foreach($unicode as $khongdau=>$codau) {
         $arr=explode("|",$codau);
         $str = str_replace($arr,$khongdau,$str);
      }
      return $str;
   }

               
function changeTitle($str){
   $str = trim($str);
   if ($str=="") return "";
      $str =str_replace('"','',$str);
      $str =str_replace("'",'',$str);
      $str = stripUnicode($str);
      $str = mb_convert_case($str,MB_CASE_LOWER,'utf-8');    
      // MB_CASE_UPPER / MB_CASE_TITLE / MB_CASE_LOWER
      $str = str_replace(' ','-',$str);
      
   return $str;
}

?>