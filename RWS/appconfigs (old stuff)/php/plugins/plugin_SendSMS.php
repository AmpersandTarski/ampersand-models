<?php
/* NOTES:
1) Make sure the global variables (at the top of the function SendEmail) are available.
   Put them in the 'pluginsettings.php' file (same dir as 'dbsettings.php')
2) Make sure the line containing '$sms->setTest(true);' is (un)commented as to what behaviour you need.
3) Make sure the library 'class.Messagebird.php' is available in the 'lib' directory.
*/

require_once __DIR__.'/lib/class.MessageBird.php';

function SendSMS ($phonenumber,$message)
{ 
global $SendSMS_Username;
global $SendSMS_Password;

ExecEngineWhispers('Username = '.$SendSMS_Username);

// Set the Messabeird username and password, and create an instance of the MessageBird class
$sms = new MessageBird($SendSMS_Username, $SendSMS_Password);

// Set the sender, could be a number (16 numbers) or letters (11 characters)
$sms->setSender('AmProtoType');

// Add the destination mobile number.
// This method can be called several times to add have more then one recipient for the same message
$sms->addDestination($phonenumber); //e.g. $sms->addDestination('31600000000');

// Set an reference, optional
// $sms->setReference('123456789');

// Set a schedule date-time, optional
// $sms->setTimestamp('2014-01-01 10:02');

// Replace non GSM-7 characters by appropriate valid GSM-7 characters
// $sms->setReplacechars(false);

// If you want a dlr notification of the message send to another url then that you have set on the web site, you can use this parameter. Don't forget to set a reference!
// $sms->setDlrUrl('http://www.example.com/dlr_url.php');

// If $test is TRUE, then the message is not actually sent or scheduled, and there will be no credits deducted.
// $sms->setTest(true);

// Send the message to the destination(s)
$sms->sendSms($message);

ExecEngineSays ("Response:");
ExecEngineSays ($sms->getResponseCode());
ExecEngineSays ($sms->getResponseMessage());
ExecEngineSays ($sms->getCreditBalance());
}

?>