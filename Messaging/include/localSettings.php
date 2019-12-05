<?php
define ('LOCALSETTINGS_VERSION', 1.2);

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", true);
date_default_timezone_set('Europe/Amsterdam');

/************ Server URL config ********************/
// Config::set('serverURL', 'global', 'http://www.yourdomain.nl'); // defaults to http://localhost/<ampersand context name>
// Config::set('apiPath', 'global', '/api/v1'); // relative path to api

/************ MySQL database config ****************/
// Config::set('dbHost', 'mysqlDatabase', 'localhost');
// Config::set('dbUser', 'mysqlDatabase', 'ampersand');
// Config::set('dbPassword', 'mysqlDatabase', 'ampersand');
// Config::set('dbName', 'mysqlDatabase', '');

Config::set('loginEnabled', 'global', true);

/************ EXTENSIONS ***************/
require_once(__DIR__ . '/extensions/ExecEngine/ExecEngine.php'); // Enable ExecEngine
require_once(__DIR__ . '/extensions/ExcelImport/ExcelImport.php'); // Enable ExcelImport

// Enable Messaging extension: MSG_Email
require_once(__DIR__ . '/extensions/Messaging/Email.php');
   Config::set('sendEmailConfig', 'msg_email', array('from' => 'noreply.ampersand@gmail.com', 'username' => 'noreply.ampersand@gmail.com', 'password' => 'ryyjfgxscrgcwxwn')); // Note that the Gmail password is application specific since the account uses 2-factor authentication
  Config::set('alwaysNotifyUsers', 'msg_email', array('')); // array of email addresses that receive a copy of all notifications
  
// Enable Messaging extension: MSG_Pushover
require_once(__DIR__ . '/extensions/Messaging/Pushover.php');
  Config::set('applicationToken', 'msg_pushover', 'aDfdHnCFQ4XHr8FBJ9kmHML94n1NLR'); // pushover application token
  Config::set('alwaysNotifyUsers', 'msg_pushover', array('ufoaKLBxhPxdiECpxtxhdjqdSMyfDD')); // array of pushover user keys that receive a copy of all notifications

// Enable Messaging extension: MSG_Pushalot
require_once(__DIR__ . '/extensions/Messaging/Pushalot.php');
  Config::set('alwaysNotifyUsers', 'msg_pushalot', array('')); // array of pushalot user api keys that receive a copy of all notifications
  
// Enable Messaging extension: MSG_Validation
  Config::set('url', 'msg_validation', 'http://ampersand/Messaging/#/People'); // msg_validation URL where response needs to be filled in.
  
// Enable Messaging extension: MSG_SMS
require_once(__DIR__ . '/extensions/Messaging/SMS.php');
  Config::set('sendSMSConfig', 'msg_SMS', array('username' => 'Naisunev', 'password' => 'Urb4nFl00d', 'sender' => 'noreply.ampersand')); 

?>