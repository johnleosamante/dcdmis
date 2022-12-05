<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_employee SET tbl_employee.Emp_Email='".$_POST['uname']."' WHERE tbl_employee.Emp_ID='".$_SESSION['per_id']."'")or die ("error update Teacher");
$pass=md5($_POST['upass']);
mysqli_query($con,"INSERT INTO tbl_teacher_account VALUES(NULL,'".$_POST['uname']."','".$pass."','Offline','Default','".date('Y/m/d H:i:s')."')")or die ("error Teacher");
require '../PHPMailer/PHPMailerAutoload.php';
require_once('../PHPMailer/class.phpmailer.php');
																					
$mail = new PHPMailer();
$body = '<a href="http://pcdmis.deped-pagadian.net/" class="btn btn-success">Click to continue.</a><br /><br />- DepEd Email : '.$_POST['uname'].'<br/>Code: '.$_POST['upass'];
$mail->SetFrom('admin.ICTU@deped-pagadian.net', 'DepEd Pagadian');
$mail->AddAddress($_POST['uname']);
$mail->Subject = 'Activation Code';
$mail->AddReplyTo('joel.baterna@deped.gov.ph');
						
																					
// set body of the message contents
$mail->MsgHTML($body);
//$mail->AddAttachment("Click to Activate your account!!");
//$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
if(!$mail->Send()) {
	$Err = "Emails not sent.";
}
	echo '<script>
{
	alert("Please Activate your Account using DepEd Email.");
	window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("personnel")).'";
}
</script>';

?>