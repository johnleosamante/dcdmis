<?php
session_start();
include("../vendor/jquery/function.php");
/*$pass=md5($_POST['upass']);
mysql_query("UPDATE tbl_teacher_account SET tbl_teacher_account.Teacher_Password='".$pass."',Pass_status='Default' WHERE tbl_teacher_account.Teacher_TIN='".$_POST['uname']."'");
*/
require '../PHPMailer/PHPMailerAutoload.php';
require_once('../PHPMailer/class.phpmailer.php');
																					
$mail = new PHPMailer();
$body = '<a href="http://pcdmis.deped-pagadian.net/">View</a><br /><br />- DepEd Pagadian ICT Unit';
$mail->SetFrom('admin.ictu@deped-pagadian.net', 'DepEd Pagadian');
$mail->AddAddress('marlon.caduyac@deped.gov.ph');
$mail->Subject = 'Activation link';
$mail->AddReplyTo('admin.ictu@deped-pagadian.net');
						
																					
// set body of the message contents
$mail->MsgHTML($body);
//$mail->AddAttachment("Click to Activate your account!!");
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
if(!$mail->Send()) {
	$Err = "Emails not sent.";
}
	echo '<script>
{
	alert("Please Activate your Account using DepEd Email.");
	window.location.href="personnel.php";
}
</script>';

?>
