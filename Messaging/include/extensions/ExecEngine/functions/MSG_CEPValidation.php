<?php
// This extension provides the functions needed by MSG_CEPValidation.adl

// Enable Messaging extension: MSG_Validation
// Config::set('url', 'msg_validation', ''); // msg_validation URL where response needs to be filled in.

function CreateCvrNonce()
{	if (PHP_MAJOR_VERSION < 7) // 'random_int' only is available from PHP 7
	{ 	$nonce = rand(1,999999);
		if(!$nonce) throw new Exception(PHP_MAJOR_VERSION.' < 7: cound not create NONCE = rand(1,999999)', 500);
	} else 
	{ 	$nonce = random_int(1,999999);
	  	if(!$nonce) throw new Exception(PHP_MAJOR_VERSION.' >= 7: cound not create NONCE = random_int(1,999999)', 500);
	}
	if(!$nonce) throw new Exception("CreateCvrNonce - cound not generate NONCE", 500);
    return ($nonce);
}

function CreateCvrURLText()
{	$url = Config::get('url', 'msg_validation');
    Notifications::addLog('Using URL for filling in response: '.$url,'MESSAGING');
	return($url);
}

function CreateCvrMsgTitle($nonce)
{ 	if(!$nonce) throw new Exception("CreateCvrMsgTitle - cannot make TITLE as no nonce is provided", 500);
	Notifications::addLog('Created a challenge message for CEPValidation using ['.$nonce,'MESSAGING');
	return('Validation code: '.$nonce);
}

function CreateCvrMsgText($nonce)
{ 	if(!$nonce) throw new Exception("CreateCvrMsgText - cannot make TEXT as no nonce is provided", 500);
	return('Please enter the following number in the application: '.$nonce);
}

?>