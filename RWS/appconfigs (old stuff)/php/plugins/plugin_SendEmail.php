<?php
/* NOTES:
1) Make sure that the file 'php_openssl.dll' is in directory C:\xampp\php\ext\ (or wherever else you have put it)
2) Make sure that the file 'php.ini' (in directory C:\XAMPP\php) contains the following line:
     extension=php_openssl.dll
   If you need to make changes to php.ini, then remember to reboot the Apache server.
3) Make sure the global variables (at the top of the function SendEmail) are available.
   Put them in the 'pluginsettings.php' file (same dir as 'dbsettings.php')
4) Make sure the class libraries 'class.phpmailer.php', 'class.pop3.php' and 'class.smtp.php' are available
*/

require_once __DIR__.'/lib/class.phpmailer.php';

function SendEmail($to,$subject,$message)
{ // adapted from http://phpmailer.worxware.com/?pg=examplebgmail
global $SendEmail_From;
global $SendEmail_Username;
global $SendEmail_Password;

ExecEngineWhispers('Username = '.$SendEmail_Username);

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
// $mail->SMTPDebug = 1;
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
$mail->Port = 587;
$mail->SMTPAuth = true;                               // Enable SMTP authentication

$mail->Username = $SendEmail_Username;                // SMTP username (for GMAIL)
$mail->Password = $SendEmail_Password;                // SMTP password

$mail->From = $SendEmail_From; 
$mail->FromName = 'Ampersand Prototype';

$mail->AddAddress($to);                               // Add a recipient, e.g. $to = 'rieks.joosten@tno.nl', 'Rieks Joosten'
$mail->Subject = $subject;
$mail->Body    = $message;

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters

   if(!$mail->Send())
   {  ExecEngineSays('Message could not be sent.');
      ExecEngineSays('Mailer Error: ' . $mail->ErrorInfo);
   } else
   {  ExecEngineSays('Email message sent.');
   }
}

?>