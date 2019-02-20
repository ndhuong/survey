<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//require $base_url.'config/config.php';
function chuKyEmail(){
	$str='<br><br>----------------------------------------------------<br>
	<b>Nguyễn Đức Hưởng</b> - <i>Giám sát IT<i><br>
	<b>Khách sạn Mường Thanh Grand Hạ Long</b><br>
	Địa chỉ:<i> Ô 7, Lô 20, Đông Hùng Thắng, Bãi Cháy, Hạ Long, Quảng Ninh</i><br>
	Điện thoại:<i> 0203 381 24 68 /máy lẻ: 307 </i><br>
	Di động: <i>0984 227 446/ 0936 820 818</i><br>
	Email:<i> itofficer@halong.muongthanh.vn </i><br>
	<br>
	<u>Chú ý:</u> Đây là email được gửi tự động từ hệ thống. Vui lòng không trả lời email này.';
	return $str;
} // hết function chữ ký
//---------------------------------------------------------
function sendMail($nguoinhan,$noidung){
	/*
	$nguoinhan=Array(stt,Array('email','name'))
	$noidung=Array('tentau','noidung')

	*/
	//use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\Exception;

	$str=dirname(__FILE__);
	$arr=explode('\\', $str);
	$tmp=array_pop($arr);
	array_push($arr,'lib');
	$str=implode('\\', $arr);
	require_once $str.'\PHPMailer\src\Exception.php';
	require_once $str.'\PHPMailer\src\PHPMailer.php';
	require_once $str.'\PHPMailer\src\SMTP.php';

	if((count($nguoinhan)<1) || (count($noidung)<1)){
		$error=1;
		$status='Không có người nhận hoặc không có nội dung gửi';
	}
	else{
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
		    //Server settings
		    $mail->SMTPDebug = 0;                                 // Xuất thông báo lỗi, 0= ko xuất, 1 = client, 2= server & client
		    $mail->isSMTP();   
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'itgrandhalong.@gmail.com';                 // SMTP username
		    $mail->Password = 'Yenlan2013';                           // SMTP password
		    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 465;
		    $mail->SMTPOptions = array(
	    	'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    	)
			);           
		
		    //Recipients
		   $mail->setFrom('itgrandhalong@gmail.com', 'Email Thong bao tu he thong cua HLO');
		    //$mail->setFrom('sys@dongbacshin.com.vn', 'Email Thong bao tu DONGBACSHIN');
		   $tmp=count($nguoinhan); 
		   for($i=0;$i<$tmp;$i++){
		   		$mail->addAddress($nguoinhan[$i]['email'], $nguoinhan[$i]['name']);
		   }
		   //for ($//i=0; $i// < ; $i++) { 
		   	# code...
		   //}
		   // $mail->addAddress('ndhuong@dongbacshin.vn', 'Nguyen Duc Huong');     // Add a recipient
			 //   $mail->addAddress('ellen@example.com');               // Name is optional
			 //   $mail->addReplyTo('info@example.com', 'Information');
			 //   $mail->addCC('cc@example.com');
			 //   $mail->addBCC('bcc@example.com');

		    //Attachments
			//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//	    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->CharSet = 'UTF-8';
		    $mail->Encoding = 'base64';
		    $mail->Subject = $noidung['tieude'];
		    $mail->Body    = $noidung['noidung'].chuKyEmail();//'This is the HTML message body <b>in bold!</b>';
		    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		    $error=0;
		    $status='Email đã được gửi đi';
		} catch (Exception $e) {
			$error=2;
		    $status='Không gửi được email. Mô tả lỗi: '.$mail->ErrorInfo;
		}
	}
	$ketQua['error']=$error;
	$ketQua['status']=$status;
	return $ketQua;	

}// hết function sendEmail

?>