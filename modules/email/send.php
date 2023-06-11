<?php
//
// *** To Email ***
$to = 'johnleo.samante@deped.gov.ph';
//
// *** Subject Email ***
$subject = 'Localhost Test Email';
//
// *** Content Email ***
$content = 'This is an email from localhost server';
//
//*** Head Email ***
$headers = "From: support@depeddipolog.net\r\n";
//
//*** Show the result... ***
if (mail($to, $subject, $content, $headers))
{
	echo "Success !!!";
} 
else 
{
   	echo "ERROR";
}