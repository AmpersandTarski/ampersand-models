<?php
define ('LOCALSETTINGS_VERSION', 1.2);
// Enable Messaging extension: MSG_Validation
  Config::set('url', 'msg_validation', ''); // msg_validation URL where response needs to be filled in.
  
// Enable Messaging extension: MSG_Email
require_once(__DIR__ . '/extensions/Messaging/Email.php');
   Config::set('sendEmailConfig', 'msg_email', array('from' => '', 'username' => '', 'password' => '')); // Note that the Gmail password is application specific since the account uses 2-factor authentication
// Config::set('alwaysNotifyUsers', 'msg_email', array('')); // array of email addresses that receive a copy of all notifications
  
// Enable Messaging extension: MSG_Pushover
require_once(__DIR__ . '/extensions/Messaging/Pushover.php');
   Config::set('applicationToken', 'msg_pushover', ''); // pushover application token
// Config::set('alwaysNotifyUsers', 'msg_pushover', array('')); // array of pushover user keys that receive a copy of all notifications

// Enable Messaging extension: MSG_Pushalot
require_once(__DIR__ . '/extensions/Messaging/Pushalot.php');
// Config::set('alwaysNotifyUsers', 'msg_pushalot', array('')); // array of pushalot user api keys that receive a copy of all notifications
  
// Enable Messaging extension: MSG_SMS
require_once(__DIR__ . '/extensions/Messaging/SMS.php');
  Config::set('sendSMSConfig', 'msg_SMS', array('username' => '', 'password' => '', 'sender' => '')); 
// Config::set('alwaysNotifyUsers', 'msg_SMS', array('')); // array of SMS phone numbers that receive a copy of all notifications

?>